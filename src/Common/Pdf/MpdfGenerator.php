<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Pdf;

use Mpdf\Mpdf;
use Parthenon\Common\Exception\GeneralException;

final class MpdfGenerator implements GeneratorInterface
{
    public function __construct(private Mpdf $mpdf)
    {
    }

    public function generate(string $html)
    {
        try {
            $this->mpdf->WriteHTML($html);

            return $this->mpdf->Output();
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
