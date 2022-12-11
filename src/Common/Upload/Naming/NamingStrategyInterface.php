<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Naming;

interface NamingStrategyInterface
{
    public const MD5_TIME = 'md5_time';

    public const RANDOM_TIME = 'random_time';

    public function getName(string $filename): string;
}
