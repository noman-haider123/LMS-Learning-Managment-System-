<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateController extends Controller implements HasMiddleware
{
       public static function middleware()
     {
        return [
            new Middleware('permission:User Details',only:['create']),
            new Middleware('permission:Permission Details',only:['createpermission']),
        ];
     }
    public function edit(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'Student' => 'required|string|max:255',
            'Address' => 'required|string|max:255',
            'Class' => 'required',
            'FatherMobile' => 'required|numeric|min:11',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $student = Student::findOrFail($id);
        $Auth = Auth::id();
        $student->update([
            'Name' => $request->Student,
            'Address' => $request->Address,
            'Class' => $request->Class,
            'Father_Mobile_Number' => $request->FatherMobile,
            'Create_By' => $Auth
        ]);
        if ($student) {
            return to_route('students.index')->with('complete', 'Student Updated successfully.');
        } else {
            return back()->with('error', 'Failed to update student.');
        }
    }
    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        return view('Authorization.createrole', compact('users', 'roles'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Role' => 'required|string|max:255',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $role = Role::create([
            'name' => $request->Role,
        ]);
        if ($role) {
            return to_route('createrole')->with('complete', 'Role created successfully.');
        } else {
            return back()->with('error', 'Failed to create role.');
        }
    }
    public function AssignRole(Request $request, $id)
    {
        $validated = $request->validate([
            'Role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('Role_id')) {
            $role = Role::findOrFail($request->Role_id);
            $user->syncRoles($role->name);
            $message = 'Role assigned successfully.';
        } else {
            $user->syncRoles([]);
            $message = 'Role removed successfully.';
        }

        return to_route('createrole')->with('Assign', $message);
    }
    public function createpermission()
    {
        $roles = Role::with('permissions')->get();
        $permission = Permission::all();
        return view('Authorization.createpermission', compact('roles', 'permission'));
    }
    public function storePermission(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Permission' => 'required|string|max:255',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $permission = Permission::create([
            'name' => $request->Permission,
        ]);
        if ($permission) {
            return to_route('createpermission')->with('complete', 'Permission created successfully.');
        } else {
            return back()->with('error', 'Failed to create permission.');
        }
    }
    public function assignPermission(Request $request, $id)
    {
        $validated = $request->validate([
         'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,id',        ]);

        $role = Role::findOrFail($id);

        if ($request->filled('permissions')) {
            $permission = Permission::findOrFail($request->permissions);
            $role->syncPermissions($permission);
            $message = 'Permission assigned successfully.';
        } else {
            $role->syncPermissions([]);
            $message = 'Permission removed successfully.';
        }

        return to_route('createpermission')->with('Permission', $message);
    }
    // public function datapass($id){
    //     $student = Student::findOrFail($id);
    //     return view('Student.index', compact('student'));
    // }
}