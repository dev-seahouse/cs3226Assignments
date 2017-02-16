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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Student::class, function (Faker\Generator $faker) {
    $gender = $faker->randomElement(array("male", "female"));
    return [
        'nationality' => $faker->randomElement(array("CHN", "IDN", "SGP", "VNM", "MYS")),
        'name'        => $faker->name($gender),
        'gender'      => getGenderCode($gender),
        'nick'        => $nick = ($faker->userName),
        'kattis'      => $nick,
    ];
});

function getGenderCode($gender)
{
    if ($gender != "male" && $gender != "female") {
        throw new Exception("Unexpected gender");
    }

    return $gender == "male" ? "M" : "F";
}


