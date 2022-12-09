<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Factory;

use League\Flysystem\AsyncAwsS3\AsyncAwsS3Adapter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Parthenon\Common\Exception\Upload\InvalidUploadConfigurationException;
use Parthenon\Common\Exception\Upload\NoUploadProviderFoundException;
use Parthenon\Common\Upload\UploaderInterface;
use PHPUnit\Framework\TestCase;

class FlySystemAdapterFactoryTest extends TestCase
{
    public function testThrowsException()
    {
        $this->expectException(InvalidUploadConfigurationException::class);

        $localAdapter = $this->createMock(LocalAdapterInterface::class);
        $s3Adapter = $this->createMock(S3AdapterInterface::class);

        $flysystemAdpaterFactory = new FlySystemAdapterFactory($s3Adapter, $localAdapter);
        $flysystemAdpaterFactory->getAdapter([]);
    }

    public function testThrowsExceptionInvalidProvider()
    {
        $this->expectException(NoUploadProviderFoundException::class);

        $localAdapter = $this->createMock(LocalAdapterInterface::class);
        $s3Adapter = $this->createMock(S3AdapterInterface::class);

        $flysystemAdpaterFactory = new FlySystemAdapterFactory($s3Adapter, $localAdapter);
        $flysystemAdpaterFactory->getAdapter(['provider' => 'none']);
    }

    public function testCallsS3Adapter()
    {
        $localAdapter = $this->createMock(LocalAdapterInterface::class);
        $s3Adapter = $this->createMock(S3AdapterInterface::class);
        $flySystemS3 = $this->createMock(AsyncAwsS3Adapter::class);

        $config = ['provider' => UploaderInterface::PROVIDER_S3, 's3' => []];

        $s3Adapter->expects($this->once())->method('build')->with($config)->willReturn($flySystemS3);
        $localAdapter->expects($this->never())->method('build')->with($config);

        $flysystemAdpaterFactory = new FlySystemAdapterFactory($s3Adapter, $localAdapter);
        $this->assertInstanceOf(AsyncAwsS3Adapter::class, $flysystemAdpaterFactory->getAdapter($config));
    }

    public function testCallsLocalAdapter()
    {
        $localAdapter = $this->createMock(LocalAdapterInterface::class);
        $s3Adapter = $this->createMock(S3AdapterInterface::class);
        $flySystem = $this->createMock(LocalFilesystemAdapter::class);

        $config = ['provider' => UploaderInterface::PROVIDER_LOCAL, 's3' => []];

        $localAdapter->expects($this->once())->method('build')->with($config)->willReturn($flySystem);
        $s3Adapter->expects($this->never())->method('build')->with($config);

        $flysystemAdpaterFactory = new FlySystemAdapterFactory($s3Adapter, $localAdapter);
        $this->assertInstanceOf(LocalFilesystemAdapter::class, $flysystemAdpaterFactory->getAdapter($config));
    }
}
