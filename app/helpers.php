<?php


use App\Models\Cart;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttrVariation;
use App\Models\ProductOption;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function generateFileName($name)
{
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    $day = Carbon::now()->day;
    $hour = Carbon::now()->hour;
    $minute = Carbon::now()->minute;
    $second = Carbon::now()->second;
    $microsecond = Carbon::now()->microsecond;
    return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
}

function convertShamsiToGregorianDate($date)
{
    if ($date == null) {
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);

    $arrayGergorianDate = verta()->getGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);

    return implode("-", $arrayGergorianDate) . " " . $shamsiDateSplit[3];
}

function province_name($provinceId)
{
    return Province::findOrFail($provinceId)->name;
}

function city_name($cityId)
{
    return City::findOrFail($cityId)->name;
}

function dayOfWeek($day)
{
    switch ($day) {
        case '0';
            $dayName = 'شنبه';
            break;
        case '1';
            $dayName = 'یکشنبه';
            break;
        case '2';
            $dayName = 'دوشنبه';
            break;
        case '3';
            $dayName = 'سه شنبه';
            break;
        case '4';
            $dayName = 'چهارشنبه';
            break;
        case '5';
            $dayName = 'پنجشنبه';
            break;
        case '6';
            $dayName = 'جمعه';
            break;
    }
    return $dayName;

}

function convert($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);

    return $convertedPersianNums;
}

function imageExist($env, $image)
{
    $path = public_path($env . $image);
    if (file_exists($path) and !is_dir($path)) {
        $src = url($env . $image);
    } else {
        $src = url('no_image.png');
    }
    return $src;
}
//save file to public
function UploadFile($file,$env){
    try {
        DB::beginTransaction();
        $fileNameImage = generateFileName($file->getClientOriginalName());
        $file->move(public_path($env), $fileNameImage);
        DB::commit();
        return [
            'status'=>200,
            'message'=>$fileNameImage
        ];
    }catch (\Exception $exception){
        DB::rollBack();
        return [
            'status'=>200,
            'message'=>$exception->getMessage()
        ];
    }
}
//save file to storage
function saveFile($file,$env)
{
    if (is_file($file)) {
        $file_name = time() . "." . $file->getClientOriginalExtension();
        $file->storeAs(env($env),$file_name);
        return $file_name;
    };
    return 'File Not Found';
}

function unlink_image_helper_function($path)
{
    Storage::delete($path);
}
