<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class RoleSynchronisation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:role-synchronisation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // $roles = ['admin', 'recruteur', 'candidat'];
        // foreach ($roles as $role) {
        //     Role::create(['name' => $role]);
        // }
        try {
             // Vérifie la connexion à la BDD
            $roles = ['admin', 'recruteur', 'candidat'];

            foreach ($roles as $role) {
                if (!Role::where('name', $role)->exists()) {
                    Role::create(['name' => $role]);
                    $this->info("Rôle '$role' créé avec succès.");
                } else {
                    $this->info("Rôle '$role' existe déjà.");
                }
            }
        } catch (\Exception $e) {
            $this->error("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
