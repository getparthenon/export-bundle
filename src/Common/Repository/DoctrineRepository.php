<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Repository;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\ORM\QueryBuilder;
use Parthenon\Common\Exception\GeneralException;
use Parthenon\Common\Exception\NoEntityFoundException;

class DoctrineRepository implements RepositoryInterface
{
    protected CustomServiceRepository $entityRepository;

    public function __construct(CustomServiceRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function save($entity)
    {
        try {
            $em = $this->entityRepository->getEntityManager();
            $em->persist($entity);
            $em->flush();
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function findById($id)
    {
        try {
            $entity = $this->entityRepository->find($id);
        } catch (ConversionException $exception) {
            throw new NoEntityFoundException('Invalid id', previous: $exception);
        } catch (Exception $exception) {
            throw new GeneralException('Issue with Doctrine', previous: $exception);
        }

        if (!$entity) {
            throw new NoEntityFoundException('No entity found for id '.$id);
        }

        return $entity;
    }

    /**
     * Returns the name used to create the query builder.
     */
    protected function getQueryBuilderName(): string
    {
        $parts = explode('\\', $this->entityRepository->getClassName());
        $name = end($parts);

        return $name;
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        $name = $this->getQueryBuilderName();

        return $this->entityRepository->createQueryBuilder($name);
    }
}
