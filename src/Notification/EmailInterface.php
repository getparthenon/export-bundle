<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification;

interface EmailInterface
{
    public function getSubject();

    public function getFromName(): ?string;

    public function getFromAddress(): ?string;

    public function getToName();

    public function getToAddress();

    public function getContent();

    public function isTemplate(): bool;

    public function getTemplateName(): string;

    public function getTemplateVariables(): array;

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array;
}
