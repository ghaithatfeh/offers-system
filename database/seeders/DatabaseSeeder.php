<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Customer;
use App\Models\CustomerInterest;
use App\Models\OfferType;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('asd'),
        ]);
        City::factory(5)->create();
        Category::factory(5)->create();
        Customer::factory(15)->create();
        CustomerInterest::factory(3)->create();
        Tag::factory(5)->create();
        OfferType::factory(3)->create();
    }
}
