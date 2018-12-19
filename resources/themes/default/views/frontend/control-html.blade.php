<div class="row">
    <div class="col-md-12">
        <div class="form-control-wrap">
            {{ Form::text('title',null, ['class' => 'form-text name_title', 'placeholder'=> "Enter Title *"]) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-control-wrap">
            <textarea id="file" name="body" cols="40" rows="4" class="form-textarea" placeholder="Body *">{{isset($model) ? $model->body : ""}}</textarea>
        </div>
    </div> 
    <div class="col-md-12">
        <div class="form-control-wrap">
            {{ Form::text('slug',null, ['class' => 'form-text slug_name', 'placeholder'=> "Enter Slug *"]) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-control-wrap meta_description">
            {{ Form::text('meta_description',null, ['class' => 'form-text', 'placeholder'=> "Enter Meta Description *"]) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-control-wrap meta_keywords">
            {{ Form::text('meta_keywords',null, ['class' => 'form-text', 'placeholder'=> "Enter Meta Keywords *"]) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-control-wrap">
            {!! Form::select('status', [""=>"Select Status", "0"=>"InActive", "1"=>"Active"  ], null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="text-center">
            <input type="submit" value="Submit Now" class="submit button style-flat button-primary">
        </div>
    </div>
</div>