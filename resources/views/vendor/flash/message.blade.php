@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}">
            {{--@if ($message['important'])--}}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                >&times;</button>
            {{--@endif--}}
            @if($message['level'] == 'success')
                <strong><i class="fa fa-info-circle"></i> @lang('messages.notification_success'): </strong> {!! $message['message'] !!}
            @endif

            @if($message['level'] == 'danger')
                <strong><i class="fa fa-info-circle"></i> @lang('messages.notification_error'): </strong> {!! $message['message'] !!}
            @endif

            @if($message['level'] == 'warning')
                <strong><i class="fa fa-warning"></i> @lang('messages.notification_warning'): </strong> {!! $message['message'] !!}
            @endif

        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
