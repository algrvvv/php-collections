<?php

require "./helper.php";

// $coll = collect([1, 1, 2, 4]);

// $coll->avg(); // 2

// $coll = collect([
//     [4, 2, true],
//     ["string"],
//     [7]
// ]);

// $collection = collect([
//     [1, 2, 3],
//     [4, 5, 6],
//     [7, 8, 9],
// ]);

// $collection->collapse()->print(); // [1, 2, 3, 4, 5, 6, 7, 8, 9]

// $coll = collect(['name', 'age']);

// $coll->combine(['sasha', 18]); //['name' => 'sasha', 'age' => 18]

// $collection = collect(['John Doe']);

// $concatenated = $collection->concat(['Jane Doe'])->concat(['name' => 'Johnny Doe']);
// [0 => 'John Doe', 1 => 'Jane Doe', 'name' => 'Johnny Doe']

// $collection = collect([
//     "aaa" => [
//         "bbb" => [
//             "ccc" => "done"
//         ],
//         "bbb2" => "2"
//     ],

//     "bbb3" => [
//         "ccc2" => 3,
//         "ddd" => 4
//     ]
// ]);

// $collection->avg(); // 3

// var_dump($collection->contains("done")); // true

// $collection = collect(['name' => 'Desk', 'price' => 100]);

// $collection->contains('Desk'); //true
// $collection->contains('New York'); // false

// $collection->contains(2); // true
// $collection->containsStrict(2); // false

// $collection = collect([1, 2, 3, 4, 5]);

// $collection->diff(collect([2, 4, 6, 8]))->print(); // [1,3,5]
// $collection->diff([2, 4, 6, 8])->print(); // [1,3,5]

// $collection = collect(['a', 'b', 'a', 'c', 'b']);

// $collection->duplicates()->print(); // [2 => 'a', 4 => 'b']

// $collection = collect([1, 2, 3, 4]);

// $new = $collection->each(function (int $item, int $key) {
//     if($item == 3){
//         return false;
//     }

//     return $item;
// });

// $new->print(); // [0 => 1, 1 => 2]

// $user = collect(["login" => "exampleLogin", "email" => "test@example.com"]);

// $user->login; // exampleLogin
// $user->email; // test@example.com

// $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);

// $collection->except(['price', 'discount'])->print(); // ['product_id' => 1]
// $collection->except('price')->print(); // ['product_id' => 1, 'discount' => false]
// $collection->except('test')->print(); // ['product_id' => 1, 'price' => 100, 'discount' => false]

// $collection = collect([
//     'product_id' => 1,
//     'name' => 'Desk',
//     'price' => 100,
//     'discount' => false
// ]);

// $collection->only(['product_id', 'name'])->print(); // ['product_id' => 1, 'name' => 'Desk']

// $collection = collect([1, 2, 3, 4]);

// $collection->filter(function (int $value, int $key) {
//     return $value > 2;
// })->print(); // [3, 4]

// collect([1, 2, 3, 4])->first(function (int $value, int $key) {
//     return $value > 2;
// }); // 3

// collect([1, 2, 3, 4])->first(); // 1

// $collection = collect(['name' => 'sasha', 'framework' => 'laravel']);

// $collection->flip()->print(); // ['sasha' => 'name', 'laravel' => 'framework']

// $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);

// $collection->forget('name')->print(); // ['framework' => 'laravel']

// $collection = collect(['name' => 'sasha', 'framework' => 'laravel']);

// $value = $collection->get('name'); // 'sasha'
// $value = $collection->get('nameFramework', "laravel"); // 'laravel'

// $collection = collect([
//     [
//         'account_id' => 'account-x10',
//         'product' => 'Chair'
//     ],
//     [
//         'account_id' => 'account-x10',
//         'product' => 'Bookcase'
//     ],
//     [
//         'account_id' => 'account-x11',
//         'product' => 'Desk'
//     ],
// ]);

// $grouped = $collection->groupBy('account_id');

// $collection = collect(['account_id' => 1, 'product' => 'Desk', 'amount' => 5]);
 
// $collection->has('product'); // true

// $collection->has(['product', 'amount']); // true

// $collection = collect(['account_id' => 1, 'product' => 'Desk', 'amount' => 5]);
 
// $collection->hasAny(['product', 'price']); // true
 
// $collection->hasAny(['name', 'price']); // false

$collection = collect([
    ['account_id' => 1, 'product' => 'Desk'],
    ['account_id' => 2, 'product' => 'Chair'],
]);
 
$collection->implode('product', ', ');
 
// Desk, Chair

