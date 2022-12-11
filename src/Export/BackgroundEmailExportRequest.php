<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
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
