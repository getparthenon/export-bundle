<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Messenger;

use Parthenon\Notification\Email;
use Parthenon\Notification\EmailSenderInterface;
use PHPUnit\Framework\TestCase;

class SenderHandlerTest extends TestCase
{
    public function testCallSenders()
    {
        $email = new Email();
        $sender = $this->createMock(EmailSenderInterface::class);
        $sender->expects($this->once())->method('send')->with($email);

        $handler = new SenderHandler($sender);
        $handler($email);
    }
}
