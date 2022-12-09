<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Guzzle7Client implements ClientInterface
{
    private GuzzleClientInterface $client;

    public function __construct(GuzzleClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendRequest(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->client->send($request, $options);
    }
}
