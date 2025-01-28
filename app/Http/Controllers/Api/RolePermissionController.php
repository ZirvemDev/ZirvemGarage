<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use Bouncer;

class RolePermissionController extends Controller
{
    public function getRoles()
    {
        return response()->json(Role::all());
    }

    public function getAbilities()
    {
        return response()->json(Ability::all());
    }

    public function createRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'title' => 'required'
        ]);

        $role = Bouncer::role()->create([
            'name' => $validated['name'],
            'title' => $validated['title']
        ]);

        return response()->json($role);
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required'
        ]);

        $role->update($validated);

        return response()->json($role);
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function getRoleAbilities($roleId)
    {
        $role = Role::findOrFail($roleId);
        return response()->json($role->getAbilities());
    }

    public function syncRoleAbilities(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $abilities = $request->input('abilities', []);

        // Mevcut yetkileri temizle ve yenilerini ata
        Bouncer::sync($role)->abilities($abilities);

        return response()->json(['message' => 'Abilities synced successfully']);
    }
} 