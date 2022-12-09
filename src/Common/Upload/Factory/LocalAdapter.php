<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Factory;

use League\Flysystem\Local\LocalFilesystemAdapter;
use Parthenon\Common\Exception\Upload\InvalidUploadConfigurationException;

class LocalAdapter implements LocalAdapterInterface
{
    public function build(array $config): LocalFilesystemAdapter
    {
        if (!isset($config['local']['path'])) {
            throw new InvalidUploadConfigurationException('Path is required for local');
        }

        return new LocalFilesystemAdapter($config['local']['path']);
    }
}
