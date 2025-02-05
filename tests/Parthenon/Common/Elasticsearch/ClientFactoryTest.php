<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020-2025 Iain Cambridge
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation, either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
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
