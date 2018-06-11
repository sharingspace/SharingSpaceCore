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

use App\Exceptions\ModelOperationException;
use App\Helpers\Wrld3D\PoiManager;
use App\Jobs\Entry\DeleteEntry;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Input;
use Redirect;
use Helper;
use Log;
use App\Models\Entry;
use Illuminate\Support\Facades\Route;
use App\Helpers\CommunityEntries;

class RolesController extends Controller
{

    /**
     * Returns a view that displays the form to create a roles.
     *
     * @author [Dhaval Mesavaniya] [<dhaval48@gmail.com>]
     * @see    RolesController::postRoleCreate()
     * @since  [v1.0]
     * @return View
     */
    public function getRoleCreate() {

        return view('roles.view');
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
}
