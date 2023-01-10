<?php

use Carbon\Carbon;
use Jenssegers\Date\Date;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;

if (!function_exists('localFormatDate')) {
    function localFormatDate($value)
    {
        if(is_null($value)) return NULL;
        return Date::parse($value)->format(config('local.date_format'));
    }
}

if (!function_exists('localFormatMonth')) {
    function localFormatMonth($value)
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $index = intval($value) - 1;
        return $months[$index] ?? 'not defined';
    }
}


if (!function_exists('localFormatDateTime')) {    
    function localFormatDateTime($value)
    {
        if(is_null($value)) return NULL;
        return Date::parse($value)->format(config('local.datetime_format'));
    }
}

if (!function_exists('createLocalFormatDate')) {
    function createLocalFormatDate($value)
    {
        return Date::createFromFormat(config('local.date_format'), $value);
    }
}

if (!function_exists('createLocalFormatDateTime')) {
    function createLocalFormatDateTime($value)
    {
        return Date::createFromFormat(config('local.datetime_format'), $value);
    }
}

if (!function_exists('localNumberFormat')) {
    function localNumberFormat($value, $digitDecimal = null)
    {
        if (null === $digitDecimal) {
            $digitDecimal = config('local.digit_decimal');
        }

        return number_format($value, $digitDecimal, config('local.decimal_separator'), config('local.thousand_separator'));
    }
}

if (!function_exists('localNumberAccountingFormat')) {
    function localNumberAccountingFormat($value, $digitDecimal = null)
    {
        if (null === $digitDecimal) {
            $digitDecimal = config('local.digit_decimal');
        }

        if ($value < 0) {
            $result = '( '.number_format($value * -1, $digitDecimal, config('local.decimal_separator'), config('local.thousand_separator')).' )';
        } else {
            $result = number_format($value, $digitDecimal, config('local.decimal_separator'), config('local.thousand_separator'));
        }

        return $result;
    }
}

// ['width:9000','height:7000'] to ['width' => 9000,'height' => 7000]
if (!function_exists('convertStringArray')) {
    function convertStringArray($values, $separator = ':')
    {
        $result = [];
        foreach ($values as $value) {
            list($key, $val) = explode($separator, $value);
            $result[trim($key)] = trim($val);
        }

        return $result;
    }
}
// convert ['width' => 9000,'height' => 7000] to ['width:9000','height:7000' ]
if (!function_exists('convertArrayStringPair')) {
    function convertArrayStringPair($values, $separator = ':')
    {
        $result = [];
        array_walk($values, function ($item, $key) use ($separator, &$result) {
            $result[] = $key.$separator.$item;
        });

        return $result;
    }
}

if (!function_exists('convertArrayPairValue')) {
    function convertArrayPairValue($values, $keyPair = 'text,value')
    {
        $result = [];
        foreach ($values as $value) {
            list($key, $val) = explode(',', $keyPair);
            array_push($result, [$key => $value, $val => $value]);
        }

        return $result;
    }
}

if (!function_exists('convertArrayPairValueWithKey')) {
    function convertArrayPairValueWithKey($values, $keyPair = 'text,value')
    {
        $result = [];
        foreach ($values as $k => $value) {
            list($key, $val) = explode(',', $keyPair);
            array_push($result, [$key => $value, $val => $k]);
        }

        return $result;
    }
}

if (!function_exists('generateMenu')) {
    function generateMenu(array $tree)
    {
        return \Menu::build($tree, function ($menu, $item) {
            if (!$item->children->isEmpty()) {
                $header = Link::to('#', '<i class="nav-icon '.$item->icon.'"></i>
                                        &nbsp;'.$item->name ?? 'header')->addClass('nav-link nav-group-toggle');                
                
                $menu->submenuIfCan($item->permissions->pluck('name'), $header, generateMenu($item->children->all())->addClass('nav-group-items')->addParentClass('nav-group'));
                
                // $menu->submenu($header, generateMenu($item->children->all())->addClass('nav-group-items')->addParentClass('nav-group'));
                
                
            } else {
                // $menu->add(Html::raw('<a class="nav-link" href="'.$item->route.'">
                $menu->addIfCan($item->permissions->pluck('name'), Html::raw('<a class="nav-link" href="'.$item->route.'">
                                        <i class="nav-icon '.$item->icon.'"></i>
                                        &nbsp;'.$item->name.'
                                    </a>')->addParentClass('nav-item'));
            }
        });
    }
}

if (!function_exists('listWorkDay')) {
    function listWorkDay()
    {
        $result = [
            Carbon::SUNDAY => 'Minggu',
            Carbon::MONDAY => 'Senin',
            Carbon::TUESDAY => 'Selasa',
            Carbon::WEDNESDAY => 'Rabu',
            Carbon::THURSDAY => 'Kamis',
            Carbon::FRIDAY => 'Jumat',
            Carbon::SATURDAY => 'Sabtu',
        ];        

        return $result;
    }
}

if (!function_exists('generatePeriodFromString')) {
    function generatePeriodFromString($value, $separator = ' - ')
    {
        $result = ['startDate' => null, 'endDate' => null];
        try {
            $tmp = explode($separator, $value);
            $result['startDate'] = createLocalFormatDate($tmp[0]);
            $result['endDate'] = createLocalFormatDate($tmp[1]);
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $result;
    }
}

if (!function_exists('generatePeriod')) {
    function generatePeriod($value, $separator = '__')
    {
        $result = ['startDate' => null, 'endDate' => null];
        try {
            $tmp = explode($separator, $value);
            $result['startDate'] = $tmp[0];
            $result['endDate'] = $tmp[1];
        } catch (\Throwable $th) {
            \Log::error('function generatePeriod');
            throw $th;
        }
        
        return $result;
    }
}

if (!function_exists('diffMinute')) {
    function diffMinute($start, $end)
    {
        return Carbon::parse($start)->diffInMinutes($end);
    }
}

if (!function_exists('minuteToHour')) {
    function minuteToHour($minutes)
    {
        return $minutes / 60;
    }
}


if (!function_exists('isWorkshiftOff')) {
    function isWorkshiftOff($workshift)
    {
        if(is_array($workshift)){
            return $workshift['check_in_schedule'] == $workshift['check_out_schedule'];
        }
        return $workshift->getRawOriginal('check_in_schedule') == $workshift->getRawOriginal('check_out_schedule');
    }
}

if (!function_exists('getDateString')) {
    function getDateString($date)
    {
        return explode(' ',$date)[0];
    }
}

