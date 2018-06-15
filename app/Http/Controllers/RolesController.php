<?php
/**
 * This controller handles all actions related to Entries for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{ 


    /**
     * Returns a view that displays the all the roles.
     *
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    RolesController::getAllRoles()
     * @since  [v1.0]
     * @return View
     */
    public function getAllRoles() {
        $data['roles'] = Role::all();
        return view('roles.list',$data);
    }

    /**
     * Returns a view that displays the form to create a roles.
     *
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    RolesController::postRoleCreate()
     * @since  [v1.0]
     * @return View
     */
    public function getRoleCreate() {
        $data['permissions'] = Permission::all();
        


        return view('roles.view', $data);
    }


    /**
     * Validates and stores the data for a new role for community admin.
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    CommunitiesController::getCreate()
     * @since  [v1.0]
     * @param Request $request
     * @return Redirect
     */
    public function postRoleCreate(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);
            
        $role = Role::create(['name' => $request->name ]);
        
        if($request->permissions != '') {
            foreach ($request->permissions as $key => $permission) {
                $role->givePermissionTo($permission);
            }
        }

        $message = 'Role successfully created';
        return redirect()->back()->with('success',$message);
    }

    /**
     * Returns a form view to edit a role
     *
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    CommunitiesController::postEditRole()
     * @since  [v1.0]
     * @return View
     */
    public function getEditRole(Request $request, $id) {
        $data['id'] = $id;
        $data['model'] = Role::find($id);
        $data['role_permissions'] = $data['model']->permissions()->pluck('id')->toArray();
        $data['permissions'] = Permission::get();

        return view('roles.view',$data);
    }

    /**
     * Validates and stores the role edits.
     *
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    CommunitiesController::getEditRole()
     * @since  [v1.0]
     * @return Redirect
     */
    public function postEditRole(Request $request) {
        Role::find($request->id)->update([
            'name' => $request->name
        ]);

        $role = Role::find($request->id);        
        \DB::table('role_has_permissions')->where('role_id',$request->id)->delete();
        
        if($request->permissions != '') {
            foreach ($request->permissions as $key => $permission) {
                $role->givePermissionTo($permission);
            }
        }

        $message = 'Role successfully updated';
        return redirect()->back()->with('success',$message);
    }
}
