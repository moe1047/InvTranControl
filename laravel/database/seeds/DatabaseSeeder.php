<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\User::class,100)->create();
        //factory(\App\Item::class,500)->create();
        /*factory(App\Purchase::class, 5000)->create()->each(function ($u) {
            $u->purchaseItems()->save(factory(App\PurchaseItems::class)->make());
        });*/

        factory(App\Sale::class, 20000)->create()->each(function ($u) {
            $u->saleItems()->save(factory(App\SaleItems::class)->make());
        });

        // $this->call(UsersTableSeeder::class);$u->posts()->save(factory(App\Post::class)->make());
    }
}
