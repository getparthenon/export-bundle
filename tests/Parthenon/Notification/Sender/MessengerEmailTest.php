<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Sender;

use Parthenon\Notification\Email;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBus;

class MessengerEmailTest extends TestCase
{
    public function testSendsToMessageBus()
    {
        $messageBus = $this->createMock(MessageBus::class);
        $email = new Email();

        $messageBus->expects($this->once())->method('dispatch')->with($email);

        $messagerSender = new MessengerEmailSender($messageBus);
        $messagerSender->send($email);
    }
}
