<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Parthenon\Common\Logging\Monolog;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

final class ProcessIdProcessor implements ProcessorInterface
{
    private ProcessIdGenerator $processIdGenerator;

    public function __construct(ProcessIdGenerator $processIdGenerator)
    {
        $this->processIdGenerator = $processIdGenerator;
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record['extra']['process_id'] = $this->processIdGenerator->getProcessId();

        return $record;
    }
}
