<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Compiler;

use Parthenon\Common\RequestHandler\RequestHandlerManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CommonCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->handle($container, RequestHandlerManager::class, 'parthenon.common.request_handler', 'addRequestHandler');
    }
}
