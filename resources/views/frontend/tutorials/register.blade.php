@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('tutorials-register')])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div id="main">
                <div class="booking-section travelo-box">
                    <form method="POST" action="{{ route('tutorials.register.create') }}">
                        {{ csrf_field() }}
                        <div class="person-information">
                            <h2>@lang('messages.frontend_tutorial_info')</h2>
                            @include('flash::errors')
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-12">
                                    <label>@lang('messages.frontend_tutorial_title') <span class="required">(*)</span></label>
                                    {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_title')]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{--phone field--}}
                                <div class="col-sm-6 col-md-6">
                                    <label>@lang('messages.frontend_tutorial_phone') <span class="required">(*)</span></label>
                                    {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_phone')]) !!}
                                </div>
                                {{--email field--}}
                                <div class="col-sm-6 col-md-6">
                                    {!! Form::label('email', __('messages.frontend_tutorial_email')) !!}
                                    {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_email')]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--subject field--}}
                                <div class="col-sm-6 col-md-6">
                                    <label>@lang('messages.frontend_tutorial_subject') <span class="required">(*)</span></label>
                                    @if(old()!=[] && old('subjects')!=[])
                                        {!! Form::select('subject_id', $subjects,collect(old('subjects')), ['class' => 'form-control','multiple' => 'multiple','id'=>'subject_ids','name'=> 'subjects[]']) !!}
                                    @else
                                        {!! Form::select('subject_id', $subjects,isset($tutorial) ? $tutorial->subjects : null, ['class' => 'form-control','multiple' => 'multiple','id'=>'subject_ids','name'=> 'subjects[]']) !!}
                                    @endif
{{--                                    {!! Form::select('subject_id', $subjects, null, ['required', 'class' => 'form-control', 'multiple' => 'multiple', 'name' => 'subjects[]']) !!}--}}
                                </div>
                                {{--grade field--}}
                                <div class="col-sm-6 col-md-6">
                                    <label>@lang('messages.frontend_tutorial_grade') <span class="required">(*)</span></label>
                                    @if(old()!=[] && old('grades')!=[])
                                        {!! Form::select('grade_id', $grades,collect(old('grades')), ['class' => 'form-control', 'multiple' => 'multiple','name'=> 'grades[]']) !!}
                                    @else
                                        {!! Form::select('grade_id', $grades,isset($tutorial) ? $tutorial->grades : null, ['class' => 'form-control', 'multiple' => 'multiple','name'=> 'grades[]']) !!}
                                    @endif
                                    {{--{!! Form::select('grade_id', $grades, null, ['required', 'class' => 'form-control', 'multiple' => 'multiple', 'name' => 'grades[]']) !!}--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--frequency field--}}
                                <div class="col-sm-6 col-md-6">
                                    {!! Form::label('frequency', __('messages.frontend_tutorial_frequency')) !!}
                                    {!! Form::number('frequency', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_frequency')]) !!}
                                </div>
                                {{--period field--}}
                                <div class="col-sm-6 col-md-6">
                                    {!! Form::label('period', __('messages.frontend_tutorial_period')) !!}
                                    {!! Form::text('period', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_period')]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--salary field--}}
                                <div class="col-sm-6 col-md-6">
                                    {!! Form::label('salary', __('messages.frontend_tutorial_salary')) !!}
                                    {!! Form::text('salary', null, ['class' => 'form-control','placeholder'=>__('messages.tutorials_placeholder_salary')]) !!}
                                </div>
                                {{--address field--}}
                                <div class="col-sm-6 col-md-6">
                                    {!! Form::label('address', __('messages.frontend_tutorial_address')) !!}
                                    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder'=>__('messages.tutorials_placeholder_address')]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--city field--}}
                                <div class="col-sm-6 col-md-6">
                                    <label>@lang('messages.frontend_tutorial_city') <span class="required">(*)</span></label>
                                    {!! Form::select('city_id', $cities, null, ['required', 'class' => 'form-control', 'id' => 'city_id']) !!}
                                </div>
                                {{--district field--}}
                                <div class="col-sm-6 col-md-6">
                                    <label>@lang('messages.frontend_tutorial_district') <span class="required">(*)</span></label>
                                    {!! Form::select('district_id', $districts, null, ['required', 'class' => 'form-control', 'id' => 'district_id']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--requirement field--}}
                                <div class="col-sm-12 col-md-12">
                                    {!! Form::label('requirement', __('messages.frontend_tutorial_requirement')) !!}
                                    {!! Form::textarea('requirement', null, ['class' => 'form-control', 'placeholder'=>__('messages.tutorials_placeholder_requirement')]) !!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-3 col-md-3">
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <button type="submit" class="full-width btn-large">@lang('messages.frontend_tutorial_register')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection