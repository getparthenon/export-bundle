<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Naming;

use Parthenon\Common\Upload\Naming\NamingMd5Time;
use PHPUnit\Framework\TestCase;

class NamingMd5TimeTest extends TestCase
{
    public function testReturnsCorrectFileType()
    {
        $namer = new NamingMd5Time();
        $this->assertStringEndsWith('.jpg', $namer->getName('random.jpg'));
        $this->assertStringEndsWith('.pdf', $namer->getName('random.pdf'));
        $this->assertStringEndsWith('.pdf', $namer->getName('random.jpg.pdf'));
        $this->assertStringEndsWith('.png', $namer->getName('random(23).dsds.dfjdkfjf.png'));
    }

    public function testReturnsWithMd5()
    {
        $namer = new NamingMd5Time();
        $this->assertMatchesRegularExpression('~[a-zA-Z0-9]{32}-\d+\.jpg~', $namer->getName('random.jpg'));
    }
}
