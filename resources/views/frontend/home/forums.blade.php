@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div id="main" style="margin-top: 15px;">
            <div class="row">
                @if(session('modal_auth'))
                    @include('frontend.home.modal_auth_email');
                @endif
                <div class="col-sm-4 col-md-3">
                    @include('frontend._partials.menu-doc-categories')
                </div>
                <div class="col-sm-8 col-md-9">
                    <div class="row white-block-list">
                        <div class="col-xs-12 col-md-6">
                            <h2 class="header-home-list">
                                <a href="{{ route('documents') }}" class="uppercase">@lang('messages.frontend-home-doc')</a>
                            </h2>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('documents') }}" method="GET">
                                <div class="form-group with-icon full-width search-toolbar" style="margin-left: 10px;">
                                    <input type="text" name="search[name]" value="" class="input-text full-width" placeholder="Tìm kiếm tên tài liệu">
                                    <button type="submit" class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row hotel-list listing-style3 hotel white-block-list">
                        <table class="table-forums">
                            <thead>
                                <tr>
                                    {{--<th width="50" class="text-center">STT</th>--}}
                                    <th style="padding-left: 10px;">Chủ đề</th>
                                    <th width="80" class="text-center">Lượt xem</th>
                                    <th width="120" class="text-center">Lượt bình luận</th>
                                    <th width="180" class="text-center">Người bình luận cuối</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $key => $document)
                                    <tr>
                                        {{--<td class="text-center">{{ $key + 1 }}. </td>--}}
                                        <td style="padding-left: 10px;"><a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a></td>
                                        <td class="text-center"><a href="{{ route('documents.show', $document->slug) }}">{{ $document->view_counts }}</a></td>
                                        <td class="text-center"><a href="{{ route('documents.show', $document->slug) }}">{{ count($document->comments) }}</a></td>
                                        @if (count($document->comments) > 0)
                                            <td class="text-center">{{ $document->comments[0]->user->name }}</td>
                                        @else
                                            <td class="text-center">---</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row white-block-list">
                        <div class="col-xs-12 col-md-6">
                            <h2 class="header-home-list">
                                <a href="{{ route('tests') }}" class="uppercase">@lang('messages.frontend-home-test')</a>
                            </h2>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('documents') }}" method="GET">
                                <div class="form-group with-icon full-width search-toolbar" style="margin-left: 10px;">
                                    <input type="text" name="search[name]" value="" class="input-text full-width" placeholder="Tìm kiếm tên đề thi">
                                    <button type="submit" class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row hotel-list listing-style3 hotel white-block-list">
                        <table class="table-forums">
                            <thead>
                            <tr>
                                {{--<th width="50" class="text-center">STT</th>--}}
                                <th style="padding-left: 10px;">Chủ đề</th>
                                <th width="80" class="text-center">Lượt xem</th>
                                <th width="120" class="text-center">Lượt bình luận</th>
                                <th width="180" class="text-center">Người bình luận cuối</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tests as $key => $document)
                                <tr>
                                    {{--<td class="text-center">{{ $key + 1 }}. </td>--}}
                                    <td style="padding-left: 10px;"><a href="{{ route('tests.show', $document->slug) }}">{{ $document->name }}</a></td>
                                    <td class="text-center"><a href="{{ route('tests.show', $document->slug) }}">{{ $document->view_counts }}</a></td>
                                    <td class="text-center"><a href="{{ route('tests.show', $document->slug) }}">{{ count($document->comments) }}</a></td>
                                    @if (count($document->comments) > 0)
                                        <td class="text-center">{{ $document->comments[0]->user->name }}</td>
                                    @else
                                        <td class="text-center">---</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



