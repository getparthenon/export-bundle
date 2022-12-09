<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Logging\Monolog;

use Monolog\Processor\ProcessorInterface;

final class ExceptionProcessor implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        $output = [];

        foreach ($record as $key => $value) {
            if (is_array($value)) {
                $output[$key] = $this->__invoke($value);
            } elseif ($value instanceof \Throwable) {
                $output[$key] = [
                    'message' => $value->getMessage(),
                    'file' => $value->getFile(),
                    'line' => $value->getLine(),
                    'code' => $value->getCode(),
                ];
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }
}
