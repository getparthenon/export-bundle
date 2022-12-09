<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Exporter;

interface ExporterInterface
{
    public function getFormat(): string;

    public function getMimeType(): string;

    public function getFilename(string $name): string;

    public function getOutput(array $input): mixed;
}
