<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CustomerReview;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\User;
use App\Models\WorkshopSession;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::updateOrCreate([
      'name' => 'Administrateur',
      'role' => 'ROLE_ADMIN',
      'email' => 'admin@windigo.com',
      'password' => Hash::make('test123'),
      'billing_address' => 10,
      'delivery_address' => 10,
      'email_verified_at' => now(),
      'remember_token' => Str::random(10)
    ]);

    User::updateOrCreate([
      'name' => 'Utilisateur',
      'role' => 'ROLE_USER',
      'email' => 'user@windigo.com',
      'password' => Hash::make('test123'),
      'billing_address' => 10,
      'delivery_address' => 10,
      'email_verified_at' => now(),
      'remember_token' => Str::random(10)
    ]);

    $this->call([
      WorkshopSeeder::class,
      CategorySeeder::class,
      OptionSeeder::class
    ]);

    User::factory(10)->create();
    Product::factory(5)->create();
    Cart::factory(2)->create();
    Order::factory(5)->create();
    OrderProduct::factory(5)->create();
    // WorkshopSession::factory(10)->create();
    // Reservation::factory(3)->create();
    // CustomerReview::factory(5)->create();
  }
}
