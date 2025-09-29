<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Console\Command;

class AssignTenantPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:assign-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign tenant permissions to Administrator role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Assigning tenant permissions to Administrator role...');

        // Buscar o role de Administrador
        $adminRole = Role::where('name', 'Administrador')->first();

        if (!$adminRole) {
            $this->error('Administrator role not found!');
            return 1;
        }

        // Buscar as permissões de tenants
        $tenantPermissions = Permission::whereIn('name', [
            'tenants.listar',
            'tenants.criar', 
            'tenants.editar',
            'tenants.excluir',
            'tenants.ver'
        ])->get();

        if ($tenantPermissions->isEmpty()) {
            $this->error('Tenant permissions not found! Please run the PermissionSeeder first.');
            return 1;
        }

        // Atribuir as permissões ao role
        foreach ($tenantPermissions as $permission) {
            if (!$adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
                $this->info("✓ Permission '{$permission->name}' assigned to Administrator role");
            } else {
                $this->comment("- Permission '{$permission->name}' already assigned");
            }
        }

        $this->info('✓ All tenant permissions have been assigned to Administrator role!');
        return 0;
    }
}
