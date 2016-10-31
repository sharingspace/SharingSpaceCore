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

$factory->defineAs(App\User::class, 'user', function ($faker) {
    return [
      'display_name' => $faker->name,
      'first_name' => $faker->firstName,
      'last_name' => $faker->lastName,
      'email' => $faker->email,
      'password' => bcrypt('password'),
      'remember_token' => str_random(10),
    ];
});


$factory->defineAs(App\User::class, 'admin', function ($faker) {
    return [
      'display_name' => $faker->name,
      'first_name' => $faker->firstName,
      'last_name' => $faker->lastName,
      'email' => $faker->email,
      'password' => bcrypt('password'),
      'remember_token' => str_random(10),
      'admin' => true,
    ];
});

$factory->defineAs(App\Entry::class, 'entry', function ($faker) {
    return [
      'title' => $faker->catchPhrase,
      'post_type' => $faker->randomElement(['want','have']),
      'qty' => 1,
    ];
});

$factory->defineAs(App\Entry::class, 'want-entry', function ($faker) {
    return [
      'title' => $faker->catchPhrase,
      'post_type' => 'want',
      'qty' => 1,
    ];
});

$factory->defineAs(App\Entry::class, 'have-entry', function ($faker) {
    return [
      'title' => $faker->catchPhrase,
      'post_type' => 'have',
      'qty' => 1,
    ];
});


$factory->defineAs(App\Community::class, 'community', function ($faker) {
    return [
      'name' => $faker->catchPhrase,
      'subdomain' => $faker->domainWord,
      'group_type' => $faker->randomElement(['O','S','C']),
    ];
});

$factory->defineAs(App\Entry::class, 'exchange-types', function ($faker) {
    return [
      'type_id' => $faker->numberBetween(1, 6),
    ];
});
