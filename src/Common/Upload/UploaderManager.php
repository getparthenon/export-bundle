<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload;

use Parthenon\Common\Exception\Upload\NoUploaderFoundException;
use Parthenon\Common\Upload\Factory\FactoryInterface;

final class UploaderManager implements UploadManagerInterface
{
    public function __construct(private array $configs, private FactoryInterface $factory)
    {
    }

    public function getUploader(string $name = 'default'): UploaderInterface
    {
        if ('default' === $name && 1 === count($this->configs)) {
            $config = current($this->configs);
        } elseif (!isset($this->configs[$name])) {
            throw new NoUploaderFoundException(sprintf('There is no uploader by the name "%s".', $name));
        } else {
            $config = $this->configs[$name];
        }

        return $this->factory->build($config);
    }
}
