<?php

require "./helper.php";

// $coll = collect([1, 1, 2, 4]);

// $coll = collect([
//     [4, 2, true],
//     ["string"],
//     [7]
// ]);

$coll = collect(['name', 'age']);

$coll->combine(['sasha', 18])->print;
