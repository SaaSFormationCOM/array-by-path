<?php

namespace SaaSFormation\ArrayByPath\Tests\Unit;

class ExampleArrayProvider
{
    const EXAMPLE_ARRAY = [
        'data' => [
            'id' => '53b3ed90-b5ae-11ec-b909-0242ac120002',
            'attributes' => [
                'name' => 'John',
                'surname' => 'Smith',
                'birthdate' => '1990-01-20',
                'savings_total_amount' => [
                    'amount' => 2045033,
                    'currency' => 'EUR'
                ]
            ]
        ]
    ];
}
