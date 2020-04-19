<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\category;
use Faker\Generator as Faker;

$factory->define(category::class, function (Faker $faker) {
    $i=category::all()->count();
    $parentid=null;
    if (1< $i and $i<5){
        $parentid=1;
    }
    if (10<$i ){
        $parentid=rand(1,11);
    }
    return [
        "name"=>$faker->sentence,
        "parent_id"=>$parentid
    ];

});
