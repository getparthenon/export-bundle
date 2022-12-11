<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\Service\Attribute\Required;

trait LoggerAwareTrait
{
    private LoggerInterface $logger;

    public function getLogger(): LoggerInterface
    {
        if (!isset($this->logger)) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }

    #[Required]
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
