<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Elasticsearch;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testCloudBasedConnection()
    {
        $config = new Config();
        $config->setConnectionType(Config::CONNECTION_TYPE_CLOUD);

        $this->assertTrue($config->isCloudBasedConnection());
        $this->assertFalse($config->isNormalConnection());
    }

    public function testNormalBasedConnection()
    {
        $config = new Config();
        $config->setConnectionType(Config::CONNECTION_TYPE_NORMAL);

        $this->assertTrue($config->isNormalConnection());
        $this->assertFalse($config->isCloudBasedConnection());
    }

    public function testBasicAuth()
    {
        $config = new Config();

        $this->assertFalse($config->hasBasicAuthSettings());

        $config->setBasicUsername('username');
        $this->assertFalse($config->hasBasicAuthSettings());

        $config->setBasicPassword('password');
        $this->assertTrue($config->hasBasicAuthSettings());
    }

    public function testHasApi()
    {
        $config = new Config();

        $this->assertFalse($config->hasApiSettings());

        $config->setApiId('api');
        $this->assertFalse($config->hasApiSettings());

        $config->setApiKey('api_key');
        $this->assertTrue($config->hasApiSettings());
    }

    public function testHasHosts()
    {
        $config = new Config();

        $this->assertFalse($config->hasHosts());

        $config->setHosts(['https://host.example.org']);
        $this->assertTrue($config->hasHosts());
    }
}
