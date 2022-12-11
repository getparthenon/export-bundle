<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\Normaliser;

use Parthenon\Export\Exception\NoNormaliserFoundException;

final class NormaliserManager implements NormaliserManagerInterface
{
    /**
     * @param NormaliserInterface[] $normalisers
     */
    public function __construct(private array $normalisers = [])
    {
    }

    public function getNormaliser(mixed $item): NormaliserInterface
    {
        foreach ($this->normalisers as $normaliser) {
            if ($normaliser->supports($item)) {
                return $normaliser;
            }
        }

        throw new NoNormaliserFoundException('No normaliser found');
    }

    public function addNormaliser(NormaliserInterface $normaliser): void
    {
        $this->normalisers[] = $normaliser;
    }
}
