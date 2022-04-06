# ArrayByPath

ArrayByPath is a library to get/set on an array using a dotted path

## Installation

Use composer to require the library:

```bash
composer require saasformation/array-by-path
```

## Getting started

Let's imagine you have the following array:

```php
$array = [
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
```

With ArrayByPath you get a value using a path like this:

```php
$name = (new RetrieveArrayValueByPathService())->find('data.attributes.name', $array); // "John"
```

Find will always return a value or null if the path does not exist.

```php
$invalidPath = (new RetrieveArrayValueByPathService())->find('foo', $array); // null
```

If you want to get an exception if the path not exists, then use get:

```php
$invalidPath = (new RetrieveArrayValueByPathService())->get('foo', $array); // InvalidPathException
```

Also, you can set a new value in the array using a path, like this:

```php
(new SetValueToArrayByPathService())->insert('data.attributes.height', $array, 177);
```

If the path already have a value, then a ```PathAlreadyExistsException``` will be thrown. If you prefer
to update the value in this situation, use ```upsert``` instead.

## Issues

If you find some issue in the library, please feel free to open an issue here on Github.
