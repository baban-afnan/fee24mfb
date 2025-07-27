<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NinServiceController extends Controller
{
   public function ninServices()
{
    return view('nin-services');
}
}
