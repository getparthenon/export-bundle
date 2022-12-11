<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Pdf;

use DocRaptor\Doc;
use DocRaptor\DocApi;
use PHPUnit\Framework\TestCase;

class DocRaptorTest extends TestCase
{
    public function testCallsDocraptorCreateDoc()
    {
        $html = '<html><body>Hello Universe</body></html>';
        $docRaptor = $this->createMock(DocApi::class);

        $docRaptor->expects($this->once())->method('createDoc')
            ->with($this->callback(function (Doc $doc) use ($html) {
                return $doc->getDocumentContent() === $html && 'pdf' === $doc->getDocumentType();
            }));

        $generator = new DocRaptorGenerator($docRaptor);
        $generator->generate($html);
    }
}
