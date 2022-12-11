<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
            ->setRiskyAllowed(true)
            ->setRules([
                '@PSR2' => true,
                '@Symfony' => true,
                'header_comment' => ['header' => 'Copyright Iain Cambridge 2020-2022.
                
Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE'],
                'list_syntax' => ['syntax' => 'short'],
                'array_syntax' => ['syntax' => 'short'],
                'declare_strict_types' => true,
                'ordered_class_elements' => true,
                'no_multiple_statements_per_line' => true,
                'constant_case' => true,
                'no_useless_nullsafe_operator' => true,
            ])
            ->setFinder(
                PhpCsFixer\Finder::create()->in(__DIR__)
            )
;
