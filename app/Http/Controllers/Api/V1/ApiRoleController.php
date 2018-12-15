<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Http\Transformers\EntriesTransformer;
use Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \App\Http\Transformers\GlobalTransformer;


class ApiRoleController extends Controller
{
	/*
	 * Assign Role to user
	 * Request Type: get
	 */
	public function assignRole(Request $request, $user_id, $role_id, $community_id) {
		$community = Helper::getCommunity($community_id);
		$user = $community->members()->findorfail($user_id);        

        // if(!P::checkPermission('assign-role-permission', $community)) {
        //     return view('errors.403');       
        // }

        // $this->validate($request,[
        //     'user_id' => 'required|string|max:255',
        //     'role_id' => 'required|string|max:255'
        // ]);
    
        \DB::beginTransaction();
        try { 
            $roles = $user->roles()->where('community_id', $community->id)->get();

            if(count($roles) > 0) {
                $role_id = $user->roles()->first()->id;
                $user->removeRole($role_id);
            }

            if($role_id != 0){
                $role = Role::findorfail($role_id);
                $user->assignRole($role);                
            }
            
        } catch (\Exception $e) {                
            \DB::rollback();  
        	return Helper::sendResponse(false, 'Role assign unable to updated  '.$community->name);
        } finally { 
            \DB::commit();

            $message = trans('general.assign_role.updated');
        	return Helper::sendResponse(true, $message."".$community->name);

        }

	}

	/*
	 * Create new role 
	 * Request Type: post
	 */
	public function createRole(Request $request, $community_id) {
       	$community = Helper::getCommunity($community_id);
       	// if(!P::checkPermission('manage-role', $community)) {
  //           return view('errors.403');       
  //       }
		$this->validate($request,[
            'name' => 'required|string|max:255'
        ]);

        $role_name = $community->name.'_'.$request->name;
            
        $unique = Role::where('community_id', $community->id)
                            // ->where('id', '!=', $request->role_id)
                            ->where('name', $role_name)
                            ->first();
            
        if($unique) {
            $error = trans('general.role.error.unique');
            return Helper::sendResponse(false, $error);
        }

        if($request->permissions == '') {
            $error = trans('general.role.error.role-select');
            return Helper::sendResponse(false, $error);
        }

        \DB::beginTransaction();
        try {

                $role =  Role::create([
                                'name' => $role_name,
                                'display_name' =>$request->name,
                                'community_id' =>  $community->id,
                            ]);

            foreach ($request->permissions as $key => $permission) {
                $role->givePermissionTo($permission);
            }

        } catch (\Exception $e) {    

            \DB::rollback();  
                $error = 'Something went to wrong';
                return Helper::sendResponse(false, $error);
        } finally { 
            \DB::commit();

            $message = trans('general.role.created');
        	return Helper::sendResponse(true, $message.' '.$community->name);

        }
	}

	/*
	 * Get all roles
	 * Request Type: get
	 */
	public function getAllRole(Request $request, $community_id) {
		$community = Helper::getCommunity($community_id);

		// if(!P::checkPermission('manage-role', $community)) {
  //           return view('errors.403');       
  //       }

        $roles = Role::where('community_id', $community->id)->paginate(20);
        $trnsform = GlobalTransformer::transformall_allroles($roles);

    	return Helper::sendResponse(true, '',$trnsform);

	}

	/*
	 * Update existing role
	 * Request Type: post
	 */
	public function updateRole(Request $request, $role_id, $community_id) {
		$community = Helper::getCommunity($community_id);

		// if(!P::checkPermission('manage-role', $community)) {
  //           return view('errors.403');       
  //       }

        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);

        $role_name = $community->name.'_'.$request->name;
            
        $unique = Role::where('community_id', $community->id)
                            ->where('id', '!=', $request->role_id)
                            ->where('name', $role_name)
                            ->first();
            
        if($unique) {
            $error = trans('general.role.error.unique');
            return Helper::sendResponse(false, $error);
        }

        if($request->permissions == '') {
            $error = trans('general.role.error.role-select');
            return Helper::sendResponse(false, $error);
        }
        
        \DB::beginTransaction();
        try { 
                $role = Role::where('community_id', $community->id)->findorfail($role_id);

                $role->update([
                    'name' => $role_name,
                    'display_name' =>$request->rolename,
                ]);

            \DB::table('role_has_permissions')->where('role_id',$role_id)->delete();

            foreach ($request->permissions as $key => $permission) {
                $role->givePermissionTo($permission);
            } 
        } catch (\Exception $e) {                
            \DB::rollback();  
        	return Helper::sendResponse(false, 'Role unable to update '.$community->name);
        	
        } finally { 
            \DB::commit();
            
            $message = trans('general.role.updated');
	    	return Helper::sendResponse(true, $message);

        }
	}

	/*
	 * Delete exsisting role
	 * Request Type: get
	 */
	public function deleteRole(Request $request, $id, $community_id) {
		$community = Helper::getCommunity($community_id);

		// if(!P::checkPermission('manage-role', $community)) {
  //           return view('errors.403');       
  //       }
        
        \DB::beginTransaction();
        try { 

            $role = Role::where('community_id', $community->id)->findorfail($id);
            

            \DB::table('role_has_permissions')->where('role_id',$id)->delete();

            $role->delete();

        } catch (\Exception $e) {                
            \DB::rollback();  
        	return Helper::sendResponse(false, 'Role unable to delete '.$community->name);

        	
        } finally { 
            \DB::commit();

            $message = trans('general.role.deleted');
        	return Helper::sendResponse(true, $message.' '.$community->name);

        }
	}

     /*
      * Get all permissions
      */
    public function getAllPermissions($community_id) {
        $trnsform = GlobalTransformer::transformgetAllPermissions(Permission::all());
        return Helper::sendResponse(true, '', $trnsform);
        
    }

}