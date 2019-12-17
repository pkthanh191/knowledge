<!-- Id Field -->
<div class="row">
    <div class="col-md-3">
        @if(!empty($user->avatar) && (file_exists(public_path($user->avatar))))
            <img src="{!! $user->avatar !!}" alt="{!! $user->name !!}" width="250px" height="250px">
        @else
            <img src="/uploads/default-avatar.png" alt="{!! $user->name !!}" width="270px" height="270px">
        @endif
    </div>
    <div class="col-md-9">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.user_group')) !!}</th>
                <td><p>{!! Helper::convertGroupUser($user->group_id) !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.user_name')) !!}</th>
                <td><p>{!! $user->name !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.user_email')) !!}</th>
                <td><p>{!! $user->email !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.user_sex')) !!}</th>
                <td><p>{!! Helper::convertSex($user->sex) !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.user_age')) !!}</th>
                <td><p>{!! $user->age  !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.user_phone')) !!}</th>

                <td><p>{!! $user->phone !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.user_account_balance')) !!}</th>

                <td><p>{!! Helper::format_money($user->account_balance, true, ' KNOW') !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.user_actived')) !!}</th>

                <td><p>{!! Helper::convertActived($user->actived) !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.user_address')) !!}</th>
                <td><p>{!! $user->address !!}</p></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


