<section>
    <div class="container margin-top-20">
        <div class="row ">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 style="text-align: center;">
                    {{trans('general.ask_permission.permissions')}} 
                </h3>
                <h4 style="text-align: center;">
                    {{trans('general.ask_permission.permission-text')}} 
                </h4>
                <table class="table table-striped">
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="col-sm-2"> 
                                    <strong>{{ $role->name }}</strong>
                                </td>
                                <td class="col-sm-8">
                                    <ul style="margin-bottom: 0px;">
                                        @forelse($role->permissions as $permission)
                                        
                                            <li>
                                                {{$permission->name}}
                                            </li>
                                        @empty
                                            No Data Found....!
                                        @endforelse
                                    </ul>
                                </td>
                                <td class="col-sm-2" style="vertical-align: middle;text-align: center;">
                                    <input type="radio" name="selected[{{$role->id}}]" style="text-align: center;">
                                </td>
                            </tr>
                        @empty
                            <tr colspan='3'>

                                No Data Found....!
                                
                            </tr>
                        @endforelse

                    </tbody>
                </table>

                <div style="background-color: #404040; padding: 10px;     margin-top: -19px;">
                    <label style="color:white; padding-bottom: 3px; ">Message (Optional)</label> 
                    <textarea name="message" class="form-control" placeholder="Add any additional information to send to the administrator by typing it here....." rows="4"  ></textarea>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <button class="btn btn-colored pull-right">
                    Save
                </button>
            </div>
        </div>
        
    </div>
</section>