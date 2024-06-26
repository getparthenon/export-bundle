<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Parthenon\Notification\Slack;

use Parthenon\Common\Http\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class WebhookPosterTest extends TestCase
{
    public const WEBHOOK = 'http://slack.example.org';
    public const JSON = ['data' => 'here'];

    public function testCallsClientWithRequest()
    {
        $client = $this->createMock(ClientInterface::class);
        $client->expects($this->once())->method('sendRequest')->with($this->callback(function (RequestInterface $request) {
            $request->getBody()->rewind();

            return 'POST' == $request->getMethod() && self::WEBHOOK == (string) $request->getUri() && json_encode(self::JSON) == (string) $request->getBody()->getContents();
        }));

        $webhookPoster = new WebhookPoster($client);
        $webhookPoster->send(self::WEBHOOK, self::JSON);
    }
}
