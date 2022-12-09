<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Elasticsearch;

use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;

final class ClientFactory
{
    private ElasticsearchClient $rawClient;

    public function __construct(private Config $config)
    {
    }

    public function buildRawClient(): ElasticsearchClient
    {
        /*if (isset($this->rawClient)) {
            return $this->rawClient;
        }*/

        $builder = ClientBuilder::create();

        if ($this->config->isNormalConnection()) {
            $builder->setHosts($this->config->getHosts());
        }

        if ($this->config->isCloudBasedConnection()) {
            $builder->setElasticCloudId($this->config->getElasticCloudId());
        }

        if ($this->config->hasApiSettings()) {
            $builder->setApiKey($this->config->getApiId(), $this->config->getApiKey());
        }

        if ($this->config->hasBasicAuthSettings()) {
            $builder->setBasicAuthentication($this->config->getBasicUsername(), $this->config->getBasicPassword());
        }

        return $this->rawClient = $builder->build();
    }

    public function build(): Client
    {
        return new Client($this->buildRawClient());
    }
}
