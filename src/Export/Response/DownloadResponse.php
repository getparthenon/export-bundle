<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Response;

use Parthenon\Export\ExportResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadResponse implements ExportResponseInterface
{
    public function __construct(private string $content, private string $filename)
    {
    }

    public function getSymfonyResponse(): Response
    {
        $response = new Response($this->content);
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $this->filename);

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
