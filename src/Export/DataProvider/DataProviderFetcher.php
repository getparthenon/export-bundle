<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Export\DataProvider;

use Parthenon\Export\Exception\InvalidDataProviderException;
use Parthenon\Export\Exception\NoDataProviderFoundException;
use Parthenon\Export\ExportRequest;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class DataProviderFetcher implements DataProviderFetcherInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function getDataProvider(ExportRequest $request): DataProviderInterface
    {
        try {
            $provider = $this->container->get($request->getDataProviderService());
        } catch (ServiceNotFoundException $exception) {
            throw new NoDataProviderFoundException(sprintf('No data provider service found for \'%s\'.', $request->getDataProviderService()), previous: $exception);
        }

        if (!$provider instanceof DataProviderInterface) {
            throw new InvalidDataProviderException(sprintf("The data provider '%s' does not implement ".DataProviderInterface::class, $request->getDataProviderService()));
        }

        return $provider;
    }
}
