<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Repository;

use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Parthenon\Common\Exception\GeneralException;

class OdmRepository implements RepositoryInterface
{
    protected ServiceDocumentRepository $documentRepository;

    public function __construct(ServiceDocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function findById($id)
    {
        $entity = $this->documentRepository->find($id);
        $this->documentRepository->getDocumentManager()->refresh($entity);

        return $entity;
    }

    public function save($entity)
    {
        try {
            $this->documentRepository->getDocumentManager()->persist($entity);
            $this->documentRepository->getDocumentManager()->flush();
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
