<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Exporter;

use Parthenon\Export\Exception\NoExporterFoundException;
use Parthenon\Export\ExportRequest;

final class ExporterManager implements ExporterManagerInterface
{
    /**
     * ExporterManager constructor.
     *
     * @param ExporterInterface[] $exporters
     */
    public function __construct(private array $exporters = [])
    {
    }

    public function getExporter(ExportRequest $exportRequest): ExporterInterface
    {
        foreach ($this->exporters as $exporter) {
            if ($exporter->getFormat() === $exportRequest->getExportFormat()) {
                return $exporter;
            }
        }

        throw new NoExporterFoundException(sprintf("No exporter for type '%s'", $exportRequest->getExportFormat()));
    }

    public function addExporter(ExporterInterface $exporter): void
    {
        $this->exporters[] = $exporter;
    }

    public function getFormats(): array
    {
        $output = [];

        foreach ($this->exporters as $exporter) {
            $output[] = $exporter->getFormat();
        }

        return $output;
    }
}
