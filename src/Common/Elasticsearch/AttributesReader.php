<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Elasticsearch;

use Parthenon\Common\Exception\Elasticsearch\InvalidAttibuteException;

class AttributesReader
{
    public function getAttributes(object $object)
    {
        $output = [];

        $reflectedObject = new \ReflectionObject($object);
        $propertries = $reflectedObject->getProperties();

        foreach ($propertries as $propertry) {
            foreach ($propertry->getAttributes() as $attribute) {
                try {
                    $output[] = [
                        'propertyName' => $propertry->getName(),
                        'instance' => $attribute->newInstance(),
                    ];
                } catch (\Throwable $throwable) {
                    throw new InvalidAttibuteException(sprintf('Invalid attribute on %s property. Message: %e', $propertry->getName(), $throwable->getMessage()), $throwable->getCode(), $throwable);
                }
            }
        }

        return $output;
    }
}
