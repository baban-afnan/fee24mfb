<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class DashboardController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('dashboard', compact('wallets'));
    }
}
