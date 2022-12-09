<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Response;

use Parthenon\Export\Exception\UnsupportedResponseTypeException;
use Parthenon\Export\ExportResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseConverterInterface
{
    /**
     * @throws UnsupportedResponseTypeException
     */
    public function convert(ExportResponseInterface $exportResponse): Response;
}
