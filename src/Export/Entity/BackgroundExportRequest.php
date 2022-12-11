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
