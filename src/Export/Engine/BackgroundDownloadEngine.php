<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Engine;

use Parthenon\Common\LoggerAwareTrait;
use Parthenon\Export\Entity\BackgroundExportRequest;
use Parthenon\Export\Exception\ExportFailedException;
use Parthenon\Export\ExportRequest;
use Parthenon\Export\ExportResponseInterface;
use Parthenon\Export\Repository\BackgroundExportRequestRepositoryInterface;
use Parthenon\Export\Response\WaitingResponse;
use Symfony\Component\Messenger\MessageBusInterface;

final class BackgroundDownloadEngine implements EngineInterface
{
    use LoggerAwareTrait;

    public const NAME = 'background_download';

    public function __construct(private MessageBusInterface $messengerBus, private BackgroundExportRequestRepositoryInterface $backgroundExportRequestRepository)
    {
    }

    public function process(ExportRequest $exportRequest): ExportResponseInterface
    {
        try {
            $this->getLogger()->info('Queuing a background download export', ['export_filename' => $exportRequest->getFilename()]);

            $backgroundExportRequest = BackgroundExportRequest::createFromExportRequest($exportRequest);

            $this->backgroundExportRequestRepository->save($backgroundExportRequest);
            $this->messengerBus->dispatch($backgroundExportRequest);

            return new WaitingResponse((string) $backgroundExportRequest->getId());
        } catch (\Throwable $e) {
            throw new ExportFailedException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
