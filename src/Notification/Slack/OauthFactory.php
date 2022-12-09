<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Slack;

use Chadhutchins\OAuth2\Client\Provider\Slack;

class OauthFactory
{
    public function __construct(private string $clientId, private string $clientSecret, private string $redirectUrl)
    {
    }

    public function getProvider(): Slack
    {
        return new \Chadhutchins\OAuth2\Client\Provider\Slack([
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri' => $this->redirectUrl,
        ]);
    }
}
