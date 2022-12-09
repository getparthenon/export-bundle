<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Repository;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DoctrineRepositoryTest extends TestCase
{
    public function testSavesToEntityRepository()
    {
        $stdClass = new \stdClass();

        $entityRepository = $this->createMock(CustomServiceRepository::class);
        $entityManager = $this->createMock(EntityManager::class);

        $entityRepository->method('getEntityManager')->willReturn($entityManager);

        $entityManager->expects($this->once())->method('persist')->with($stdClass);
        $entityManager->expects($this->once())->method('flush');

        $repository = new DoctrineRepository($entityRepository);
        $repository->save($stdClass);
    }
}
