<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $roles = [
                'admin' => ['manage users', 'create task', 'update task', 'delete task'],
                'user' => ['create task']
            ];

            $permissions = ['manage users', 'create task', 'update task', 'delete task'];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }

            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::create(['name' => $roleName]);
                $role->syncPermissions($rolePermissions);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al crear roles y permisos: ' . $e->getMessage());

            throw new Exception('Ocurrió un error al crear roles y permisos');
        }
    }
}
