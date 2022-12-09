<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Engine;

use Parthenon\Export\Entity\BackgroundExportRequest;
use Parthenon\Export\ExportRequest;
use Parthenon\Export\Repository\BackgroundExportRequestRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class BackgroundDownloadEngineTest extends TestCase
{
    public function testSendToMessenger()
    {
        $messageBus = $this->createMock(MessageBusInterface::class);
        $requestRepository = $this->createMock(BackgroundExportRequestRepositoryInterface::class);
        $exportRequest = $this->createMock(ExportRequest::class);

        $exportRequest->method('getFilename')->willReturn('filename');
        $exportRequest->method('getExportFormat')->willReturn('filename');
        $exportRequest->method('getDataProviderService')->willReturn('filename');
        $exportRequest->method('getDataProviderParameters')->willReturn(['parameters']);

        $requestRepository->method('save')->with($this->isInstanceOf(BackgroundExportRequest::class));
        $messageBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(BackgroundExportRequest::class));

        $subject = new BackgroundDownloadEngine($messageBus, $requestRepository);
        $subject->process($exportRequest);
    }
}
