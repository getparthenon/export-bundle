<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Http;

use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface extends PsrClientInterface
{
    public function sendRequest(RequestInterface $request, array $options = []): ResponseInterface;
}
