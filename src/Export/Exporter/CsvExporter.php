<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Exporter;

class CsvExporter implements ExporterInterface
{
    public const EXPORT_FORMAT = 'csv';

    public function getMimeType(): string
    {
        return 'text/csv';
    }

    public function getOutput(array $input): mixed
    {
        $columns = [];
        $index = 0;
        foreach ($input as $row) {
            foreach ($row as $key => $value) {
                if (!isset($columns[$key])) {
                    $columns[$key] = $index;
                    ++$index;
                }
            }
        }

        $fp = fopen('php://memory', 'w');
        fputcsv($fp, array_keys($columns));

        foreach ($input as $row) {
            $csvRow = [];
            foreach ($row as $columnName => $value) {
                $index = $columns[$columnName];
                $csvRow[$index] = $value;
            }
            $outputRow = $this->populate($columns, $csvRow);
            fputcsv($fp, $outputRow);
        }

        fseek($fp, 0);

        return stream_get_contents($fp);
    }

    public function getFilename(string $name): string
    {
        return sprintf('%s.csv', $name);
    }

    public function getFormat(): string
    {
        return self::EXPORT_FORMAT;
    }

    private function populate(array $columns, array $row): array
    {
        foreach ($columns as $columnName => $key) {
            if (!isset($row[$key])) {
                $row[$key] = null;
            }
        }
        ksort($row);

        return $row;
    }
}
