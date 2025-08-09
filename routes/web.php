<?php

use App\Http\Controllers\ManualSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NinServiceController;
use App\Http\Controllers\CRMController;
use App\Http\Controllers\NinModificationController;
use App\Http\Controllers\NinValidationController;
use App\Http\Controllers\SendVninController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BvnUserController;
use App\Http\Controllers\BvnModificationController;
use App\Http\Controllers\PhoneSearchController;
use App\Http\Controllers\NinipeController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\NINverificationController;




   Route::get('/', function () { return view('welcome');
     });

    Route::post('/palmpay/webhook', [PaymentWebhookController::class, 'handleWebhook']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


    // Authenticated Routes
    Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wallet Route
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');

    Route::post('/virtual/account/create', [WalletController::class, 'createWallet'])->name('virtual.account.create');

    // BVN Services Route (only controller, remove duplicated closure route)
    Route::get('/bvn-services', [ServiceController::class, 'bvnServices'])->name('bvn.services');

    // NIN Verification Route (only controller, remove duplicated closure route)
    Route::get('/verification-services', [VerificationController::class, 'verificationServices']) ->name('verification.services');


      // NIN Services Route (only controller, remove duplicated closure route)
    Route::get('/nin-services', [NinServiceController::class, 'ninServices'])->name('nin.services');

    // CRM Routes
    Route::get('/bvn-crm', [CRMController::class, 'index'])->name('bvn-crm');
    Route::post('/bvn-crm', [CRMController::class, 'store'])->name('crm.store');

    // NIN Modification Routes
    Route::get('/nin-modification/{id}/details', [NinModificationController::class, 'showDetails'])->name('nin-modification.details');
    Route::get('/nin-modification/price', [NinModificationController::class, 'getFieldPrice'])
    ->name('nin-modification.price')    ->middleware('auth');
    Route::get('/nin-modification', [NinModificationController::class, 'index'])->name('nin-modification');
    Route::post('/nin-modification', [NinModificationController::class, 'store'])->name('nin-modification.store');



     // NIN Validation Routes
    Route::get('/validation/{id}/details', [NinValidationController::class, 'showDetails'])->name('Validation.details');
    Route::get('/validation/price', [NinValidationController::class, 'getFieldPrice'])
    ->name('validation.price')    ->middleware('auth');
    Route::get('/validation', [NinValidationController::class, 'index'])->name('validation');
    Route::post('/validation', [NinValidationController::class, 'store'])->name('validation.store');


    // NIN ipe Routes
    Route::get('/ipe/{id}/details', [NinipeController::class, 'showDetails'])->name('ipe.details');
    Route::get('/ipe/price', [NinipeController::class, 'getFieldPrice'])->name('ipe.price')    ->middleware('auth');
    Route::get('/ipe', [NinipeController::class, 'index'])->name('ipe');
    Route::post('/ipe', [NinipeController::class, 'store'])->name('ipe.store');


    // ✅ SEND VNIN RESOURCE ROUTE (with named routes)
    Route::resource('send-vnin', SendVninController::class)
        ->only(['index', 'create', 'store'])
        ->names([
            'index' => 'send-vnin.index',
            'create' => 'send-vnin.create',
            'store' => 'send-vnin.store',
        ]);


      Route::middleware('auth')->group(function () {
      Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
     });


});

     Route::middleware(['auth'])->group(function () {
     Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
     Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // PDF Export with optional date range
    Route::get('/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/bvn', [BvnUserController::class, 'index'])->name('bvn.index');
    Route::post('/bvn', [BvnUserController::class, 'store'])->name('bvn.store');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/modification-fields/{service_id}', [App\Http\Controllers\BvnModificationController::class, 'getModificationFields']);
    Route::get('/modification', [BvnModificationController::class, 'index'])->name('modification');
    Route::post('/modification', [BvnModificationController::class, 'store'])->name('modification.store');
});




    Route::middleware(['auth'])->group(function () {
    Route::get('/phone-search', [PhoneSearchController::class, 'index'])->name('phone.search.index');
    Route::post('/phone-search', [PhoneSearchController::class, 'store'])->name('phone.search.store');
    Route::post('/phone-search/{id}/status', [PhoneSearchController::class, 'updateStatus'])->name('phone.search.status');
    Route::post('/manual-search', [ManualSearchController::class, 'store'])->name('manual-search.store');

  });


   Route::middleware(['auth'])->group(function () {
    Route::get('/nin-verification', [NINverificationController::class, 'index'])->name('nin.verification.index');
    Route::post('/nin-verification', [NINverificationController::class, 'store'])->name('nin.verification.store');
    Route::post('/nin-verification/{id}/status', [NINverificationController::class, 'updateStatus'])->name('nin.verification.status');

  });


   //Whatsapp API Support Routes--------------------------------------------------------------------------
    Route::get('/support', function () {
        $phoneNumber = env('phoneNumber');
        $message = urlencode(env('message'));
        $url = env('API_URL') . "{$phoneNumber}&text={$message}";
        return redirect($url);
    })->name('support');
    //End Whatsapp API Support Routes ------------------------------------------------------------------------------------------






require __DIR__.'/auth.php';
