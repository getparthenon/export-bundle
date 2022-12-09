<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload;

final class File
{
    private string $path;
    private string $filename;

    public function __construct(string $path, string $filename = '')
    {
        $this->path = $path;
        if (empty($filename)) {
            $this->filename = $path;
        } else {
            $this->filename = $filename;
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
