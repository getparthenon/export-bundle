<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Slack;

use Chadhutchins\OAuth2\Client\Provider\Slack;

class OauthConfigProvider implements ConfigProviderInterface
{
    public function __construct(private Slack $provider)
    {
    }

    public function getAppData(string $code): array
    {
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        return $token->getValues();
    }
}
