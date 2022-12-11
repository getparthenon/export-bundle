<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
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
