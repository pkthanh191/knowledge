@if(!empty($errors))
    @if($errors->any())
        <ul class="alert alert-danger" style="list-style-type: none">
            @foreach($errors->all() as $index => $error)
                @if($index == 0)
                    <li> <strong><i class="fa fa-exclamation-circle"></i> @lang('messages.notification_errors'): </strong> {!! $error !!} <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button></li>
                @else
                    <li>&emsp;&emsp;&emsp;{!! $error !!}</li>
                @endif
            @endforeach
        </ul>
    @endif
@endif
