<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Flash;

class ContactsController extends Controller
{

    public function index()
    {
        $type = 'contacts';
        return view('frontend.contacts.index', compact('type'));
    }

    public  function contact(Request $request){
        $text = 'Tên: '.$request['name'].'<br>Email: '.$request['email'].'<br>Tin nhắn: '.$request['message'];

        Mail::send([], [], function ($message) use($text, $request) {
            $message->to(config('system.contact.value'))->subject('Yêu cầu liên hệ từ khách hàng: '.$request['email'])->setBody($text, 'text/html'); // for HTML rich messages
        });

        Flash::success('Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ phản hồi vào email của bạn sớm nhất có thể');
        return redirect('/');
    }
}
