<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.1.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\Common\Pdf;

use Mpdf\Mpdf;
use PHPUnit\Framework\TestCase;

class MpdfGeneratorTest extends TestCase
{
    public function testCallsMpdf()
    {
        $html = '<html><body>Hello World</body></html>';
        $mpdf = $this->createMock(Mpdf::class);
        $mpdf->expects($this->once())->method('WriteHTML')->with($html);

        $generator = new MpdfGenerator($mpdf);
        $generator->generate($html);
    }
}
