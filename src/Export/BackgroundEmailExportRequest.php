<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Parthenon\Export;

use Symfony\Component\Security\Core\User\UserInterface;

class BackgroundEmailExportRequest extends ExportRequest
{
    protected UserInterface $user;

    public static function createFromExportRequest(ExportRequest $exportRequest, UserInterface $user): static
    {
        $self = new static($exportRequest->getFilename(), $exportRequest->getExportFormat(), $exportRequest->getDataProviderService(), $exportRequest->getDataProviderParameters());
        $self->user = $user;

        return $self;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
