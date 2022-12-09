<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Pdf;

use DocRaptor\Doc;
use DocRaptor\DocApi;
use Parthenon\Common\Exception\GeneralException;

final class DocRaptorGenerator implements GeneratorInterface
{
    public function __construct(private DocApi $docApi)
    {
    }

    public function generate(string $html)
    {
        $doc = new Doc();
        $doc->setDocumentContent($html);
        $doc->setDocumentType('pdf');

        try {
            return $this->docApi->createDoc($doc);
        } catch (GeneralException $e) {
            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
