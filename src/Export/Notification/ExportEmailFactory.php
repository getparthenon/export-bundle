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

namespace Parthenon\Export\Notification;

use Parthenon\Common\FieldAccesorTrait;
use Parthenon\Export\BackgroundEmailExportRequest;
use Parthenon\Notification\Email;

class ExportEmailFactory implements ExportEmailFactoryInterface
{
    use FieldAccesorTrait;

    public function buildEmail(BackgroundEmailExportRequest $exportRequest): Email
    {
        $user = $exportRequest->getUser();

        $emailAddress = $this->getFieldData($user, 'email');
        $email = new Email();
        $email->setToAddress($emailAddress);
        $email->setSubject('Export');
        $email->setContent('See attached');

        return $email;
    }
}
