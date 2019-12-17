<!doctype html>
<html>
    <head>
    </head>
    <body>
        <p>Xin chào <b>{!! $username !!}</b>,</p>

        <p>Chào mừng bạn tham gia vào Hệ thống thư viện trực tuyến KNOWLEDGE.VN. Hệ thống của bạn sẽ được thưởng 50 điểm KNOW trong tài khoản</p>

        <p>Bạn vui lòng vào link truy cập phía dưới để kích hoạt tài khoản:</p>

        <p>Link kích hoạt: <a href="{!! $link !!}">Nhấp vào đây</a></p>

        <p>Lưu ý: Nếu bạn gặp bất cứ sự cố gì vui lòng liên lạc với chúng tôi theo số điện thoại: {!! config('system.phone.value') !!}</p>

        <p>Xin cảm ơn!</p>

        <p>Nhóm phát triển KNOWLEDGE.VN</p>

        <p>Địa chỉ: {!! config('system.dia-chi.value') !!}</p>
    </body>
</html>
