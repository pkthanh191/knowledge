<?php

namespace App\Helpers;

use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{

    public static $TRANS_RECHARGE = 1;
    public static $TRANS_RECHARGE_CARD = 2;
    public static $TRANS_COMMENT_DOC = 3;
    public static $TRANS_DOWNLOAD_DOC = 4;
    public static $TRANS_DOWNLOAD_TEST = 5;
    public static $TRANS_VIEW_TUTORIAL = 6;
    public static $TRANS_NEW_ACCOUNT = 8;
    public static $TRANS_GUEST_RECHARGE = 7;
    public static $TRANS_SUB_MONEY = 9;

    public static function exchangeVNDtoKnow($vnd)
    {
        $condition = [['cost_from', '<', $vnd], ['cost_to', '>=', $vnd]];
        $coefficients = DB::table('coefficients')->select('coefficients.*')->where($condition)->get();
        if ($coefficients) {
            $use_default = true;
            foreach ($coefficients as $c) {
                if ($c->apply_from < Carbon::now() && $c->apply_to > Carbon::now()) {
                    $use_default = false;
                    $coefficient = $c->coefficient;
                }
            }
            if ($use_default) $coefficient = $coefficients->first()->coefficient;
        } else {
            $temp = DB::table('coefficients')->select('coefficients.*')->where([['cost_to','<=',$vnd]])->orderBy('cost_to','desc')->first();
            $coefficient = $temp? $temp->coefficient : 1;
        }
        if ($coefficient)
            return intval($vnd / $coefficient);
        else return 0;
    }

    public static function sub($description, $maxLength)
    {
        return subDescription($description, $maxLength);
    }

    public static function copyright()
    {
        return 'BLOOMGOO.VN';
    }

    public static function formatCategories($categories, $separator = ', ')
    {
        $html = '';
        foreach ($categories as $category) {
            if (empty($html)) $html = $category->name;
            else $html .= $separator . $category->name;
        }
        return $html;
    }

    public static function getCategoryTests($test)
    {
        $arr = \App\Models\CategoryTest::whereIn('id', Test::join('test_categories', function ($join) use ($test) {
            $join->on('tests.id', 'test_categories.test_id')->where('tests.id', $test->id)->whereNull('test_categories.deleted_at');
        })->pluck('test_categories.category_test_id'))->pluck('name');
        return $arr;
    }

    public static function rip_tags($string)
    {
        $string = preg_replace('/<[^>]*>/', ' ', $string);

        // ----- remove control characters -----
        $string = str_replace("\r", '', $string);    // --- replace with empty space
        $string = str_replace("\n", ' ', $string);   // --- replace with space
        $string = str_replace("\t", ' ', $string);   // --- replace with space

        // ----- remove multiple spaces -----
        $string = trim(preg_replace('/ {2,}/', ' ', $string));

        return $string;

    }

    public static function subDescription($description, $link, $maxLength = 300, $readmore = true)
    {
        if ($maxLength <= 0) return '';
        $descriptionText = self::rip_tags($description);
        if ($maxLength >= strlen($descriptionText)) {
            return trim($descriptionText);
        }
        $arrWordsDesciption = explode(' ', substr($descriptionText, 0, $maxLength));
        if (count($arrWordsDesciption) <= 1) {
            $list = explode(' ', $descriptionText);
            if (strlen($list[0]) > $maxLength) {
                return '';
            }
            return $list[0];
        }
        $count = count($arrWordsDesciption) - 2;
        if ($maxLength == strlen($descriptionText) || ($maxLength + 1 < strlen($descriptionText) && substr($descriptionText, $maxLength, 1) === ' ')) {
            $count = $count + 1;
        }
        $rs = '';
        for ($i = 0; $i <= $count; $i++) {
            $rs = $rs . $arrWordsDesciption[$i] . ' ';
        }
        if ($readmore) {
            $link = "<br><a href='$link'>  >> " . __('messages.read_more') . "</a>";
        } else {
            $link = " ...";
        }
        return trim($rs) . $link;
    }


    public static function formatSelectBoxForComment($listsIn, $id = null, $blank = true)
    {
        $listsOut = array();
        if ($blank) $listsOut[0] = '-- ' . __('messages.select_comment') . ' --';
        foreach ($listsIn as $item) {
            if ($item->id != $id || $id == null) {
                $listsOut[$item->id] = $item->content;
            }
        }
        return $listsOut;

    }

    public static function convertCategoryType($type)
    {
        if ($type == 1) {
            return "Lớp";
        } else if ($type == 2) {
            return "Môn";
        }
    }

    public static function convertGroupUser($group_id)
    {
        if ($group_id == 1) return __('messages.group_1');
        elseif ($group_id == 2) return __('messages.group_2');
        elseif ($group_id == 3) return __('messages.group_3');
    }

    public static function convertSex($sex)
    {
        if ($sex == 1) return __('messages.sex_1');
        elseif ($sex == 2) return __('messages.sex_2');
        else if ($sex == 3) return __('messages.sex_3');
    }

    public static function convertActived($actived)
    {
        if ($actived == 1) return __('messages.active_1');
        elseif ($actived == 2) return __('messages.active_2');
        elseif ($actived == 3) return __('messages.active_3');
    }

    public static function convertChecked($checked)
    {
        if ($checked == 1) return __('messages.check_1');
        elseif ($checked == 2) return __('messages.check_2');
    }

    public static function convertFeature($type)
    {
        if ($type == 1) {
            return __('messages.teacher_feature_on');
        } else if ($type == 0) {
            return __('messages.teacher_feature_off');
        }
    }

    public static function format_money($str, $has_unit = true, $unit = ' VNĐ')
    {
        if ($str == 0 || $str == null)
            return '';
        if ($has_unit)
            return number_format($str, 0, ".", ",") . $unit;
        else
            return number_format($str, 0, ".", ",");
    }

    public static function convertPosition($position)
    {
        if ($position == 1) return __('messages.banner_position_1');
        elseif ($position == 2) return __('messages.banner_position_2');
        else if ($position == 3) return __('messages.banner_position_3');
    }

    public static function convertTransaction($status)
    {
        if ($status == 1) return __('messages.transactions_status_1');
        elseif ($status == 2) return __('messages.transactions_status_2');
        else if ($status == 3) return __('messages.transactions_status_3');
    }

    public static function transText($vnStr, $seperator = "_")
    {
// In thường
        $vnStr = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $vnStr);
        $vnStr = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $vnStr);
        $vnStr = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $vnStr);
        $vnStr = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $vnStr);
        $vnStr = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $vnStr);
        $vnStr = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $vnStr);
        $vnStr = preg_replace("/(đ)/", 'd', $vnStr);
// In đậm
        $vnStr = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $vnStr);
        $vnStr = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $vnStr);
        $vnStr = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $vnStr);
        $vnStr = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $vnStr);
        $vnStr = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $vnStr);
        $vnStr = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $vnStr);
        $vnStr = preg_replace("/(Đ)/", 'D', $vnStr);
// Chuyển dấu cách thành _
        $vnStr = preg_replace("/ /", $seperator, $vnStr);
// Bỏ đi 2 dấu ()
        $vnStr = preg_replace("/\(|\)/", "", $vnStr);
        return strtolower($vnStr); // Trả về chuỗi đã chuyển
    }

    public static function generateName()
    {
        $firstNameArray = ['Vũ', 'Nguyễn', 'Đặng', 'Vương', 'Lâm', 'Mai', 'Trần', 'Đỗ', 'Dương'];
        $lastNameArray = ['Phong', 'Sơn', 'Thịnh', 'Thành', 'Trang', 'Thủy', 'Ánh'];
        $firstName = $firstNameArray[rand(0, sizeof($firstNameArray) - 1)];
        $lastName = $lastNameArray[rand(0, sizeof($lastNameArray) - 1)];
        $name = $firstName . ' ' . $lastName;
        return $name;
    }

    public static function generateTel($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz_.';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function makeLinks($str, $id = null, $slug = null, $url = null)
    {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
        $urls = array();
        $urlsToReplace = array();
        if (preg_match_all($reg_exUrl, $str, $urls)) {
            $numOfMatches = count($urls[0]);
            $numOfUrlsToReplace = 0;
            for ($i = 0; $i < $numOfMatches; $i++) {
                $alreadyAdded = false;
                $numOfUrlsToReplace = count($urlsToReplace);
                for ($j = 0; $j < $numOfUrlsToReplace; $j++) {
                    if ($urlsToReplace[$j] == $urls[0][$i]) {
                        $alreadyAdded = true;
                    }
                }
                if (!$alreadyAdded) {
                    array_push($urlsToReplace, $urls[0][$i]);
                }
            }
            $numOfUrlsToReplace = count($urlsToReplace);
            for ($i = 0; $i < $numOfUrlsToReplace; $i++) {
                if (Auth::check() && $id != null) {
                    $temp = $urlsToReplace[$i];
                    if ($url != null) {
                        $str = str_replace($urlsToReplace[$i], '<a href="'.$url.'">' . 'Nhấn vào đây để xem link <i class="glyphicon glyphicon-download-alt"></i>' . '</a>', $str);
                    }
                    else {
                        $str = str_replace($urlsToReplace[$i], '<a href="javascript:;" onclick="modalDownloadFromComment(' . $id . ',\'' . $slug . '\')">' . 'Nhấn vào đây để xem link <i class="glyphicon glyphicon-download-alt"></i>' . '</a>', $str);
                    }
                } else $str = str_replace($urlsToReplace[$i], '<a href="#dang-nhap" class="soap-popupbox">Nhấn vào đây để xem link <i class="glyphicon glyphicon-download-alt"></i></a>', $str);
            }
            return $str;
        } else {
            return $str;
        }
    }

    public static function convert_money($money)
    {
        $convert_money = str_replace('.', '', $money);
        $convert_money = str_replace(' VNĐ', '', $convert_money);
        return $convert_money;
    }

    public static function number_order($current_page, $per_page, $key, $suffix = ".")
    {
        return ($per_page * ($current_page - 1) + $key + 1) . $suffix;
    }

    public static function convertTransFields($field, $value = 0)
    {
        if ($value != 0) return __('messages.transactions_' . $field . '_' . $value);
        else return '';
//            $array = [0 => __('messages.selected')];
//            foreach ([1, 2, 3, 4, 5] as $i) {
//                array_push($array, __('messages.transactions_' . $field . '_' . $i));
//            }
//            return $array;
//        }
    }

    public static function facebook_time_ago($timestamp)
    {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes      = round($seconds / 60 );           // value 60 is seconds
        $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks          = round($seconds / 604800);          // 7*24*60*60;
        $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if($seconds <= 60)
        {
            return "vừa xong";
        }
        else if($minutes <=60)
        {
            if($minutes==1)
            {
                return "một phút trước";
            }
            else
            {
                return "$minutes phút trước";
            }
        }
        else if($hours <=24)
        {
            if($hours==1)
            {
                return "một giờ trước";
            }
            else
            {
                return "$hours giờ trước";
            }
        }
        else if($days <= 7)
        {
            if($days==1)
            {
                return "hôm qua";
            }
            else
            {
                return "$days ngày trước";
            }
        }
        else if($weeks <= 4.3) //4.3 == 52/12
        {
            if($weeks==1)
            {
                return "một tuần trước";
            }
            else
            {
                return "$weeks tuần trước";
            }
        }
        else if($months <=12)
        {
            if($months==1)
            {
                return "một tháng trước";
            }
            else
            {
                return "$months tháng trước";
            }
        }
        else
        {
            if($years==1)
            {
                return "một năm trước";
            }
            else
            {
                return "$years năm trước";
            }
        }
    }
}