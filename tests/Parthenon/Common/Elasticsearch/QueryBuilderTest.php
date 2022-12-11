<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the GPL V3 License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Elasticsearch;

use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testDealsWithSingleQuery()
    {
        $qb = new QueryBuilder();

        $output = $qb->query('match', 'fieldName', 'fieldValue')
            ->build();

        $this->assertEquals(['query' => ['match' => ['fieldName' => 'fieldValue']]], $output);
    }

    public function testDealsWithSingleFilterAggreation()
    {
        $qb = new QueryBuilder();

        $output = $qb->filter('term', 'fieldName', 'fieldValue')
            ->aggregation('term', 'fieldName')
            ->build();

        $this->assertEquals([
            'query' => [
                'bool' => [
                    'filter' => [
                        'term' => [
                            'fieldName' => 'fieldValue',
                        ],
                    ],
                ],
            ],
            'aggs' => [
                'agg_term_fieldName' => [
                    'term' => [
                        'field' => 'fieldName',
                    ],
                ],
            ],
        ], $output);
    }

    public function testDealsWithTwoQueries()
    {
        $qb = new QueryBuilder();

        $output = $qb->query('match', 'fieldName', 'fieldValue')
                ->query('match', 'secondField', 'secondValue')
                ->build();
        $this->assertEquals([
        'query' => [
        'bool' => [
            'must' => [
                [
                    'match' => ['fieldName' => 'fieldValue'],
                ],
                [
                    'match' => ['secondField' => 'secondValue'],
                ],
            ],
        ],
    ],
            ], $output);
    }

    public function testDealsWithTwoQueriesAndTwoNotQueries()
    {
        $qb = new QueryBuilder();

        $output = $qb->query('match', 'fieldName', 'fieldValue')
            ->query('match', 'secondField', 'secondValue')
            ->notQuery('match', 'thirdField', 'thirdValue')
            ->notQuery('match', 'fourField', 'fourValue')
            ->build();
        $this->assertEquals([
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'match' => ['fieldName' => 'fieldValue'],
                        ],
                        [
                            'match' => ['secondField' => 'secondValue'],
                        ],
                    ],
                    'must_not' => [
                        [
                            'match' => ['thirdField' => 'thirdValue'],
                        ],
                        [
                            'match' => ['fourField' => 'fourValue'],
                        ],
                    ],
                ],
            ],
        ], $output);
    }

    public function testDealsWithTwoQueriesAndTwoOrQueries()
    {
        $qb = new QueryBuilder();

        $output = $qb->query('match', 'fieldName', 'fieldValue')
            ->query('match', 'secondField', 'secondValue')
            ->orQuery('match', 'thirdField', 'thirdValue')
            ->orQuery('match', 'fourField', 'fourValue')
            ->build();
        $this->assertEquals([
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'match' => ['fieldName' => 'fieldValue'],
                        ],
                        [
                            'match' => ['secondField' => 'secondValue'],
                        ],
                    ],
                    'should' => [
                        [
                            'match' => ['thirdField' => 'thirdValue'],
                        ],
                        [
                            'match' => ['fourField' => 'fourValue'],
                        ],
                    ],
                ],
            ],
        ], $output);
    }

    public function testDealsWithFiltersAndTwoQueries()
    {
        $qb = new QueryBuilder();

        $output = $qb->filter('term', 'fieldName', 'fieldValue')
            ->filter('term', 'secondField', 'secondValue')
            ->query('match', 'fieldName', 'fieldValue')
            ->query('match', 'secondField', 'secondValue')
            ->build();
        $this->assertEquals([
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'match' => ['fieldName' => 'fieldValue'],
                        ],
                        [
                            'match' => ['secondField' => 'secondValue'],
                        ],
                    ],
                    'filter' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => ['fieldName' => 'fieldValue'],
                                ],
                                [
                                    'term' => ['secondField' => 'secondValue'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $output);
    }

    public function testDealsWithTwoFiltersAndTwoNotFilters()
    {
        $qb = new QueryBuilder();

        $output = $qb->filter('term', 'fieldName', 'fieldValue')
            ->filter('term', 'secondField', 'secondValue')
            ->notFilter('term', 'thirdField', 'thirdValue')
            ->notFilter('term', 'fourField', 'fourValue')
            ->build();
        $this->assertEquals([
            'query' => [
                'bool' => [
                    'filter' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => ['fieldName' => 'fieldValue'],
                                ],
                                [
                                    'term' => ['secondField' => 'secondValue'],
                                ],
                            ],
                            'must_not' => [
                                [
                                    'term' => ['thirdField' => 'thirdValue'],
                                ],
                                [
                                    'term' => ['fourField' => 'fourValue'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $output);
    }

    public function testDealsWithTwoFiltersAndTwoOrFilters()
    {
        $qb = new QueryBuilder();

        $output = $qb->filter('term', 'fieldName', 'fieldValue')
            ->filter('term', 'secondField', 'secondValue')
            ->orFilter('term', 'thirdField', 'thirdValue')
            ->orFilter('term', 'fourField', 'fourValue')
            ->build();
        $this->assertEquals([
            'query' => [
                'bool' => [
                    'filter' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => ['fieldName' => 'fieldValue'],
                                ],
                                [
                                    'term' => ['secondField' => 'secondValue'],
                                ],
                            ],
                            'should' => [
                                [
                                    'term' => ['thirdField' => 'thirdValue'],
                                ],
                                [
                                    'term' => ['fourField' => 'fourValue'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $output);
    }
}
