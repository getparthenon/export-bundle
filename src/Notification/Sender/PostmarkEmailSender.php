<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification\Sender;

use Parthenon\Notification\EmailInterface;
use Parthenon\Notification\EmailSenderInterface;
use Parthenon\Notification\Exception\UnableToSendMessageException;
use Postmark\Models\PostmarkAttachment;
use Postmark\PostmarkClient;

final class PostmarkEmailSender implements EmailSenderInterface
{
    public function __construct(private PostmarkClient $postmarkClient)
    {
    }

    public function send(EmailInterface $message)
    {
        $attachments = [];
        foreach ($message->getAttachments() as $attachment) {
            $attachments[] = PostmarkAttachment::fromRawData($attachment->getContent(), $attachment->getName());
        }

        $email = [
            'To' => $message->getToAddress(),
            'From' => $message->getFromAddress(),
            'Subject' => $message->getSubject(),
            'Attachments' => $attachments,
        ];
        try {
            if ($message->isTemplate()) {
                $email['TemplateAlias'] = $message->getTemplateName();
                $email['TemplateModel'] = $message->getTemplateVariables();
                $response = $this->postmarkClient->sendEmailBatchWithTemplate([$email]);
            } else {
                $email['HtmlBody'] = $message->getContent();
                $response = $this->postmarkClient->sendEmailBatch([$email]);
            }
        } catch (\Exception $e) {
            throw new UnableToSendMessageException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
