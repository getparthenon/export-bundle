<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
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
