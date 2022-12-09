<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export;

class ExportRequest
{
    public function __construct(
        protected string $filename,
        protected string $exportFormat,
        protected string $dataProviderService,
        protected array $dataProviderParameters = [],
    ) {
    }

    public function getExportFormat(): string
    {
        return $this->exportFormat;
    }

    public function getDataProviderService(): string
    {
        return $this->dataProviderService;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getDataProviderParameters(): array
    {
        return $this->dataProviderParameters;
    }
}
