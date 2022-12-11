<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common;

use Parthenon\Common\Config\SiteUrlProviderInterface;

final class Config
{
    public function __construct(private SiteUrlProviderInterface $siteUrlProvider)
    {
    }

    public function getSiteUrl(): string
    {
        return $this->siteUrlProvider->getSiteUrl();
    }
}
