<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\DataProvider;

use Parthenon\Export\Exception\InvalidDataProviderException;
use Parthenon\Export\Exception\NoDataProviderFoundException;
use Parthenon\Export\ExportRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class DataProviderFetcherTest extends TestCase
{
    public function testFetchService()
    {
        $container = $this->createMock(ContainerInterface::class);
        $dataProvider = $this->createMock(DataProviderInterface::class);
        $exportRequest = $this->createMock(ExportRequest::class);

        $serviceId = 'service';

        $exportRequest->method('getDataProviderService')->willReturn($serviceId);
        $container->method('get')->with($serviceId)->willReturn($dataProvider);

        $subject = new DataProviderFetcher($container);

        $actual = $subject->getDataProvider($exportRequest);
        $this->assertSame($dataProvider, $actual);
    }

    public function testFetchServiceNotFound()
    {
        $this->expectException(NoDataProviderFoundException::class);
        $container = $this->createMock(ContainerInterface::class);
        $dataProvider = $this->createMock(DataProviderInterface::class);
        $exportRequest = $this->createMock(ExportRequest::class);

        $serviceId = 'service';

        $exportRequest->method('getDataProviderService')->willReturn($serviceId);
        $container->method('get')->with($serviceId)->willThrowException(new ServiceNotFoundException('Service not found', $serviceId));

        $subject = new DataProviderFetcher($container);

        $actual = $subject->getDataProvider($exportRequest);
    }

    public function testFetchServiceNotValidDataProvider()
    {
        $this->expectException(InvalidDataProviderException::class);
        $container = $this->createMock(ContainerInterface::class);
        $dataProvider = new \stdClass();
        $exportRequest = $this->createMock(ExportRequest::class);

        $serviceId = 'service';

        $exportRequest->method('getDataProviderService')->willReturn($serviceId);
        $container->method('get')->with($serviceId)->willReturn($dataProvider);

        $subject = new DataProviderFetcher($container);

        $actual = $subject->getDataProvider($exportRequest);
    }
}
