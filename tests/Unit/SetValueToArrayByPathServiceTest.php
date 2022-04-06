<?php

namespace SaaSFormation\ArrayByPath\Tests\Unit;

use SaaSFormation\ArrayByPath\PathAlreadyExistsException;
use SaaSFormation\ArrayByPath\SetValueToArrayByPathService;
use PHPUnit\Framework\TestCase;

class SetValueToArrayByPathServiceTest extends TestCase
{
    private static array $data;

    public static function setUpBeforeClass(): void
    {
        self::$data = ExampleArrayProvider::EXAMPLE_ARRAY;
    }

    public function dataToInsertProvider(): array
    {
        return [
            ['data.attributes.height', 177, [
                'data' => [
                    'id' => '53b3ed90-b5ae-11ec-b909-0242ac120002',
                    'attributes' => [
                        'name' => 'John',
                        'surname' => 'Smith',
                        'birthdate' => '1990-01-20',
                        'savings_total_amount' => [
                            'amount' => 2045033,
                            'currency' => 'EUR'
                        ],
                        'height' => 177
                    ]
                ]
            ]],
            ['data.attributes.weight', 76, [
                'data' => [
                    'id' => '53b3ed90-b5ae-11ec-b909-0242ac120002',
                    'attributes' => [
                        'name' => 'John',
                        'surname' => 'Smith',
                        'birthdate' => '1990-01-20',
                        'savings_total_amount' => [
                            'amount' => 2045033,
                            'currency' => 'EUR'
                        ],
                        'height' => 177,
                        'weight' => 76
                    ]
                ]
            ]],
            ['data.attributes.coordinates.latitude', 41.199353, [
                'data' => [
                    'id' => '53b3ed90-b5ae-11ec-b909-0242ac120002',
                    'attributes' => [
                        'name' => 'John',
                        'surname' => 'Smith',
                        'birthdate' => '1990-01-20',
                        'savings_total_amount' => [
                            'amount' => 2045033,
                            'currency' => 'EUR'
                        ],
                        'height' => 177,
                        'weight' => 76,
                        'coordinates' => [
                            'latitude' => 41.199353
                        ]
                    ]
                ]
            ]]
        ];
    }

    public function dataToUpsertProvider(): array
    {
        return [
            ['data.id', 'a0c9e290-b5b0-11ec-b909-0242ac120002', [
                'data' => [
                    'id' => 'a0c9e290-b5b0-11ec-b909-0242ac120002',
                    'attributes' => [
                        'name' => 'John',
                        'surname' => 'Smith',
                        'birthdate' => '1990-01-20',
                        'savings_total_amount' => [
                            'amount' => 2045033,
                            'currency' => 'EUR'
                        ],
                        'height' => 177,
                        'weight' => 76,
                        'coordinates' => [
                            'latitude' => 41.199353
                        ]
                    ]
                ]
            ]]
        ];
    }

    /**
     * @test
     * @dataProvider dataToInsertProvider
     * @throws \SaaSFormation\ArrayByPath\InvalidPathException
     */
    public function checkGivenAValidInputInsertAddsOrChangesTheRightValue(string $path, mixed $value, array $expectedArray): void
    {
        // Arrange
        $setService = new SetValueToArrayByPathService();

        // Act
        $setService->insert($path, self::$data, $value);

        // Assert
        $this->assertEquals($expectedArray, self::$data);
    }

    /**
     * @test
     * @throws \SaaSFormation\ArrayByPath\InvalidPathException
     */
    public function checkGivenAnExistentPathItThrowsAnExceptionOnInsert(): void
    {
        // Arrange
        $this->expectException(PathAlreadyExistsException::class);
        $setService = new SetValueToArrayByPathService();

        // Act
        $setService->insert('data.attributes.name', self::$data, 'Billy');

        // Assert
    }

    /**
     * @test
     * @dataProvider dataToUpsertProvider
     * @throws \SaaSFormation\ArrayByPath\InvalidPathException
     */
    public function checkGivenAValidInputOnAnAlreadyPresentPathUpsertChangesTheRightValue(string $path, mixed $value, array $expectedArray): void
    {
        // Arrange
        $setService = new SetValueToArrayByPathService();

        // Act
        $setService->upsert($path, self::$data, $value);

        // Assert
        $this->assertEquals($expectedArray, self::$data);
    }
}
