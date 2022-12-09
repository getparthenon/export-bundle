<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Factory;

use League\Flysystem\Filesystem;
use Parthenon\Common\Exception\Upload\InvalidUploadConfigurationException;
use Parthenon\Common\Upload\FlysystemUploader;
use Parthenon\Common\Upload\Naming\Factory as NamingFactory;
use Parthenon\Common\Upload\UploaderInterface;

final class FlysystemFactory implements FactoryInterface
{
    public function __construct(private FlySystemAdapterFactoryInterface $flySystemAdapterFactory, private NamingFactory $factory)
    {
    }

    public function build(array $config): UploaderInterface
    {
        if (!isset($config['provider'])) {
            throw new InvalidUploadConfigurationException('There is no provider defined.');
        }

        if (!isset($config['naming_strategy'])) {
            throw new InvalidUploadConfigurationException('There is no naming_strategy defined.');
        }

        if (!isset($config['url'])) {
            throw new InvalidUploadConfigurationException('There is no url defined.');
        }

        $adapter = $this->flySystemAdapterFactory->getAdapter($config);

        $namingStrategy = $this->factory->getStrategy($config['naming_strategy']);
        $flysystem = new Filesystem($adapter);

        return new FlysystemUploader($flysystem, $namingStrategy, $config['url']);
    }
}
