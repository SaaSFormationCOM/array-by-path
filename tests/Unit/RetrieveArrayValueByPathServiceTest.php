<?php

namespace SaaSFormation\ArrayByPath\Tests\Unit;

use SaaSFormation\ArrayByPath\InvalidPathException;
use SaaSFormation\ArrayByPath\RetrieveArrayValueByPathService;
use PHPUnit\Framework\TestCase;

class RetrieveArrayValueByPathServiceTest extends TestCase
{
    public function validPathDataProvider(): array
    {
        return [
            ['data.id', '53b3ed90-b5ae-11ec-b909-0242ac120002'],
            ['data.attributes', [
                'name' => 'John',
                'surname' => 'Smith',
                'birthdate' => '1990-01-20',
                'savings_total_amount' => [
                    'amount' => 2045033,
                    'currency' => 'EUR'
                ]
            ]],
            ['data.attributes.name', 'John'],
            ['data.attributes.surname', 'Smith'],
            ['data.attributes.birthdate', '1990-01-20'],
            ['data.attributes.savings_total_amount', [
                'amount' => 2045033,
                'currency' => 'EUR'
            ]],
            ['data.attributes.savings_total_amount.amount', 2045033],
            ['data.attributes.savings_total_amount.currency', 'EUR'],
        ];
    }

    private function invalidPathDataProvider(): array
    {
        return [
            ['foo.bar'],
            ['data.attributes.foo'],
            ['data.attributes.savings_total_amount.foo']
        ];
    }

    /**
     * @test
     * @dataProvider validPathDataProvider
     * @param string $path
     * @param mixed $expectedValue
     * @return void
     * @throws InvalidPathException
     */
    public function checkGivenAValidPathGetReturnsTheRightValue(string $path, mixed $expectedValue): void
    {
        // Arrange
        $service = new RetrieveArrayValueByPathService();

        // Act
        $value = $service->get($path, ExampleArrayProvider::EXAMPLE_ARRAY);

        // Assert
        $this->assertEquals($expectedValue, $value);
    }

    /**
     * @test
     * @dataProvider validPathDataProvider
     * @param string $path
     * @param mixed $expectedValue
     * @return void
     */
    public function checkGivenAValidPathFindReturnsTheRightValue(string $path, mixed $expectedValue): void
    {
        // Arrange
        $service = new RetrieveArrayValueByPathService();

        // Act
        $value = $service->find($path, ExampleArrayProvider::EXAMPLE_ARRAY);

        // Assert
        $this->assertEquals($expectedValue, $value);
    }

    /**
     * @test
     * @dataProvider invalidPathDataProvider
     * @param string $path
     * @return void
     */
    public function checkGivenAnInvalidPathGetThrowsAnException(string $path): void
    {
        // Arrange
        $service = new RetrieveArrayValueByPathService();
        $this->expectException(InvalidPathException::class);

        // Act
        $service->get($path, ExampleArrayProvider::EXAMPLE_ARRAY);

        // Assert
    }

    /**
     * @test
     * @dataProvider invalidPathDataProvider
     * @param string $path
     * @return void
     */
    public function checkGivenAnInvalidPathFindReturnsNull(string $path): void
    {
        // Arrange
        $service = new RetrieveArrayValueByPathService();

        // Act
        $value = $service->find($path, ExampleArrayProvider::EXAMPLE_ARRAY);

        // Assert
        $this->assertNull($value);
    }
}
