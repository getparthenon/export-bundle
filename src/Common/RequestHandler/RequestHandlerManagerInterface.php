<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\RequestHandler;

use Parthenon\Common\Exception\RequestProcessor\NoValidRequestHandlerException;
use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerManagerInterface
{
    /**
     * @throws NoValidRequestHandlerException
     */
    public function getRequestHandler(Request $request): RequestHandlerInterface;
}
