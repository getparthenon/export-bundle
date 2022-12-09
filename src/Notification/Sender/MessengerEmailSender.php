<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Sender;

use Parthenon\Notification\EmailInterface;
use Parthenon\Notification\EmailSenderInterface;
use Parthenon\Notification\Exception\UnableToSendMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEmailSender implements EmailSenderInterface
{
    public function __construct(private MessageBusInterface $messengerBus)
    {
    }

    public function send(EmailInterface $message)
    {
        try {
            $this->messengerBus->dispatch($message);
        } catch (\Exception $e) {
            throw new UnableToSendMessageException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
