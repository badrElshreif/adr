<?php

use App\Infrastructure\Exceptions\NotFoundException;
use App\Infrastructure\Helpers\CurrencyCached;
use App\Property\Domain\Models\PropertyType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (! function_exists('handleDateFormat'))
{
    function price_convert($price, $from = null, $to = null)
    {
        return app(CurrencyCached::class)->convert($price, $to ?? config('app.currency'), $from ?? config('app.currency'));
    }

}

if (! function_exists('handleDateFormat'))
{
    function handleDateFormat($date)
    {
        return Carbon::parse($date)->translatedFormat('d M Y');
    }

}

function sequanceArray(array $start, array $end)
{
    $res = false;
    sort($start);
    sort($end);

    foreach ($end as $key => $value)
    {

//           if((int)($value)==$value){$inc=1;}else{$inc=.1;}
        if (isset($start[$key + 1]))
        {
            if ($value != $start[$key + 1])
            {
                $res = true;
            }

        }

    }

    return $res;
}

if (! function_exists('qrCode'))
{
    function qrCode()
    {
        $uniqueString = time() . '_' . Str::random(4);

// https://www.simplesoftware.io/#/docs/simple-qrcode
        if (\Illuminate\Support\Facades\Storage::disk('public')->missing('barcodes'))
        {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('barcodes');
        }

        QrCode::format('svg')->size(200)->generate($uniqueString,
            storage_path("app/public/barcodes/$uniqueString" . '.svg'));

        return $uniqueString . '.svg';
    }

}

if (! function_exists('findModel'))
{
    function findModel($id, $model, $relations = [], $selects = '*')
    {
        try {
            //** eager loading of relations in one query */
            return $model->whereId($id)->with($relations)
                ->select($selects)->firstOrFail();

        }
        catch (ModelNotFoundException $e)
        {

            throw new NotFoundException();
        }

    }

}

function setting($key = null, $country_id = null)
{

    if ($country_id != null && Country::where('id', $country_id)->whereDoesntHave('settings')->count() > 0)
    {
        $country_id = null;
    }

    if (is_null($key))
    {
        return optional(\App\AppContent\Domain\Models\Setting::getAllSettingsCached()->where('key', 'added_tax')->where('country_id', $country_id)->first())->body ?? null;
    }

    return optional(\App\AppContent\Domain\Models\Setting::getAllSettingsCached()->where('key', $key)->where('country_id', $country_id)->first())->body ?? null;
}

function price_including_tax($unit, $price)
{
    $tax = optional(optional($unit->product)->store)->tax ?? 0;

    if ($tax == 0)
    {
        $tax = optional($unit->store)->tax ?? 0;
    }

    return $price + ($price * $tax / 100);
}

function needAdminDelivery($order)
{
    $needAdminDelivery  = false;
    $city_id            = $order->order_type == 'inner' ? $order?->store?->city?->id : ($order->order_type == 'outer' ? $order->store_city_id : $order?->scheduleds()?->first()?->store_city_id);
    $city               = City::find($city_id);
    $country_id         = $city?->country_id ?? null;
    $delivery_wait_time = setting('delivery_order_wait_time', $country_id);

    if ($order->delivery_id == null && Carbon::parse($order->delivery_date_to)->addMinutes($delivery_wait_time) >= now() && in_array($order->status->key, ['new', 'delayed', 'accepted', 'ready_for_delivery']))
    {
        $needAdminDelivery = true;
    }

    return $needAdminDelivery;
}

function status($type, $key)
{
    return optional(\App\Order\Domain\Models\Status::getAllStatusCached()->where('type', $type)->where('key', $key)->first())->id ?? null;
}

function send_fcm_notification($user, $notification_data, $is_admin = false, $tokens = [], $array = null)
{
    $firebaseTokens = [];

    if ($is_admin)
    {

        if (! empty($tokens) && $array == null)
        {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::whereIn('id', $tokens)->pluck('device_token')->all();
        }
        elseif (! empty($tokens) && $array)
        {
            $firebaseTokens = $tokens;
        }
        else
        {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\Admin\Domain\Models\Admin')->pluck('device_token')->all();
        }

    }
    else
    {

        if ($user && $array == null)
        {
            $firebaseTokens = $user->tokens->pluck('device_token')->all();
        }
        elseif ($user && $array)
        {
            $firebaseTokens = $user;
        }
        else
        {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\User\Domain\Models\User')->pluck('device_token')->all();
        }

    }

//    dd($firebaseTokens);

// var_dump($firebaseTokens);

// echo "<br>";

//dd($firebaseTokens);

// $notification_data = [

//     "title" => $title,

//     "body" => $body,

//     "type" => $type,

//     "id" : "' . $id . '",

//     "message" : "' . $message . '",

//     "icon" : "new",

//     "sound" : "default"
    // ];
    $notif_arr            = [];
    $data_arr             = [];
    $notif_arr['content'] = [
        'model_id'   => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound'      => 'default',
        'timestamp'  => date('Y-m-d G:i:s'),
        'data'       => $notification_data,
        'title'      => $notification_data['title'],
        'body'       => $notification_data['body'],
        'type'       => $notification_data['type'] ?? null
    ];
    $notif_arr['notification'] = [
        'model_id'   => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound'      => 'default',
        'timestamp'  => date('Y-m-d G:i:s'),
        'data'       => $notification_data,
        'title'      => $notification_data['title'],
        'body'       => $notification_data['body'],
        'type'       => $notification_data['type'] ?? null
    ];

    $data_arr['content'] = [
        'model_id'   => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound'      => 'default',
        'timestamp'  => date('Y-m-d G:i:s'),
        'data'       => $notification_data,
        'title'      => $notification_data['title'],
        'body'       => $notification_data['body'],
        'type'       => $notification_data['type'] ?? null
    ];
    $data_arr['notification'] = [
        'model_id'   => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound'      => 'default',
        'timestamp'  => date('Y-m-d G:i:s'),
        'data'       => $notification_data,
        'title'      => $notification_data['title'],
        'body'       => $notification_data['body'],
        'type'       => $notification_data['type'] ?? null
    ];

// $data = [

//     "registration_ids" => $firebaseTokens,

//     "notification" => array_merge(\Illuminate\Support\Arr::only($notification_data, ['title', 'body']), ['channelKey' => 'basic_channel']),

//     "data" => \Illuminate\Support\Arr::only($notification_data, ['model_id', 'type'])
    // ];

    $notification_data_fcm = array_merge($notification_data, ['channelKey' => 'basic_channel', 'sound' => 'default', 'timestamp' => date('Y-m-d G:i:s')]);

    $data = [
        'registration_ids' => $firebaseTokens,

//        "mutable_content" => true,

//        "content_available" => true,
        //        "priority" => "high",
        'data'             => $notification_data_fcm,
        //"data" => array('content' => $data_arr),
        'notification'     => $notification_data
    ];

    $dataString = json_encode($data);
    //dd(config('app.FCM_KEY'));
    $headers = [
        'Authorization: key=' . config('app.fcm_server_key'),
        'Content-Type: application/json'
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
//    dd($response);
    curl_close($ch);

    if ($response === false)
    {

// throw new Exception('Curl error: ' . curl_error($crl));
        //print_r('Curl error: ' . curl_error($crl));
        $result = 0;
    }
    else
    {
        $result = 1;
    }

    return $result;
}

//HI SMS
function send_hisms_sms($mobile, $msg)
{
    $sender_mobile = setting('hisms_phone');
    $sender_name   = str_replace(' ', '%20', setting('site_name'));
    $password      = setting('hisms_password');
    $numbers       = $mobile;
    $msg           = str_replace(' ', '%20', $msg);
    $date          = date('Y-m-d');
    $time          = date('H:i');
    $url           = 'http://hisms.ws/api.php?send_sms&username=' . $sender_mobile . '&password=' . $password . '&numbers=' . $numbers . '&sender=' . $sender_name . '&message=' . $msg . '&date=' . $date . '&time=' . $time;
    $msg           = [];
    $response      = (int) file_get_contents($url);
    $result        = validate_response($response);

    return $msg = ['response' => $response, 'result' => $result];
}

function validate_response($response)
{
    $result = '';

    switch ($response)
    {
        case 1:
            $result = 'اسم المستخدم غير صحيح';
            break;
        case 2:
            $result = 'كلمة المرور غير صحيحة';
            break;
        case 3:
            $result = 'تم الارسال';
            break;
        case 4:
            $result = 'لايوجد ارقام';
            break;
        case 5:
            $result = 'لايوجد رسالة';
            break;
        case 6:
            $result = 'خطاء في السندر';
            break;
        case 7:
            $result = 'سندر غير مفعل';
            break;
        case 8:
            $result = 'الرسالة تحتوى على كلمة ممنوعة';
            break;
        case 9:
            $result = 'لايوجد رصيد';
            break;
        case 10:
            $result = 'صيغة التاريخ غير صحيحة';
            break;
        case 11:
            $result = 'صيغة الوقت غير صحيحة';
            break;
        case 404:
            $result = 'لم يتم ادخال جميع البرمترات المطلوبة';
            break;
        case 403:
            $result = 'تم تجاوز عدد المحاولات المسموحة';
            break;
        case 504:
            $result = 'الحساب معطل';
            break;
    }

    return $result;
}

function sendSMS($phone, $message)
{

    $number = $phone;
    $sender = env('sms_username');
//    $sender='ARAS for AC';
    $url = 'https://www.hisms.ws/api.php?send_sms&username=' . env('sms_user') .
    '&password=' . env('sms_password') . '&numbers=' . $number . '&sender=' . $sender . '&message=' . urlencode($message);

//    dd($url);

//    $options = array(

//        CURLOPT_RETURNTRANSFER => true,     // return web page

//        CURLOPT_HEADER => false,    // don't return headers

//        CURLOPT_FOLLOWLOCATION => true,     // follow redirects

//        CURLOPT_ENCODING => "",       // handle all encodings

//        CURLOPT_USERAGENT => "spider", // who am i

//        CURLOPT_AUTOREFERER => true,     // set referer on redirect

//        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect

//        CURLOPT_TIMEOUT => 120,      // timeout on response

//        CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects

//        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks

//    );

//    $ch = curl_init($url);

//    curl_setopt_array($ch, $options);

//    $content = curl_exec($ch);

//    $err = curl_errno($ch);

//    $errmsg = curl_error($ch);

//    $header = curl_getinfo($ch);
//    curl_close($ch);
    $content = (int) file_get_contents($url);
    $result  = validate_response($content);
    $msg     = ['response' => $content, 'result' => $result];
//    \Illuminate\Support\Facades\Log::info('sms',$msg);
    return $msg;

}

function send_msegat_sms($mobile_number, $msg)
{
    $data = [
        'userName'    => 'googan',
        'password'    => 'dcfa',
        'userSender'  => 'pin-code',
        'numbers'     => $mobile_number,
        'apiKey'      => '7fe0f68d4a193a3a802870f71c98e72a',
        'msg'         => $msg,
        'msgEncoding' => 'UTF8'
    ];
    $client = new \GuzzleHttp\Client();
    $res    = $client->request('POST', 'https://www.msegat.com/gw/sendsms.php', [
        'headers' => [
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json',
            'Accept-Language' => app()->getLocale() == 'ar' ? 'ar-Sa' : 'en-Uk'
        ],
        'body'    => json_encode($data)
    ]);

    if ($res)
    {
        $data = json_decode($res->getBody()->getContents());

        if ($data->code)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    else
    {
        return false;
    }

}

if (! function_exists('checkAuthAdmin'))
{
    function checkAuthAdmin($role = 'Normal User')
    {

        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->is($role))
        {
            return true;
        }
        else
        {
            return false;
        }

    }

}

if (! function_exists('call_location_map_event'))
{
    function call_location_map_event($order = null, $city_id = null)
    {

        if ($order == null)
        {
            $city = City::find($city_id ?? 102874);
            event(new \App\Location\Domain\Events\LocationEvent($city, ['delivery'])); // fire event to update location on /map page
            return;
        }

        $city_id    = $order->store ? $order->store->city_id : $order->store_city_id;
        $city       = City::find($city_id ?? 102874);
        $event_type = $order->company_id ? 'store' : 'order';
        $delivery   = $order->delivery_id ? 'delivery' : null;
        event(new \App\Location\Domain\Events\LocationEvent($city, [$event_type, $delivery])); // fire event to update location on /map page
    }

}

if (! function_exists('settings_country'))
{
    function settings_country($country_id = null)
    {
        $text_prop            = PropertyType::where('key', 'text')->first();
        $no_prop              = PropertyType::where('key', 'number')->first();
        $decimal_prop         = PropertyType::where('key', 'decimal')->first();
        $radio_prop           = PropertyType::where('key', 'radio')->first();
        $multible_select_prop = PropertyType::where('key', 'multible_select')->first();
        $select_prop          = PropertyType::where('key', 'select')->first();
        $image_prop           = PropertyType::where('key', 'image')->first();
        return [
            [
                'ar'               => ['name' => 'العدد الاقصى لوصول الطلبات الى المندوبين في حالة وجود طلبات نشطة', 'hint' => "The maximum number of orders that can be delivered to delivery guys if there are active orders"],
                'en'               => ['name' => 'The maximum number of orders that can be delivered to delivery guys if there are active orders', 'hint' => 'العدد الاقصى لوصول الطلبات الى المندوبين في حالة وجود طلبات نشطة'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'max_orders_to_delivery',
                'body'             => 1,
                'is_active'        => 1,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'مستحقات التطبيق من التوصيل تكون (قيمة او نسبة)', 'hint' => "It's a value for every order delivery"],
                'en'               => ['name' => 'Application Dues delivery fees (value or percentage)', 'hint' => 'هي قيمة او نسبة على كل توصيل'],
                'target'           => 'superAdmin',
                'property_type_id' => $radio_prop->id,
                'key'              => 'application_delivery_due_type',
                'body'             => 1,
                'is_active'        => 1,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'مستحقات التطبيق من التوصيل', 'hint' => "It's a value for every order delivery"],
                'en'               => ['name' => 'Application Dues value from delivery sales', 'hint' => 'هي قيمة او نسبة على كل توصيل'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'application_delivery_dues',
                'body'             => '5',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'النسبة الاضافية لطلبات المتاجر الاخرى', 'hint' => "It's a percentage for every other store order"],
                'en'               => ['name' => 'Additional price percentage for every other store order', 'hint' => 'النسبة الاضافية لطلبات المتاجر الاخرى'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'additional_price_due_percentage',
                'body'             => 1,
                'is_active'        => 1,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'الحد الادنى لمحفظة المندوب لاستمرار استلام الطلبات', 'hint' => 'Minimum wallet amount for delivery guy to continue receiving orders'],
                'en'               => ['name' => 'Minimum wallet amount for delivery guy to continue receiving orders', 'hint' => 'الحد الادنى لمحفظة المندوب لاستمرار استلام الطلبات'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'delivery_minimum_wallet',
                'body'             => 35,
                'is_active'        => 1
            ],
            [
                'ar'               => ['name' => 'الحد الاقصى لمحفظة المندوب لاستمرار استلام الطلبات', 'hint' => 'Maximum wallet amount for delivery guy to continue receiving orders'],
                'en'               => ['name' => 'Maximum wallet amount for delivery guy to continue receiving orders', 'hint' => 'الحد الاقصى لمحفظة المندوب لاستمرار استلام الطلبات'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'delivery_maximum_wallet',
                'body'             => 750,
                'is_active'        => 1
            ],
            [
                'ar'               => ['name' => 'نسبة مستحقات التطبيق من المبيعات', 'hint' => "It's a percentage for every order"],
                'en'               => ['name' => 'Application Dues percentage from sales', 'hint' => 'هي نسبة مئوية على كل طلب'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'application_dues',
                'body'             => '5',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'أقصي فترة لانتظار الطلب لدي المندوب قبل القبول أو الرفض بالدقيقة', 'hint' => 'في حالة عدم استجابة المندوب للطلب في خلال هذه الفترة الزمنية يتم إرسال إشعار بالطلب لمديري النظام'],
                'en'               => ['name' => 'max time order will wait with delivery before accept or reject it with minutes', 'hint' => 'If delivery not respond on order in this period the order will go for another one and removed from this delivery guy'],
                'target'           => 'superAdmin',
                'property_type_id' => $no_prop->id,
                'key'              => 'delivery_order_wait_time',
                'body'             => '5',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'الوقت الاقصى قبل تحول الطلب لمتاخر', 'hint' => "الوقت الاقصى قبل تحول الطلب لمتاخر"],
                'en'               => ['name' => 'The maximum time before the order becomes delayed', 'hint' => 'The maximum time before the order becomes delayed'],
                'target'           => 'superAdmin',
                'property_type_id' => $no_prop->id,
                'key'              => 'max_time_before_delayed',
                'body'             => '30',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'يتم حظر المندوب في حالة تجاوز عدم السداد لمبلغ', 'hint' => 'يتم تحديد أقصى مبلغ يمكن للمندوب عدم دفعه. وفي حالة وصول المندوب لهذا المبلغ يتم حظره تلقائيا ويستطيع مدير التطبيق تفعيله من لوحة التحكم وذلك بعد تحويل المندوب للمبلغ وتأكيده من قبل مدير النظام'],
                'en'               => ['name' => 'money amount delivery will block if he not paid ', 'hint' => 'Maximum amount of money Delivery Guy can not paid and if he reach to this amount he will blocked  '],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'max_money_before_block',
                'body'             => '10',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'مسافة كيلومترات ليصل الطلب للمندوب', 'hint' => 'اشعارات الطلبات تصل للمندوب كحد اقصي لمسافه الطلب'],
                'en'               => ['name' => 'Delivery Guy distance to get order', 'hint' => 'Delivery Guy distance to receive a notification for a new orders '],
                'target'           => 'superAdmin',
                'property_type_id' => $no_prop->id,
                'key'              => 'order_request_radius',
                'body'             => '10',
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'الحد الأقصى لتسليم الطلبات فوق الوقت المتوقع', 'hint' => 'الوقت الذي يفوق وقت التسليم ولا يعتبر تأخير'],
                'en'               => ['name' => 'Max time to deliver the order addition to order delivery time', 'hint' => 'The time that pass to deliver the order and not consider late'],
                'target'           => 'superAdmin',
                'property_type_id' => $no_prop->id,
                'key'              => 'max_time_order_delivery',
                'body'             => '10',
                'is_active'        => 0,
                'country_id'       => $country_id
            ],

            [
                'ar'               => ['name' => 'عدد مرات الغاءالطلب قبل الحظر', 'hint' => 'اقصي عدد مرات يتم الغاء الطلب من العميل قبل حظره'],
                'en'               => ['name' => 'number of cancellation order before block', 'hint' => 'Maximum number of canceled order for client before block him'],
                'target'           => 'superAdmin',
                'property_type_id' => $no_prop->id,
                'key'              => 'cancellation_order_for_block',
                'body'             => '10',
                'country_id'       => $country_id
            ],

            [
                'ar'               => ['name' => 'قيمة الضريبة المضافة'],
                'en'               => ['name' => 'Added tax value'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'added_tax',
                'body'             => '5',
                'is_active'        => 1,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'أقل سعر للطلب'],
                'en'               => ['name' => 'the minimum amount for order'],
                'property_type_id' => $decimal_prop->id,
                'key'              => 'order_min_cost',
                'target'           => 'superAdmin',
                'body'             => '10',
                'is_active'        => 1,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'عدد الأيام المسموح بها للإسترجاع'],
                'en'               => ['name' => 'the allowed numer of days for refund'],
                'property_type_id' => $no_prop->id,
                'key'              => 'refund_period',
                'target'           => 'superAdmin',
                'body'             => '14',
                'is_active'        => 0,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'تكلفة التوصيل والتركيب'],
                'en'               => ['name' => 'Delivery and installation cost'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'delivery_charge',
                'body'             => '0',
                'is_active'        => 0,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'قيمة الضريبة المضافة على سعر الطلب'],
                'en'               => ['name' => 'order Added tax value'],
                'target'           => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'              => 'order_added_tax',
                'body'             => '5',
                'is_active'        => 0,
                'country_id'       => $country_id
            ],
            [
                'ar'               => ['name' => 'إمكانية التقييم والتعليق على المنتجات'],
                'en'               => ['name' => 'the ability of evaluating and commenting on products'],
                'target'           => 'superAdmin',
                'property_type_id' => $radio_prop->id,
                'key'              => 'can_rate',
                'body'             => false,
                'is_active'        => 0,
                'country_id'       => $country_id
            ]
        ];
    }

}
