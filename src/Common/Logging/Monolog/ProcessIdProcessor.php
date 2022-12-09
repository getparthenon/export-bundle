<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Logging\Monolog;

use Monolog\Processor\ProcessorInterface;

final class ProcessIdProcessor implements ProcessorInterface
{
    private ProcessIdGenerator $processIdGenerator;

    public function __construct(ProcessIdGenerator $processIdGenerator)
    {
        $this->processIdGenerator = $processIdGenerator;
    }

    public function __invoke(array $record): array
    {
        $record['extra']['process_id'] = $this->processIdGenerator->getProcessId();

        return $record;
    }
}
