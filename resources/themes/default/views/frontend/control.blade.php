@extends('layouts/frontend-master')

@section('content')

<div id="main">
    <div class="clearfix">&nbsp;&nbsp;&nbsp;</div>
    <div class="section pb-10">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabs vertical-tab mb-4">
                        <!-- Nav tabs -->
                        @include('includes/side') 
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active fade show" id="Page">
                                <div class="col-sm-12">
                                    <div>
                                        <div  class="text-center">
                                            <h3 class="heading fw-normal fz-34">{{$module_subtitle}}</h3>
                                        </div>
                                        <div class="clearfix">&nbsp;&nbsp;</div>
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-left: 15px">
                                                <a href="{{ route('frontend.admin.control.page.create') }}" class="btn btn-primary btn-sm btn-flat"> 
                                                    <span class="glyphicon glyphicon-plus"></span> Add
                                                </a>
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="contact-form-wrapper">
                                                    @include("includes/message")
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
                                                        <div class="table-responsive">
                                                          <table class="table table-condensed" id="members">
                                                            <thead>
                                                              <tr>
                                                                <th>Title</th>
                                                                <th>Slug</th>
                                                                <th>Meta Description</th>
                                                                <th>Meta Keywords</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($pages as $page)
                                                                <tr>
                                                                    <td> {{ $page->title }}</td>
                                                                    <td> {{ $page->slug }}</td>
                                                                    <td> {{ $page->meta_description }}</td>
                                                                    <td> {{ $page->meta_keywords }}</td>
                                                                    <td> {{ $page->status == '1' ? Active : Inactive}}</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action &nbsp;
                                                                            <span class="caret"></span></button>
                                                                            <ul class="dropdown-menu drop">
                                                                                <li>
                                                                                    <a href="{{route('frontend.get.control.edit',$page->id)}}"><i class="glyphicon glyphicon-edit" style="color: green;" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>Edit</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="{{ route('frontend.get.control.delete', $page->id) }}" class="trash_btn genericdelete" id="{{$page->id}}"><i class="glyphicon glyphicon-trash" style="color: red;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>Delete</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                          </table>
                                                        </div> <!-- table responsive -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    $(document).on("click",".trash_btn", function (e) {
        e.preventDefault();         
        
        var id = $(this).attr("id");

        var self = this;
        if (id != '') {
            swal({
                title: "Delete confirmation",
                text: "Are sure you want to delete ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    var url = $(self).attr('href');
                    window.location.href = url
                }
            });
        } else {

        }
    });
</script>
@endsection
