<?php

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
        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        factory(\App\Product::class)->create([
            'name' => 'Unitron'
        ]);
        factory(\App\Product::class)->create([
            'name' => 'Signia'
        ]);
        factory(\App\Product::class)->create([
            'name' => 'Starkey'
        ]);
    }
}
