<?php
namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

        // Crear usuario admin "Cristian Lobo" y asignarle el rol admin
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::create([
            'name' => 'Cristian',
            'lastname' => 'Lobo',
            'email' => 'cristianlobojimenez10@gmail.com',
            'password' => bcrypt('password'), // Asegúrate de usar una contraseña segura
            'phone' => '625 877 564',
            'created_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Crear 60 usuarios aleatorios y asignarles el rol client
        $clientRole = Role::where('name', 'client')->first();
        User::factory(20)->create()->each(function ($user) use ($clientRole) {
            $user->assignRole($clientRole);
        });
    }
}
