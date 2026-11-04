<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Crée les rôles et un compte administrateur par défaut.
     * Mot de passe à changer après la première connexion !
     */
    public function run(): void
    {
        foreach (['admin', 'recruteur', 'candidat'] as $role) {
            Role::findOrCreate($role, 'web');
        }

        if (! User::where('email', 'admin@myjob.mg')->exists()) {
            $admin = User::create([
                'name' => 'Administrateur',
                'email' => 'admin@myjob.mg',
                'role' => 'admin',
                'password' => 'password',
            ]);
            $admin->assignRole('admin');
        }
    }
}
