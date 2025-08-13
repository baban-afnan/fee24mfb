<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
   public function bvnServices()
{
    return view('bvn-services');
}

  public function vipServices()
{
    $user = auth()->user();

    if ($user->role === 'agent') {
        // Agents can access VIP services
        return view('vip-services');
    }

    if ($user->role === 'user') {
        // Redirect users to the migration page
        return view('user-migration');
    }

    // Optional: Handle other roles or unauthorized access
    abort(403, 'Unauthorized access.');
}


   public function ninServices()
{
    return view('nin-services');
}


   public function migrationServices()
{
    return view('migration-services');
}


 public function verificationServices()
    {
        return view('verification-services');
    }
}
