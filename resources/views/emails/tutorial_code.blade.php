<!doctype html>
<html>
    <head>
    </head>
    <body>
        <p>Xin chào <b>{!! isset($username)?$username:'' !!}</b>,</p>

        <p>Chúc mừng bạn đã nhận thành công mã code tại Hệ thống thư viện trực tuyến KNOWLEDGE.VN</p>

        <p>Tài khoản của bạn đã bị trừ <b>{{ Helper::format_money(config('system.minus-knows-tutorial.value'),true,' KNOW') }}</b> cho việc xem tìm gia sư và còn lại <b>{{ Helper::format_money($user_account_balance, true, ' KNOW') }}</b></p>

        <p>Mã code của bạn là {{ $code }}, chỉ áp dụng cho việc xem tin <a href="{{ route('tutorials') }}">{{ $tutorial_title }}</a></p>

        <p><b>Lưu ý: </b><p>

        <p>Mã code này chỉ có hiệu lực sau {{ config('system.time-effect.value') }} tiếng kể từ thời điểm này.</p>

        <p>Nếu bạn gặp bất cứ sự cố gì vui lòng liên lạc với chúng tôi theo số điện thoại: {!! config('system.phone.value') !!}</p>

        <p>Xin cảm ơn!</p>

        <p>Nhóm phát triển KNOWLEDGE.VN</p>

        <p>Địa chỉ: {!! config('system.dia-chi.value') !!}</p>
    </body>
</html>
