<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function index($locale)
    {
//        if(!$locale->ajax()) return false;
//        return $locale->all();
//        return $locale;
        App::setLocale($locale);
        return $locale;
    }
}
