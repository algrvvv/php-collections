<?php

require "./helper.php";

$coll = collect([1, 1, 2, 4]);

// $coll->avg(); // 2

// $coll = collect([
//     [4, 2, true],
//     ["string"],
//     [7]
// ]);

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
