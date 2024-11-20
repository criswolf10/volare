<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que el rol 'client' existe
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Crear otros usuarios y asignarles el rol 'client'
        User::factory(100)->create()->each(function ($user) use ($clientRole) {
            if ($user->id !== 1) {
                $user->assignRole($clientRole);
            }
        });
    }
}
