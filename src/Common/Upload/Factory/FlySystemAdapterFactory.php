<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Factory;

use League\Flysystem\FilesystemAdapter;
use Parthenon\Common\Exception\Upload\InvalidUploadConfigurationException;
use Parthenon\Common\Exception\Upload\NoUploadProviderFoundException;
use Parthenon\Common\Upload\UploaderInterface;

final class FlySystemAdapterFactory implements FlySystemAdapterFactoryInterface
{
    public function __construct(private S3AdapterInterface $s3Adapter, private LocalAdapterInterface $localAdapter)
    {
    }

    public function getAdapter($config): FilesystemAdapter
    {
        if (!isset($config['provider'])) {
            throw new InvalidUploadConfigurationException('There is no provider defined.');
        }

        switch ($config['provider']) {
            case UploaderInterface::PROVIDER_S3:
                return $this->s3Adapter->build($config);
            case UploaderInterface::PROVIDER_LOCAL:
                return $this->localAdapter->build($config);
            default:
                throw new NoUploadProviderFoundException(sprintf('There is no provider for "%s"', $config['provider']));
        }
    }
}
