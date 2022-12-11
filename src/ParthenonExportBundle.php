<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use Parthenon\Common\Compiler\CommonCompilerPass;
use Parthenon\Export\Compiler\ExportCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ParthenonExportBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $mappings = [
            realpath(__DIR__.'/Resources/config/doctrine-mapping/Common') => 'Parthenon\Common',
            realpath(__DIR__.'/Resources/config/doctrine-mapping/Export') => 'Parthenon\Export\Entity',
        ];

        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['DoctrineBundle'])) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, ['parthenon.orm']));
        }

        if (isset($bundles['DoctrineMongoDBBundle'])) {
            $container->addCompilerPass(DoctrineMongoDBMappingsPass::createXmlMappingDriver($mappings, ['parthenon.mongodb']));
        }

        $container->addCompilerPass(new CommonCompilerPass());
        $container->addCompilerPass(new ExportCompilerPass());
    }
}
