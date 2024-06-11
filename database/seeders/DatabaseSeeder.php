<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создание пользователя
        $admin = User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]
        );


        $this->call([CraigslistPostSeeder::class]);

        //

        $this->call([AutoPostSeeder::class]);
    }
}
