@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('contacts')])
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <div id="main">
                <div class="travelo-google-map block">
                    <iframe
                            width="100%"
                            height="270"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3731.200557408454!2d105.91082272985942!3d20.742663663205146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1zVGhhbyBDaMOtbmgsIFRUIFBow7ogWHV5w6puLCBIdXnhu4duIFBow7ogWHV5w6puLCBUUCBIw6AgTuG7mWk!5e0!3m2!1sen!2s!4v1552182424052" allowfullscreen>
                    </iframe>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="travelo-box contact-us-box">
                            <h2 style="color: blue; text-transform: uppercase;">@lang('messages.frontend_contacts')</h2>
                            <ul class="contact-address">
                                <li class="address">
                                    <i class="soap-icon-address circle"></i>
                                        <h5 class="title">@lang('messages.frontend_address')</h5>
                                    <p>
                                        <a href="">{{ config('system.dia-chi.value') }}</a></p>
                                </li>
                                <li class="phone">
                                    <i class="soap-icon-phone circle"></i>
                                    <h5 class="title">@lang('messages.frontend_tutorial_phone')</h5>
                                    <p>Hotline: {{ config('system.phone.value') }}</p>
                                    {{--<p>Mobile: 093-527-6336</p>--}}
                                </li>
                                <li class="email">
                                    <i class="soap-icon-message circle"></i>
                                    <h5 class="title">Email</h5>
                                    <p><a href="mailto:contact@knowledge.vn">{{ config('system.contact.value') }}</a></p>
                                </li>
                                <li class="email">
                                    <i class="soap-icon-places circle"></i>
                                    <h5 class="title">Website</h5>
                                    <p><a href="http://knowledge.vn/">{{ config('system.website.value') }}</a></p>
                                </li>
                            </ul>
                            <ul class="social-icons full-width">
                                <li><a href="{{ config('system.twitter.value') }}" data-toggle="tooltip" title="{{ config('system.twitter.name') }}"><i class="soap-icon-twitter"></i></a></li>
                                <li><a href="{{ config('system.google-plus.value') }}" data-toggle="tooltip" title="{{ config('system.google-plus.name') }}"><i class="soap-icon-googleplus"></i></a></li>
                                <li><a href="{{ config('system.facebook.value') }}" data-toggle="tooltip" title="{{ config('system.facebook.name') }}"><i class="soap-icon-facebook"></i></a></li>
                                <li><a href="{{ config('system.linkedin.value') }}" data-toggle="tooltip" title="{{ config('system.linkedin.name') }}"><i class="soap-icon-linkedin"></i></a></li>
                                <li><a href="{{ config('system.vimeo.value') }}" data-toggle="tooltip" title="{{ config('system.vimeo.name') }}"><i class="soap-icon-vimeo"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="travelo-box">
                            <form class="contact-form" action="{{ route('contacts') }}" method="post">
                                {{ csrf_field() }}
                                <h2 class="box-title" style="text-transform: uppercase;">@lang('messages.frontend_contact')</h2>
                                <div class="row form-group">
                                    <div class="col-xs-6">
                                        <label>@lang('messages.frontend_contact_your_name')</label>
                                        <input type="text" name="name" class="input-text full-width">
                                    </div>
                                    <div class="col-xs-6">
                                        <label>@lang('messages.frontend_contact_your_email')</label>
                                        <input type="text" name="email" class="input-text full-width">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('messages.frontend_contact_content')</label>
                                    <textarea name="message" rows="10" class="input-text full-width" placeholder="@lang('messages.frontend_contact_contents')"></textarea>
                                </div>
                                <div class="col-xs-6">
                                </div>
                                <button type="submit" class="btn-large full-width">@lang('messages.frontend_contact_send_email')</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection



