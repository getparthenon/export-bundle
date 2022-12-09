<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\DataProvider;

use Parthenon\Export\ExportRequest;

interface DataProviderFetcherInterface
{
    public function getDataProvider(ExportRequest $request): DataProviderInterface;
}
