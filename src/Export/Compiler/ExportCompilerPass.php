<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Compiler;

use Parthenon\Common\Compiler\AbstractCompilerPass;
use Parthenon\Export\Exporter\ExporterManager;
use Parthenon\Export\Normaliser\NormaliserManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ExportCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->handle($container, NormaliserManager::class, 'parthenon.export.normaliser', 'addNormaliser');
        $this->handle($container, ExporterManager::class, 'parthenon.export.exporter', 'addExporter');

        $this->handleDataProviders($container);
    }

    public function handleDataProviders(ContainerBuilder $container)
    {
        $definitions = $container->findTaggedServiceIds('parthenon.export.data_provider');

        foreach ($definitions as $id => $definitionData) {
            $definition = $container->getDefinition($id);
            $definition->setPublic(true);
            // Just to be safe, even though it should be the same object returned by reference, overwrite it.
            $container->setDefinition($id, $definition);
        }
    }
}
