<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerInterest;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Customer::factory(10)->create();
        // CustomerInterest::factory(3)->create();
        Tag::factory(5)->create();
    }
}
