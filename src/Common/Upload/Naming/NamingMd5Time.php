<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Naming;

final class NamingMd5Time implements NamingStrategyInterface
{
    public function getName(string $filename): string
    {
        $parts = explode('.', $filename);
        $fileType = end($parts);

        return md5($filename).'-'.time().'.'.$fileType;
    }
}
