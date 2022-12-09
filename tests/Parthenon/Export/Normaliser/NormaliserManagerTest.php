<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Normaliser;

use Parthenon\Export\Exception\NoNormaliserFoundException;
use PHPUnit\Framework\TestCase;

class NormaliserManagerTest extends TestCase
{
    public function testGetNormaliser()
    {
        $item = new \stdClass();

        $normaliser = $this->createMock(NormaliserInterface::class);
        $normaliser->method('supports')->with($item)->willReturn(true);

        $subject = new NormaliserManager();
        $subject->addNormaliser($normaliser);

        $actual = $subject->getNormaliser($item);
        $this->assertSame($normaliser, $actual);
    }

    public function testFailedNormaliser()
    {
        $this->expectException(NoNormaliserFoundException::class);
        $item = new \stdClass();

        $normaliser = $this->createMock(NormaliserInterface::class);
        $normaliser->method('supports')->with($item)->willReturn(false);

        $subject = new NormaliserManager();
        $subject->addNormaliser($normaliser);

        $subject->getNormaliser($item);
    }

    public function testGetNormaliserCorrectOne()
    {
        $item = new \stdClass();

        $normaliserNotOne = $this->createMock(NormaliserInterface::class);
        $normaliserNotOne->method('supports')->with($item)->willReturn(false);
        $normaliserNotTwo = $this->createMock(NormaliserInterface::class);
        $normaliserNotTwo->method('supports')->with($item)->willReturn(false);

        $normaliser = $this->createMock(NormaliserInterface::class);
        $normaliser->method('supports')->with($item)->willReturn(true);

        $subject = new NormaliserManager();
        $subject->addNormaliser($normaliserNotOne);
        $subject->addNormaliser($normaliserNotTwo);
        $subject->addNormaliser($normaliser);

        $actual = $subject->getNormaliser($item);
        $this->assertSame($normaliser, $actual);
    }
}
