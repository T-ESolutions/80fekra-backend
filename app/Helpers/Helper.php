<?php

use App\Models\Store;
use App\Models\User;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Kreait\Firebase\Factory;

//use Kreait\Firebase\Factory;

// Status Codes
function success()
{
    return 200;
}

function register()
{
    return 201;
}
function validation()
{
    return 400;
}


function error()
{
    return 401;
}

function code_sent()
{
    return 402;
}

function token_expired()
{
    return 403;
}

function not_found()
{
    return 404;
}

function complete_register()
{
    return 405;
}

function not_accepted()
{
    return 406;
}

function nearest_radius()
{
    return 100; // 100km
}

function limousine_first_radius()
{
    return 3; // 3km
}


function google_api_key()
{
    return "AIzaSyAGlTpZIZ49RVV5VX8KhzafRqjzaTRbnn0";
}

function providerOrderCommision($order,$price,$percent = 10){
    $total = ( $price * $percent ) / 100;
    if($wallet = Auth::guard('provider')->user()->wallet > $total){
        $discount = $wallet - $total;
        WalletTransaction::create([
            'price'=>$total,
            'type'=>'outcome',
            'provider_id'=>Auth::guard('provider')->id(),
            'default_wallet'=>$wallet,
            'description_ar'=>' عملية  خصم خاصة بالطلب رقم   ' . $order->id,
            'description_enr'=>' Discount Transaction for order No   ' . $order->id,
            'order_id'=> $order->id,
        ]);
        Auth::guard('provider')->user()->update(['wallet'=>$discount]);
        return $price;
    }else{
      return $price  - $total;
    }
}
function otp_code()
{
    $code = mt_rand(1000, 9999);
//    $code = 1111;
    return $code;
}

function sendToUser($tokens, $title, $msg, $notification_type, $order_id, $order_type)
{
    send($tokens, $title, $msg, $notification_type, $order_id, $order_type);
}

function sendToProvider($tokens, $title, $msg, $notification_type, $order_id, $order_type)
{
    send($tokens, $title, $msg, $notification_type, $order_id, $order_type);
}

function send($tokens, $title, $msg, $notification_type, $order_id, $order_type)
{
    $api_key = getServerKey();
    $fields = array
    (
        "registration_ids" => $tokens,
        "priority" => 10,
        'data' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'notification_type' => $notification_type,
            'order_id' => $order_id,
            'order_type' => $order_type,
        ],
        'notification' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'notification_type' => $notification_type,
            'order_id' => $order_id,
            'order_type' => $order_type,
        ],
        'vibrate' => 1,
        'sound' => 1
    );
    $headers = array
    (
        'accept: application/json',
        'Content-Type: application/json',
        'Authorization: key=' . $api_key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    //  var_dump($result);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);

    return $result;
}

function getServerKey()
{
    return 'AAAAvvylVpU:APA91bGulpdbImjWuKtrPgw3QhPoggyh7NIlVHqBCNawyoamqfYjACa7ODfQB3y1GK2dRWQvBULr9bbVdz53SwEPoLEwKfX74VvZitqCkFjE7EWMXBXjXScn_283haDJPBO8Ho5KOhoi';
}

function callback_data($status, $key, $data = null, $token = "")
{
    $language = request()->header('lang');
    $response = [
        'status' => $status,
        'msg' => isset($language) && Config::has('response.' . $key) ? Config::get('response.' . $key . '.' . request()->header('lang')) : $key,
        'data' => $data,
    ];
    $token ? $response['token'] = $token : '';
    return response()->json($response);
}

function rateValue($amount, $rate)
{
    return round(($amount * $rate / 100), 2);
}


function getStartOfDate($date)
{
    return date('Y-d-m', strtotime($date)) . ' 00:00';
}

function getEndOfDate($date)
{
    return date('Y-d-m', strtotime($date)) . ' 23:59';
}

function getTimeSlot($interval, $start_time, $end_time)
{
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $startTime = $start->format('H:i');
    $endTime = $end->format('H:i');
    $i=0;
    $time = [];
    while(strtotime($startTime) <= strtotime($endTime)){
        $start = $startTime;
        $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
        $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
        $i++;
        if(strtotime($startTime) <= strtotime($endTime)){
            $time[$i]['slot_start_time'] = $start;
            $time[$i]['slot_end_time'] = $end;
        }
    }
    return $time;
}


if (!function_exists('ArabicDate')) {
    function ArabicDate()
    {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $your_date = date('y-m-d'); // The Current Date
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) {
                $ar_month = $ar;
            }
        }

        $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
        $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
        $current_date = $ar_day . ' - ' . date('d') . ' ' . $ar_month . ' ' . date('Y');
        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

        return $arabic_date;
    }
}


function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function upload($file, $dir)
{
    $image = time() . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads' . '/' . $dir), $image);
    return $image;
}

function unlinkFile($image, $path)
{
    if ($image != null) {
        if (!strpos($image, 'https')) {
            if (file_exists(storage_path("app/public/$path/") . $image)) {
                unlink(storage_path("app/public/$path/") . $image);
            }
        }
    }
    return true;
}


function unlinkImage($image)
{
    if ($image != null) {
        if (!strpos($image, 'https')) {
            if (file_exists($image)) {
                unlink($image);
            }
        }
    }
    return true;
}

// Firebase Connect

function firebase_connect()
{
    $firebase = (new Factory)
        ->withServiceAccount(app_path('goapp-90825-firebase-adminsdk-cp0vq-17f2269a1a.json'))
        ->withDatabaseUri('https://goapp-90825-default-rtdb.firebaseio.com/')
        ->createDatabase();
    return $firebase;
}

function driverChangeOrderStatus($status, $order_type)
{
    if ($order_type == 'Magic') {
        return [
            'AcceptedDelivery' => 'GoToStore',
            'GoToStore' => 'ArriveToStore', // 3
            'ArriveToStore' => 'SendPriceList', // 4
            'AcceptedList' => 'OnWay', // 6
            'OnWay' => 'Arrived',
            'Arrived' => 'Completed',
        ][$status];
    }
    // subscribed
    return [
        'AcceptedDelivery' => 'GoToStore',
        'GoToStore' => 'ArriveToStore', // 3
        'ArriveToStore' => 'OnWay', // 6
        'OnWay' => 'Arrived',
        'Arrived' => 'Completed',
    ][$status];
}

// Admin Helper Functions

if (!function_exists('company_parent')) {
    function company_parent()
    {
        if (Auth::guard('companies')->user()->type == 'Admin') {
            return Auth::guard('companies')->user()->id;
        } else {
            return Auth::guard('companies')->user()->company_id;
        }
    }
}

if (!function_exists('admin_url')) {
    function admin_url($url = null)
    {
        return url('admin/' . $url);
    }
}


if (!function_exists('company_url')) {
    function company_url($url = null)
    {
        return url('company/' . $url);
    }
}
if (!function_exists('admin')) {
    function admin()
    {
        return auth()->guard('admins');
    }
}
if (!function_exists('store')) {
    function store()
    {
        return auth()->guard('stores');
    }
}


