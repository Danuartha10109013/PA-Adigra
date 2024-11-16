<?php

namespace App\Http\Repository;

use App\Models\Role;

class RoleRepository
{
    
    public function getAll()
    {
        try {
            return Role::get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getById($id)
    {
        try {
            return Role::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create($request)
    {
        try {
            $role = new Role;
            $role->name = $request->name;
            $role->save();
            return $role;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function update($request, $id)
    {
        try {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();
            return $role;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function delete($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return $role;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}