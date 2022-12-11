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
