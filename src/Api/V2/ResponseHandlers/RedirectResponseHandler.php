<?php

namespace App\Api\V2\ResponseHandlers;

use App\Api\V2\AuthenticationRequest;
use League\OAuth2\Server\ResponseTypes\RedirectResponse;

/**
 * Class RedirectResponseHandler
 * @package App\Api\V2\ResponseHandlers
 */
class RedirectResponseHandler
{

    /**
     * @param AuthenticationRequest $authenticationRequest
     * @return bool
     */
    public function canRespondToAuthorizationRequest(AuthenticationRequest $authenticationRequest): bool
    {
        return
            $authenticationRequest->getResponseMode() === null ||
            $authenticationRequest->getResponseMode() === 'fragment' ||
            $authenticationRequest->getResponseMode() === 'form_post' ||
            $authenticationRequest->getResponseMode() === 'query';
    }

    /**
     * @param AuthenticationRequest $authenticationRequest
     * @param $code
     * @return RedirectResponse
     */
    public function generateResponse(AuthenticationRequest $authenticationRequest, $code): RedirectResponse
    {
        $queryDelimiter = '?';

        if ($authenticationRequest->getResponseMode() === 'fragment' ||
            strpos($authenticationRequest->getResponseType(), 'code') === false
        ) {
            $queryDelimiter = '#';
        }

        if ($authenticationRequest->getResponseMode() === 'query') {
            $queryDelimiter = '?';
        }

        $response = new RedirectResponse();
        $response->setRedirectUri(
            $this->makeRedirectUri(
                $authenticationRequest->getRedirectUri(),
                [
                    'code' => $code,
                    'state' => $authenticationRequest->getState(),
                ],
                $queryDelimiter
            )
        );
        return $response;
    }

    /**
     * @param $uri
     * @param array $params
     * @param string $queryDelimiter
     * @return string
     */
    public function makeRedirectUri($uri, array $params = [], string $queryDelimiter = '?'): string
    {
        $uri .= (strpos($uri, $queryDelimiter) === false) ? $queryDelimiter : '&';

        return $uri . http_build_query($params);
    }
}
