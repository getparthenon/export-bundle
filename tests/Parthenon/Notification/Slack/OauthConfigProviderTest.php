<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Slack;

use Chadhutchins\OAuth2\Client\Provider\Slack;
use League\OAuth2\Client\Token\AccessTokenInterface;
use PHPUnit\Framework\TestCase;

class OauthConfigProviderTest extends TestCase
{
    public function testCallsProviderAndReturnsArray()
    {
        $slack = $this->createMock(Slack::class);
        $accessToken = $this->createMock(AccessTokenInterface::class);

        $output = ['team' => ['name' => 'Test Name']];

        $slack->method('getAccesstoken')->with('authorization_code', ['code' => 'the_code'])->willReturn($accessToken);
        $accessToken->method('getValues')->willReturn($output);

        $oauthConfigProvider = new OauthConfigProvider($slack);
        $actual = $oauthConfigProvider->getAppData('the_code');

        $this->assertEquals($output, $actual);
    }
}
