<?php

use App\Http\Controllers\admin\{AuthController, CategoryController,PatientController, ConfigSettingController, DashboardController, HelpDeskController, TransactionController, UserController,BannerController,CardController, ManageFAQController, QuestionController,QuestionnaireManagementController,ContentPageController, NotificationController, OrderController, PlanManagementController, ScratchedCardController};
use App\Http\Controllers\admin\PreQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::fallback(function () {
    return redirect()->route('login');
});
Route::get('/contentPage/{slug}', [App\Http\Controllers\admin\ContentPageController::class, 'contentPage'])->name('contentPage');
Route::controller(AuthController::class)->group(function () {
    Route::match(['get','post'],'login','login')->name('login');
    Route::match(['get','post'],'register','register')->name('register');
    Route::match(['get','post'],'forget-password','forgetPassword')->name('forget-password');
    Route::match(['get','post'],'reset-password/{token}','resetPassword')->name('reset-password');
});
// Auth::routes();

Route::group(['prefix' =>'admin'],function () {
    Route::middleware(['auth','admin'])->name('admin.')->group(function () {
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

            // Manage auth routes
            Route::controller(AuthController::class)->group(function () {
               Route::match(['get', 'post'],'profile','profile')->name('profile');
               Route::match(['get', 'post'],'changePassword','changePassword')->name('changePassword');
               Route::get('logout','logout')->name('logout');
            });
            
            // Manage doctor routes
            Route::group(['prefix' =>'doctor'],function () {
                Route::name('doctor.')->controller(UserController::class)->group(function () {
                    Route::get('list','getDoctorList')->name('list');
                    Route::match(['get', 'post'],'add','addDoctor')->name('add');
                    Route::get('view/{id}','view')->name('view');
                    Route::match(['get', 'post'],'edit/{id}','edit')->name('edit');
                    Route::get('delete/{id}','delete')->name('delete');
                    Route::get('changeStatus','changeStatus')->name('changeStatus');
                });
            });

            // Manage patient routes
            Route::group(['prefix' =>'patient'],function () {
                Route::name('patient.')->controller(PatientController::class)->group(function () {
                    Route::get('list','getPatientList')->name('list');
                    Route::match(['get', 'post'],'add','addPatient')->name('add');
                    Route::get('view/{id}','view')->name('view');
                    Route::match(['get', 'post'],'edit/{id}','edit')->name('edit');
                    Route::get('delete/{id}','delete')->name('delete');
                    Route::get('changeStatus','changeStatus')->name('changeStatus');
                });
            });

            // Manage Banner routes
            Route::group(['prefix' =>'banner'],function () {
                Route::name('banner.')->controller(BannerController::class)->group(function () {
                    Route::get('list','getList')->name('list');
                    Route::match(['get', 'post'],'add','add')->name('add');
                    Route::match(['get', 'post'],'edit/{id}','edit')->name('edit');
                    Route::get('delete/{id}','delete')->name('delete');
                    Route::get('changeStatus','changeStatus')->name('changeStatus');
                });
            });

            // Manage Config setting routes
            Route::group(['prefix' =>'config-setting'],function () {
                Route::name('config-setting.')->controller(ConfigSettingController::class)->group(function () {
                    Route::match(['get', 'post'],'smtp','smtpInformation')->name('smtp');
                    Route::match(['get', 'post'],'stripe','stripeInformation')->name('stripe');
                    Route::match(['get', 'post'],'config','configInformation')->name('config');
                    Route::match(['get', 'post'],'paypal','payPalInformation')->name('paypal');
                });
            });

            // Manage Config setting routes
            Route::group(['prefix' =>'contentPages'],function () {
                Route::name('contentPages.')->controller(ContentPageController::class)->group(function () {
                    Route::match(['get', 'post'],'{slug}','contentPageDetail')->name('detail');
                });
            });

            /**Manage FAQ routes */
            Route::group(['prefix' =>'f-a-q'],function () {
                Route::name('f-a-q.')->controller(ManageFAQController::class)->group(function () {
                    Route::get('/','getList')->name('list');
                    Route::match(['get','post'],'add','add')->name('add');
                    Route::match(['get','post'],'edit/{id}','edit')->name('edit');
                    Route::get('delete/{id}','delete')->name('delete');
                    Route::get('changeStatus','changeStatus')->name('changeStatus');
                });
            });

            //Manage notification routes
            Route::group(['prefix' =>'notification'],function () {
                Route::name('notification.')->controller(NotificationController::class)->group(function () {
                    Route::get('/','getList')->name('list');
                    Route::get('read/{id}','notificationRead')->name('read');
                    Route::get('delete/{id}','delete')->name('delete');
                });
            });

            // Manage transactions routes
            Route::group(['prefix' =>'transaction'],function () {
                Route::name('transaction.')->controller(TransactionController::class)->group(function () {
                    Route::get('list','getList')->name('list');
                    Route::get('view/{id}','view')->name('view');
                });

            });

            // Manage order routes
            Route::group(['prefix' =>'order'],function () {
                Route::name('order.')->controller(OrderController::class)->group(function () {
                    Route::get('list','getList')->name('list');
                    Route::get('view/{id}','view')->name('view');
                });
            });

            /**Manage Plan routes */
            Route::group(['prefix' =>'plan'],function () {
                Route::name('plan.')->controller(PlanManagementController::class)->group(function () {
                    Route::get('/','getList')->name('list');
                    Route::match(['get','post'],'add','add')->name('add');
                    Route::match(['get','post'],'edit/{id}','edit')->name('edit');
                    Route::get('delete/{id}','delete')->name('delete');
                    Route::get('changeStatus','changeStatus')->name('changeStatus');
                });
            });

    });
});






Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');