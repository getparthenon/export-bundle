<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\RequestHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface RequestHandlerInterface
{
    public function supports(Request $request): bool;

    public function handleForm(FormInterface $form, Request $request): void;

    public function generateDefaultOutput(?FormInterface $form, array $extraOutput = []): array|Response;

    public function generateSuccessOutput(?FormInterface $form, array $extraOutput = []): array|Response;

    public function generateErrorOutput(?FormInterface $form, array $extraOutput = []): array|Response;
}
