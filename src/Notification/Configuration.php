<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Notification;

final class Configuration
{
    private string $fromAddress;

    private string $fromName;

    /**
     * Configuration constructor.
     */
    public function __construct(string $fromName, string $fromAddress)
    {
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
    }

    public function getFromAddress(): string
    {
        return $this->fromAddress;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }
}
