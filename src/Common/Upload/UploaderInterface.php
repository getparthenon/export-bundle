<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    public const PROVIDER_S3 = 's3';

    public const PROVIDER_LOCAL = 'local';

    public function uploadString(string $filename, string $contents): File;

    public function uploadUploadedFile(UploadedFile $file): File;

    public function deleteFile(File $file): void;

    /**
     * @return resource
     */
    public function readFile(File $file);
}
