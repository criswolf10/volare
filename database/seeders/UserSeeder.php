<?php
namespace Database\Seeders;

use App\Models\Ticket;
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
            'password' => bcrypt('password'),
            'phone' => '625877564',
            'created_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        //Crear usuario cliente "Maria Berdun" y asignarle el rol client
        $clientRole = Role::where('name', 'client')->first();
        $client = User::create([
            'name' => 'Maria',
            'lastname' => 'Berdun',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '651465442',
            'created_at' => now(),
        ]);
        $client->assignRole($clientRole);

        // Crear 60 usuarios aleatorios y asignarles el rol client
        $clientRole = Role::where('name', 'client')->first();
        User::factory(20)->create()->each(function ($user) use ($clientRole) {
            $user->assignRole($clientRole);
                        // Obtener una cantidad aleatoria de tickets no asignados
                        $tickets = Ticket::whereNull('user_id')
                        ->inRandomOrder()
                        ->take(rand(1, 5))
                        ->get();

                    // Asignar esos tickets al usuario
                    foreach ($tickets as $ticket) {
                        $ticket->update(['user_id' => $user->id]);
                    }
                });

        }
    }

