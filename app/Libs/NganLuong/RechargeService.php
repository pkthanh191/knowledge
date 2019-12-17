<?php
namespace App\Libs\NganLuong;

use App\Libs\NganLuong\Checkout\NL_MicroCheckout;

class RechargeService
{
    public function checkout()
    {
        $inputs = array(
            'receiver'		=> config('checkout.RECEIVER'),
            'order_code'	=> 'DH-'.date('His-dmY'),
            'return_url'	=> route('payment_success'),
            'cancel_url'	=> '',
            'language'		=> 'vn'
        );


        $obj = new NL_MicroCheckout(config('checkout.MERCHANT_ID'), config('checkout.MERCHANT_PASS'), config('checkout.URL_WS'));
        $result = $obj->setExpressCheckoutDeposit($inputs);

        if ($result != false) {
            if ($result['result_code'] == '00') {
                $link_checkout = $result['link_checkout'];
                $link_checkout = str_replace('micro_checkout.php?token=', 'index.php?portal=checkout&page=micro_checkout&token_code=', $link_checkout);
                $link_checkout .='&payment_option=nganluong';
            } else {
                die('Ma loi '.$result['result_code'].' ('.$result['result_description'].') ');
            }
        } else {
            die('Loi ket noi toi cong thanh toan ngan luong');
        }

        return $link_checkout;
    }

}