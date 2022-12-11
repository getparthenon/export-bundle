<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common;

use Parthenon\Common\Exception\InvalidFieldException;

trait FieldAccesorTrait
{
    protected function getFieldData($data, $fieldName)
    {
        if (false !== strpos($fieldName, '.')) {
            [$field, $subfield] = explode('.', $fieldName, 2);

            return $this->getFieldData($this->getFieldData($data, $field), $subfield);
        }
        $camelCase = str_replace('_', '', ucwords($fieldName, '_'));
        $getter = 'get'.$camelCase;
        $isser = 'is'.$camelCase;
        $hasser = 'has'.$camelCase;
        $camelCaseAccessor = lcfirst($camelCase);
        if (is_array($data) && array_key_exists($fieldName, $data)) {
            return $data[$fieldName];
        }

        if (is_object($data) && method_exists($data, $fieldName)) {
            return $data->$fieldName();
        }
        if (is_object($data) && method_exists($data, $camelCaseAccessor)) {
            return $data->$camelCaseAccessor();
        }

        if (is_object($data) && method_exists($data, $getter)) {
            return $data->$getter();
        }

        if (is_object($data) && method_exists($data, $isser)) {
            return $data->$isser();
        }

        if (is_object($data) && method_exists($data, $hasser)) {
            return $data->$hasser();
        }

        if (is_object($data) && property_exists($data, $camelCaseAccessor)) {
            return $data->$camelCaseAccessor;
        }

        if (is_object($data) && property_exists($data, $fieldName)) {
            return $data->$fieldName;
        }

        throw new InvalidFieldException('The field '.$fieldName.' is invalid');
    }
}
