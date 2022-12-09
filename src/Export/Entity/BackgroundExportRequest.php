<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Entity;

use Parthenon\Export\ExportRequest;

class BackgroundExportRequest extends ExportRequest
{
    private $id;

    private ?string $exportedFile = null;

    private ?string $exportedFilePath = null;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    public static function createFromExportRequest(ExportRequest $request)
    {
        $self = new static($request->getFilename(), $request->getExportFormat(), $request->getDataProviderService(), $request->getDataProviderParameters());
        $now = new \DateTime();
        $self->createdAt = $now;
        $self->updatedAt = $now;

        return $self;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getExportedFile(): ?string
    {
        return $this->exportedFile;
    }

    public function setExportedFilePath(string $exportFilePath): void
    {
        $this->exportedFilePath = $exportFilePath;
    }

    public function getExportedFilePath(): ?string
    {
        return $this->exportedFilePath;
    }

    public function setExportedFile(?string $exportedFile): void
    {
        $this->exportedFile = $exportedFile;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
