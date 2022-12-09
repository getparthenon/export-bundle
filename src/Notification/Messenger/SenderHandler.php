<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Messenger;

use Parthenon\Common\LoggerAwareTrait;
use Parthenon\Notification\Email;
use Parthenon\Notification\EmailSenderInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SenderHandler implements MessageHandlerInterface
{
    use LoggerAwareTrait;

    public function __construct(private EmailSenderInterface $sender)
    {
    }

    public function __invoke(Email $message)
    {
        $this->getLogger()->info('Sending email from Message');

        $this->sender->send($message);
    }
}
