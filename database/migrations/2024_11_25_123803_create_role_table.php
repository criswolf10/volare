<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Verificar y crear el rol admin
        if (!Role::where('name', 'admin')->exists()) {
            $role1 = Role::create(['name' => 'admin']);
        } else {
            $role1 = Role::where('name', 'admin')->first();
        }

        // Verificar y crear el rol client
        if (!Role::where('name', 'client')->exists()) {
            $role2 = Role::create(['name' => 'client']);
        } else {
            $role2 = Role::where('name', 'client')->first();
        }

        // Asegurarse de que el usuario existe antes de asignarle un rol
        $user = User::find(1);
        if ($user) {
            $user->assignRole($role1);
        } else {
            // Manejo de error: el usuario no fue encontrado
            dd('Usuario no encontrado');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
