<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Logging\Monolog;

final class ProcessIdGenerator
{
    private string $processId;

    public function __construct()
    {
        $this->processId = \sha1(\microtime());
    }

    public function getProcessId(): string
    {
        return $this->processId;
    }
}
