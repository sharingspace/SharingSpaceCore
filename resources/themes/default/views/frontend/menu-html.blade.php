<div class="row">
    <div class="col-md-12">
        <div class="form-control-wrap">
            {{ Form::text('name',null, ['class' => 'form-text', 'placeholder'=> "Enter Name *"]) }}
        </div>
    </div>    

    <div class="col-md-12">
        <div class="form-control-wrap">
            {!! Form::select('page_id', $pages, null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="text-center">
            <input type="submit" value="Submit Now" class="submit button style-flat button-primary">
        </div>
    </div>
</div>