<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Engine;

use Parthenon\Export\Exception\ExportFailedException;
use Parthenon\Export\ExportRequest;
use Parthenon\Export\ExportResponseInterface;

interface EngineInterface
{
    /**
     * @throws ExportFailedException
     */
    public function process(ExportRequest $exportRequest): ExportResponseInterface;
}
