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

use Nyholm\Psr7\Request;
use Nyholm\Psr7\Stream;
use Parthenon\Common\Http\ClientInterface;

final class WebhookPoster implements WebhookPosterInterface
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(string $webhook, array $message)
    {
        $request = new Request('POST', $webhook, ['Content-Type' => 'application/json']);
        $request = $request->withBody(Stream::create(json_encode($message)));
        $this->client->sendRequest($request);
    }
}
