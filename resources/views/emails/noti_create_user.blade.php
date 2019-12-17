<!doctype html>
<html>
    <head>
    </head>
    <body>
        <p>Xin chào <b>{!! isset($username)?$username.',':',' !!}</b></p>

        <p>Chúc mừng bạn đã nạp thành công <b>{{ Helper::format_money($amount,true, ' VND') }}</b> tương ứng <b>{{ Helper::format_money($earn, true, ' KNOW') }}</b> tại Hệ thống thư viện trực tuyến KNOWLEDGE.VN</p>

        <p>Hệ thống đã tạo cho bạn tài khoản để bạn có thể dễ dàng quản lý. Thông tin tài khoản:</p>

        <p>Tên tài khoản: {{ $user_phone }}</p>

        <p>Mật khẩu mặc định: {{ $user_pass }}</p>

        @if(isset($enoughMoney) && $enoughMoney)
            <p>Tài khoản của bạn đã bị trừ <b>{{ Helper::format_money(config('system.minus-knows-tutorial.value'),true,' KNOW') }}</b> cho việc xem tìm gia sư và còn lại <b>{{ Helper::format_money($user_account_balance, true, ' KNOW') }}</b></p>

            <p>Mã code của bạn là {{ $code }}, chỉ áp dụng cho việc xem tin <a href="{{ route('tutorials') }}">{{ $tutorial_title }}</a></p>

            <p><b>Lưu ý: </b><p>

            <p>Mã code này chỉ có hiệu lực trong {{ config('system.time-effect.value') }} ngày</p>

        @endif

        @if(isset($enoughMoney) && !$enoughMoney)

        <p>Số tiền hiện tại của bạn vừa nạp không đủ để thực hiện xem chi tiết gia sư. Bạn cần nạp thêm <b>{{ Helper::format_money($moneyMiss,true, ' KNOW') }}</b> để có thể nhận được mã.</p>

        @endif

        <p>Nếu bạn gặp bất cứ sự cố gì vui lòng liên lạc với chúng tôi theo số điện thoại: {!! config('system.phone.value') !!}</p>

        <p>Xin cảm ơn!</p>

        <p>Nhóm phát triển KNOWLEDGE.VN</p>

        <p>Địa chỉ: {!! config('system.dia-chi.value') !!}</p>
    </body>
</html>
