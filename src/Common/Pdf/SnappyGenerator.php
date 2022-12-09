<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Pdf;

use Knp\Snappy\Pdf;
use Parthenon\Common\Exception\GeneralException;

class SnappyGenerator implements GeneratorInterface
{
    private Pdf $pdf;

    public function __construct(string $bin)
    {
        $this->pdf = new Pdf($bin);
    }

    public function generate(string $html)
    {
        try {
            return $this->pdf->getOutputFromHtml($html);
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
