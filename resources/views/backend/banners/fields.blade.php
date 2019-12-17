<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.banner_name')) !!}
    <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.banner_placeholder_name')]) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', __('messages.banner_url')) !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => __('messages.banner_placeholder_url')]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', __('messages.banner_image')) !!}
    <span class="required">(*)</span>
    @if(isset($banner))
        <div><img src="{!! $banner->image !!}" style="height: 200px"></div>
        <br>
    @endif
    {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('messages.banner_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', __('messages.banner_status')) !!}
    <label class="radio-inline">
    {!! Form::radio('status', 1,true, ['class'=>'minimal']) !!} {{ Helper::convertChecked(1) }}
    </label>
    <label class="radio-inline">
    {!! Form::radio('status', 2,false, ['class'=>'minimal']) !!} {{ Helper::convertChecked(2) }}
    </label>
{{--    {!! Form::select('status',[''=>__('messages.selected'),1=>Helper::convertChecked(1), 2=>Helper::convertChecked(2)] ,null, ['class' => 'form-control']) !!}--}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.banners.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>