<?php

namespace App\Api\V2\Grant;

use App\Api\V2\Entities\IdTokenEntity;
use App\Api\V2\Entities\Interfaces\UserEntityInterface;
use App\Api\V2\Repositories\Interfaces\AccessTokenRepositoryInterface;
use App\Api\V2\Repositories\Interfaces\ClaimRepositoryInterface;
use App\Api\V2\ResponseTypes\BearerTokenResponse;
use App\Api\V2\Session;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\RequestEvent;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PasswordGrant
 * @package App\Api\V2\Grant
 */
class PasswordGrant extends \League\OAuth2\Server\Grant\PasswordGrant
{
    use OIDCTrait;

    /**
     * @var DateInterval
     */
    protected DateInterval $authCodeTTL;

    /**
     * @var DateInterval
     */
    protected DateInterval $idTokenTTL;

    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @var ClaimRepositoryInterface
     */
    protected ClaimRepositoryInterface $claimRepository;

    /**
     * @var AccessTokenRepositoryInterface
     */
    protected $accessTokenRepository;

    /**
     * @var UserEntityInterface|null
     */
    protected ?UserEntityInterface $user;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     * @param ClaimRepositoryInterface $claimRepository
     * @param Session $session
     * @param DateInterval $authCodeTTL
     * @param DateInterval $idTokenTTL
     */
    public function __construct(
        UserRepositoryInterface         $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        ClaimRepositoryInterface        $claimRepository,
        Session                         $session,
        DateInterval                    $authCodeTTL,
        DateInterval                    $idTokenTTL
    ) {
        parent::__construct($userRepository, $refreshTokenRepository);

        $this->claimRepository = $claimRepository;

        $this->authCodeTTL = $authCodeTTL;
        $this->idTokenTTL = $idTokenTTL;
        $this->session = $session;


        $this->setIssuer('https://' . SITE_SERVER_NAME);
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'password_oidc';
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function canRespondToAccessTokenRequest(ServerRequestInterface $request): bool
    {
        $requestParameters = (array)$request->getParsedBody();
        $scopes = ($requestParameters && isset($requestParameters['scope'])) ? $requestParameters['scope'] : null;

        return ($scopes && in_array('openid', explode(' ', $scopes), true));
    }

    /**
     * {@inheritdoc}
     * @throws OAuthServerException|\JsonException
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface  $responseType,
        DateInterval           $accessTokenTTL
    ): ResponseTypeInterface {

        /**
         * @var BearerTokenResponse $result
         */
        $result = parent::respondToAccessTokenRequest($request, $responseType, $accessTokenTTL);

        // Validate request
        $client = $this->validateClient($request);
        $nonce = $this->getRequestParameter('nonce', $request, null);

        $idToken = new IdTokenEntity();
        $idToken->setIssuer($this->getIssuer());
        $idToken->setSubject($this->user->getIdentifier());
        $idToken->setAudience($client->getIdentifier());
        $idToken->setIdentified($client->getIdentifier() . $this->user->getIdentifier());
        $idToken->setExpiration(DateTimeImmutable::createFromMutable((new DateTime())->add($this->idTokenTTL)));
        $idToken->setIat(new DateTimeImmutable());

        $idToken->setAuthTime(new DateTime());
        $idToken->setNonce($nonce);

        $result->setIdToken($idToken);

        return $result;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ClientEntityInterface $client
     *
     * @return UserEntityInterface
     * @throws OAuthServerException
     *
     */
    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client): UserEntityInterface
    {
        $username = $this->getRequestParameter('username', $request);

        if (!is_string($username)) {
            throw OAuthServerException::invalidRequest('username');
        }

        $password = $this->getRequestParameter('password', $request);

        if (!is_string($password)) {
            throw OAuthServerException::invalidRequest('password');
        }

        $this->user = $this->userRepository->getUserEntityByUserCredentials(
            $username,
            $password,
            $this->getIdentifier(),
            $client
        );

        if ($this->user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidCredentials();
        }

        return $this->user;
    }
}
