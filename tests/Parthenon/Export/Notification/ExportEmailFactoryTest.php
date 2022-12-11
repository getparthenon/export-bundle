<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Notification;

use Parthenon\Export\BackgroundEmailExportRequest;
use Parthenon\Export\ExportRequest;
use Parthenon\Notification\Email;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class ExportEmailFactoryTest extends TestCase
{
    public function testEmail()
    {
        $user = new class() implements UserInterface {
            public function getRoles(): array
            {
                return [];
            }

            public function eraseCredentials()
            {
                // TODO: Implement eraseCredentials() method.
            }

            public function getUserIdentifier(): string
            {
                return 'iain.cambridge@example.org';
            }

            public function getEmail(): string
            {
                return 'iain.cambridge@example.org';
            }
        };

        $exportRequest = new ExportRequest('filename', 'csv', 'service', []);

        $backgroundEmailexport = BackgroundEmailExportRequest::createFromExportRequest($exportRequest, $user);

        $subject = new ExportEmailFactory();
        $this->assertInstanceOf(Email::class, $subject->buildEmail($backgroundEmailexport));
    }
}
