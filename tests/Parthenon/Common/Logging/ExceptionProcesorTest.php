<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Logging;

use Parthenon\Common\Logging\Monolog\ExceptionProcessor;
use PHPUnit\Framework\TestCase;

class ExceptionProcesorTest extends TestCase
{
    public function testConvertsException()
    {
        $processor = new ExceptionProcessor();

        $exception = new \Exception('message');
        $record = ['extra' => ['exception' => $exception], 'context' => []];

        $output = $processor->__invoke($record);

        $this->assertArrayHasKey('message', $output['extra']['exception']);
        $this->assertEquals('message', $output['extra']['exception']['message']);
    }

    public function testConvertsExceptionConetxt()
    {
        $processor = new ExceptionProcessor();

        $exception = new \Exception('message');
        $record = ['context' => ['exception' => $exception]];

        $output = $processor->__invoke($record);

        $this->assertArrayHasKey('message', $output['context']['exception']);
        $this->assertEquals('message', $output['context']['exception']['message']);
    }

    public function testConvertsExceptionConetxtDeep()
    {
        $processor = new ExceptionProcessor();

        $exception = new \Exception('message');
        $record = ['context' => ['deep' => ['exception' => $exception]]];

        $output = $processor->__invoke($record);

        $this->assertArrayHasKey('message', $output['context']['deep']['exception']);
        $this->assertEquals('message', $output['context']['deep']['exception']['message']);
    }
}
