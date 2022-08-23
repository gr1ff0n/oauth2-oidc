<?php

namespace App\Api\V2;

use League\OAuth2\Server\RequestTypes\AuthorizationRequest;

/**
 * Class AuthenticationRequest
 * @package App\Api\V2
 */
class AuthenticationRequest extends AuthorizationRequest
{
    /**
     * @var string|null
     */
    protected ?string $nonce;
    /**
     * @var
     */
    protected $prompt;
    /**
     * @var
     */
    protected $maxAge;
    /**
     * @var array
     */
    protected array $uiLocates = []; //(space-separated list of BCP47 [RFC5646] language tag)
    /**
     * @var
     */
    protected $idTokenHint;
    /**
     * @var
     */
    protected $loginHint;
    /**
     * @var
     */
    protected $display;
    /**
     * @var array
     */
    protected array $acrValues = [];
    /**
     * @var string|null
     */
    protected ?string $responseType = null;
    /**
     * @var string|null
     */
    protected ?string $responseMode = null; // query, fragment,
    /**
     * @var array|null
     */
    protected ?array $claims = [];

    /**
     * @var SessionInformation
     */
    protected SessionInformation $sessionInformation;

    /**
     * @param AuthorizationRequest $authorizationRequest
     * @return AuthenticationRequest
     */
    public static function fromAuthorizationRequest(AuthorizationRequest $authorizationRequest): AuthenticationRequest
    {
        if ($authorizationRequest instanceof AuthenticationRequest) {
            return $authorizationRequest;
        }

        $result = new self();

        $result->setClient($authorizationRequest->getClient());
        $result->setCodeChallenge($authorizationRequest->getCodeChallenge());
        $result->setCodeChallengeMethod($authorizationRequest->getCodeChallengeMethod());
        $result->setGrantTypeId($authorizationRequest->getGrantTypeId());
        $result->setRedirectUri($authorizationRequest->getRedirectUri());
        $result->setScopes($authorizationRequest->getScopes());
        $result->setState($authorizationRequest->getState());

        if ($authorizationRequest->getUser() !== null) {
            $result->setUser($authorizationRequest->getUser());
        }

        return $result;
    }

    /**
     * @param SessionInformation $sessionInformation
     * @return $this
     */
    public function setSessionInformation(SessionInformation $sessionInformation): AuthenticationRequest
    {
        $this->sessionInformation = $sessionInformation;

        return $this;
    }

    /**
     * @return SessionInformation
     */
    public function getSessionInformation(): SessionInformation
    {
        return $this->sessionInformation ?? new SessionInformation();
    }

    /**
     * @return string|null
     */
    public function getNonce(): ?string
    {
        return $this->nonce;
    }

    /**
     * @param string|null $nonce
     */
    public function setNonce(?string $nonce): void
    {
        $this->nonce = $nonce;
    }

    /**
     * @param $prompt
     * @return void
     */
    public function setPrompt($prompt): void
    {
        $this->prompt = $prompt;
    }

    /**
     * @return mixed
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param $maxAge
     * @return void
     */
    public function setMaxAge($maxAge): void
    {
        $this->maxAge = $maxAge;
    }

    /**
     * @return mixed
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * @param array $uiLocales
     * @return void
     */
    public function setUILocales(array $uiLocales): void
    {
        $this->uiLocates = $uiLocales;
    }

    /**
     * @return array
     */
    public function getUILocales(): array
    {
        return $this->uiLocates;
    }

    /**
     * @param $idTokenHint
     * @return void
     */
    public function setIDTokenHint($idTokenHint)
    {
        $this->idTokenHint = $idTokenHint;
    }

    /**
     * @return mixed
     */
    public function getIDTokenHint()
    {
        return $this->idTokenHint;
    }

    /**
     * @param $loginHint
     * @return void
     */
    public function setLoginHint($loginHint): void
    {
        $this->loginHint = $loginHint;
    }

    /**
     * @return mixed
     */
    public function getLoginHint()
    {
        return $this->loginHint;
    }

    /**
     * @param $display
     * @return void
     */
    public function setDisplay($display): void
    {
        $this->display = $display;
    }

    /**
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param array $acrValues
     * @return void
     */
    public function setAcrValues(array $acrValues): void
    {
        $this->acrValues = $acrValues;
    }

    /**
     * @return array
     */
    public function getAcrValues()
    {
        return $this->acrValues;
    }

    /**
     * @param array|null $claims
     * @return void
     */
    public function setClaims(?array $claims): void
    {
        $this->claims = $claims;
    }

    /**
     * @return array|null
     */
    public function getClaims(): ?array
    {
        return $this->claims;
    }

    /**
     * Get the value of responseType
     */
    public function getResponseType(): ?string
    {
        return $this->responseType;
    }

    /**
     * Set the value of responseType
     *
     * @param $responseType
     * @return  self
     */
    public function setResponseType($responseType): AuthenticationRequest
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * Get the value of responseType
     */
    public function getResponseMode(): ?string
    {
        return $this->responseMode;
    }

    /**
     * Set the value of responseType
     *
     * @param $responseMode
     * @return  self
     */
    public function setResponseMode($responseMode): AuthenticationRequest
    {
        $this->responseMode = $responseMode;

        return $this;
    }
}
