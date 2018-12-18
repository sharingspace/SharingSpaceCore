@extends('layouts/frontend-master')

@section('content')
<div id="main">
    <div class="clearfix">&nbsp;&nbsp;&nbsp;</div>
    <div class="section pb-10">
        <div class="container">
            <div class="row">
              <div class="mb-7 text-center">
                <h3 class="heading text-center fw-normal fz-34">{{$module_subtitle}}</h3>
              </div>
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
                        <td> <a href="{{route('frontend.get.control.edit',$page->id)}}">{{ $page->title }}</a></td>
                        <td> {{ $page->slug }}</td>
                        <td> {{ $page->meta_description }}</td>
                        <td> {{ $page->meta_keywords }}</td>
                        <td> {{ $page->status }}</td>
                        <td> 
                          
                          <a href="{{ route('frontend.get.control.delete', $page->id) }}">
                            Delete
                          </a>
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

<script type="text/javascript">

</script>

@stop
