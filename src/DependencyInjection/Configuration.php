<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.1.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\DependencyInjection;

use Parthenon\DependencyInjection\Modules\Common;
use Parthenon\DependencyInjection\Modules\Export;
use Parthenon\DependencyInjection\Modules\Notification;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('parthenon');

        $children = $treeBuilder->getRootNode()
                ->children();


        $common = new Common();
        $common->addConfig($children);

        $export = new Export();
        $export->addConfig($children);

        $notifcation = new Notification();
        $notifcation->addConfig($children);

        $children->end();

        return $treeBuilder;
    }
}
