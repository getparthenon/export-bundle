<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Upload\Naming;

use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testReturnsMd5()
    {
        $factory = new Factory();
        $this->assertInstanceOf(NamingMd5Time::class, $factory->getStrategy(NamingStrategyInterface::MD5_TIME));
    }

    public function testReturnsRandom()
    {
        $factory = new Factory();
        $this->assertInstanceOf(RandomTime::class, $factory->getStrategy(NamingStrategyInterface::RANDOM_TIME));
    }
}
