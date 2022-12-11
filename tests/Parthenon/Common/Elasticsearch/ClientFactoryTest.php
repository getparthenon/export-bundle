<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Elasticsearch;

use DG\BypassFinals;
use PHPUnit\Framework\TestCase;

class ClientFactoryTest extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testItReturnsNormalHost()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(false);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(false);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsNormalHostSetsApiKey()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(false);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(true);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->once())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->once())->method('getApiId')->willReturn('api_id');

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsCloud()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(true);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(true);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->once())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->once())->method('getApiId')->willReturn('api_id');
        $config->expects($this->once())->method('getElasticCloudId')->willReturn('foo:'.base64_encode('localhost:9200$foo'));

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsCloudBasicAuth()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(true);
        $config->method('hasBasicAuthSettings')->willReturn(true);
        $config->method('hasApiSettings')->willReturn(false);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->never())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->never())->method('getApiId')->willReturn('api_id');
        $config->expects($this->once())->method('getBasicUsername')->willReturn('username');
        $config->expects($this->once())->method('getBasicPassword')->willReturn('password');
        $config->expects($this->once())->method('getElasticCloudId')->willReturn('foo:'.base64_encode('localhost:9200$foo'));

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }
}
