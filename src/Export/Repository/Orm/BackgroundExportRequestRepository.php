<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Repository\Orm;

use Parthenon\Common\Repository\CustomServiceRepository;
use Parthenon\Export\Entity\BackgroundExportRequest;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class BackgroundExportRequestRepository extends CustomServiceRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackgroundExportRequest::class);
    }
}
