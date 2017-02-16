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

// student factories
$factory->define(App\Student::class, function (Faker\Generator $faker) {
    $gender = $faker->randomElement(array("male", "female"));
    return [
        'nationality' => $faker->randomElement(array('AUS', 'CHN', 'GER', 'JPN', 'SGP')),
        'name' => $name = $faker->name($gender),
        'profile_pic' => $name . ".png",
        'nick' => $nick = ($faker->userName),
        'kattis' => $nick,
        'gender' => getGenderCode($gender),
    ];
});

// component factories
// Is there someway to do this more dry ?
$factory->define(App\Component::class, function (Faker\Generator $faker) {
    return [];
});

$factory->state(App\Component::class, 'MC', function ($faker) {
    return [
        'name' => 'MC'
        //'score' => half_dec_rand(0 , 4)
    ];
});

$factory->state(App\Component::class, 'TC', function ($faker) {
    return [
        'name' => 'TC'
        //'score' => half_dec_rand(0,1)
    ];
});

$factory->state(App\Component::class, 'BS', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1)
        'name' => 'BS'
    ];
});

$factory->state(App\Component::class, 'HW', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1.5)
        'name' => 'HW'
    ];
});

$factory->state(App\Component::class, 'KS', function ($faker) {
    return [
        //'score' => half_dec_rand(0,1)
        'name' => 'KS'
    ];
});

$factory->state(App\Component::class, 'AC', function ($faker) {
    return [
        //'score' => half_dec_rand(0,4)
        'name' => 'AC'
    ];
});

// score factories
$factory->define(App\Score::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->state(App\Score::class, 'MC', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 4),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
           return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});

$factory->state(App\Score::class, 'TC', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 19),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
            return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});
$factory->state(App\Score::class, 'BS', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 1),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
            return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});
$factory->state(App\Score::class, 'HW', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 1.5),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
            return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});
$factory->state(App\Score::class, 'KS', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 1),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
            return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});
$factory->state(App\Score::class, 'AC', function ($faker) {
    return [
        'score' => $faker->randomElement([half_dec_rand(0, 4),null]),
        'is_valid' => function(array $array_of_previously_defined_val){
            return ($array_of_previously_defined_val['score'] === null) ? false: true;
        }
    ];
});

// comment factory
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->realText($maxNbChars = 200, $indexSize = 2)
    ];
});

$factory->define(App\Record::class, function(Faker\Generator $faker){
    // randomly retrieve an achievement from achievements
    $faker->unique(true);
    return [
        'achievement_id'=> $faker->numberBetween(1,8),
        'points' => 1
    ];
});


// helper methods
function getGenderCode($gender) {
    if ($gender != "male" && $gender != "female") {
        throw new Exception("Unexpected gender");
    }
    return $gender == "male" ? "M" : "F";
}

function half_dec_rand($min, $max) {
    return mt_rand($min * 2, $max * 2) / 2;
}
