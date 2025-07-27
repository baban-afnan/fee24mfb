<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VirtualAccount;
use App\Repositories\VirtualAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Wallet Index
    public function index(){
        $virtualAccount = VirtualAccount::where('user_id', auth()->user()->id)->first();
        return view('wallet', compact('virtualAccount'));
    }

    public function createWallet(Request $request){   
        $loginUserId = Auth::id(); 
        
        // ✅ Fetch user record
        $user = User::find($loginUserId);

        // ✅ Check if essential KYC details exist
        if (empty($user->bvn) || empty($user->nin) || empty($user->phone_no)) {
            return redirect()->route('wallet')->with([
                'error' => 'Please complete your registration by providing your BVN, NIN, and Phone Number to open a virtual account.'
            ]);
        }

        // ✅ Continue wallet creation if user details are complete
        $repObj2 = new VirtualAccountRepository;
        $result = $repObj2->createVirtualAccount($loginUserId);

        // ✅ Handle failure gracefully
        if (!is_array($result) || !isset($result['success']) || !$result['success']) {
            $message = is_array($result) && isset($result['message'])
                ? $result['message']
                : 'Wallet creation failed. Please try again later.';

            return redirect()->route('wallet')->with(['error' => $message]);
        }

        // ✅ Success
        return redirect()->route('wallet')->with(['success' => $result['message']]);
    }
}
