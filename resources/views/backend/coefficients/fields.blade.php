<!-- Apply Form Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apply_from', __('messages.coefficients_apply_from')) !!}
    <input type="datetime-local" id="apply_from" name="apply_from" class="form-control">
</div>

<!-- Apply To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apply_to', __('messages.coefficients_apply_to')) !!}
    <input type="datetime-local" id="apply_to" name="apply_to" class="form-control">
</div>

<!-- Cost Form Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost_from', __('messages.coefficients_cost_from')) !!}
    {!! Form::text('cost_from', isset($max_from)? $max_from : null, ['id'=>'coefficients_cost_from','class' => 'form-control', 'placeholder' => __('messages.coefficients_placeholder_cost_from')]) !!}
</div>

<!-- Cost To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost_to', __('messages.coefficients_cost_to')) !!}
    {!! Form::text('cost_to', null, ['id'=>'coefficients_cost_to','class' => 'form-control', 'placeholder' => __('messages.coefficients_placeholder_cost_to')]) !!}
</div>

<!-- Coefficient Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coefficient', __('messages.coefficient').'(1KNOW -> VNĐ)') !!}
    {!! Form::number('coefficient', null, ['class' => 'form-control', 'placeholder' => __('messages.coefficient_placeholder'), 'step'=>'0.01']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', __('messages.coefficients_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.coefficients.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
@if(isset($coefficient))
    <script>
        @if($coefficient->apply_from)
            var apply_from = "{{ str_replace(' ','T',$coefficient->apply_from) }}";
            document.getElementById("apply_from").value = apply_from;
        @endif
        @if($coefficient->apply_to)
            var apply_to = "{{ str_replace(' ','T',$coefficient->apply_to) }}";
            document.getElementById("apply_to").value = apply_to;
        @endif
    </script>
@endif
@if(old() != [])
    <script>
        document.getElementById("apply_from").value = "{{ old('apply_from') }}";
        document.getElementById("apply_to").value = "{{ old('apply_to') }}";
    </script>
@endif