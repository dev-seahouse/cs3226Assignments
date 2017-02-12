<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Student::class, function (Faker\Generator $faker) {
   $gender = $faker->randomElement(array("male","female"));
;    return [
        'nationality' => $faker->randomElement(array("CHN", "IDN", "SGP", "VNM", "MYS")),
        'name'        => $faker->name($gender),
        'gender'      => getGenderCode($gender),
        'nick'        => $nick = ($faker->userName),
        'kattis'       => $nick
    ];
});


$factory->state(App\Component::class, 'MC', function ($faker) {
    return [
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'MC')->id;
        },
        //'score' => half_dec_rand(0 , 4)
    ];
});

$factory->state(App\Component::class, 'TC', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1)
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'TC')->id;
        },
    ];
});

$factory->state(App\Component::class, 'BS', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1)
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'BS')->id;
        },
    ];
});

$factory->state(App\Component::class, 'HW', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1.5)
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'HW')->id;
        },
    ];
});

$factory->state(App\Component::class, 'KS', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1)
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'KS')->id;
        },
    ];
});

$factory->state(App\Component::class, 'AC', function ($faker) {
    return [
        //'score' => half_dec_rand(0,4)
        "component_t_id" => function () {
            return App\ComponentType::where('name', 'AC')->id;
        },
    ];
});

function half_dec_rand($min, $max)
{
    return mt_rand($min * 2, $max * 2) / 2;
}


function getGenderCode($gender){
    if ($gender!="male" && $gender!="female") throw new Exception("Unexpected gender");
    return $gender == "male" ? "M" : "F";
}
