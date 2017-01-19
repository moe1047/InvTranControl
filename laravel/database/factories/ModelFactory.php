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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(\App\Item::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,//randomDigit
        'qty' => $faker->randomDigit,
        'alert_qty' => $faker->randomDigit,
        'category_id' => 1,
    ];
});
$factory->define(\App\Item::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,//randomDigit
        'qty' => $faker->randomDigit,
        'alert_qty' => $faker->randomDigit,
        'category_id' => 1,
    ];
});

$factory->define(\App\Purchase::class, function (Faker\Generator $faker) {

    return [
        'ship_name' => $faker->name,//randomDigit
        'origin_country' => $faker->country,
        'purchased_date'=>$faker->dateTime
    ];
});
$factory->define(\App\PurchaseItems::class, function (Faker\Generator $faker) {

    return [
        'purchase_id' => $faker->name,//randomDigit
        'item_id' => 2,
        'qty' => $faker->randomDigit,

    ];
});
$factory->define(\App\Sale::class, function (Faker\Generator $faker) {

    return [
        'sale_date' => $faker->dateTime,//randomDigit
        'customer_id' => 4,
        'ordered_by' => 8,
        'driver_id' => 13,
        'plate_no' => $faker->randomDigit,
        'note' => $faker->sentence(),
        'status' => 'completed',
        'created_by' => 2,
        'total_items' => $faker->randomDigit,

    ];
});
$factory->define(\App\SaleItems::class, function (Faker\Generator $faker) {

    return [
        'sale_id' => $faker->name,//randomDigit
        'item_id' => 6,
        'qty' => $faker->randomDigit,
        'on_board' => $faker->randomDigit,
        'in_stock' => $faker->randomDigit,


    ];
});