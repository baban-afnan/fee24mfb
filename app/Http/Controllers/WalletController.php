<?php

namespace App\Http\Controllers;

use App\Models\VirtualAccount;
use App\Repositories\VirtualAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    //Wallet Index
    public function index(){
       $virtualAccount = VirtualAccount::where('user_id', auth()->user()->id)->first();
          
       return view('wallet', compact('virtualAccount'));
    }

    public function createWallet(Request $request){   

        $loginUserId = Auth::id(); 
       
        $repObj2 = new VirtualAccountRepository;
       $result =  $repObj2->createVirtualAccount($loginUserId );

        if (!$result['success']) {
           return redirect()->route('wallet')->with(['error' => $result['message']], 500);
        }

       return redirect()->route('wallet')->with(['success' => $result['message']], 200);

    }

}
