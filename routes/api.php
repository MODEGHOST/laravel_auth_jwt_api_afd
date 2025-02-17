<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockPriceController;
use App\Http\Controllers\ManualsGovernanController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DocreadController;
use App\Http\Controllers\NewsprintController;
use App\Http\Controllers\FinanStateController;
use App\Http\Controllers\HolderStucController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\DetailgenerationController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\MeetinguserController;
use App\Http\Controllers\ReportmtuserController;
use App\Http\Controllers\AdminofgodController;
use App\Http\Controllers\ThreeyearController;
use App\Http\Controllers\QuarterlyController;
use App\Http\Controllers\QuarandyearController;
use App\Http\Controllers\PolicypaymentController;
use App\Http\Controllers\ProposeagendaController;
use App\Http\Controllers\RulecompanyController;
use App\Http\Controllers\NewselecticController;
use App\Http\Controllers\VdomeetController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::get('/count-tables', [DatabaseController::class, 'countTables']);
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::get('/all', [StockPriceController::class, 'all']); // ดึงข้อมูลทั้งหมด
    Route::get('/stock-prices', [StockPriceController::class, 'getStockPrices']);
    Route::post('/stock-prices', [StockPriceController::class, 'store']); // เพิ่มข้อมูล
    Route::put('/stock-prices/{id}', [StockPriceController::class, 'update']); // แก้ไขข้อมูล
    Route::delete('/stock-prices/{id}', [StockPriceController::class, 'destroy']); // ลบข้อมูล
    Route::get('/stock-prices/latest', [StockPriceController::class, 'getLatest']);

});


Route::group(['middleware' => 'api'], function () {
    Route::get('/manuals', [ManualsGovernanController::class, 'index']); // GET: ดึงข้อมูลทั้งหมด
    Route::post('/manuals', [ManualsGovernanController::class, 'store']); // POST: เพิ่มข้อมูลใหม่
    Route::put('/manuals/{id}', [ManualsGovernanController::class, 'update']); // PUT: อัปเดตข้อมูล
    Route::post('/manuals/{id}', [ManualsGovernanController::class, 'update']);
    Route::delete('/manuals/{id}', [ManualsGovernanController::class, 'destroy']); // DELETE: ลบข้อมูล
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/rulecompany', [RulecompanyController::class, 'index']); // GET: ดึงข้อมูลทั้งหมด
    Route::post('/rulecompany', [RulecompanyController::class, 'store']); // POST: เพิ่มข้อมูลใหม่
    Route::put('/rulecompany/{id}', [RulecompanyController::class, 'update']); // PUT: อัปเดตข้อมูล
    Route::post('/rulecompany/{id}', [RulecompanyController::class, 'update']); // POST: อัปเดตข้อมูล (ถ้าต้องการใช้ POST แทน PUT)
    Route::delete('/rulecompany/{id}', [RulecompanyController::class, 'destroy']); // DELETE: ลบข้อมูล
});



Route::group(['middleware' => 'api'], function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::post('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/newselectic', [NewselecticController::class, 'index']);
    Route::post('/newselectic', [NewselecticController::class, 'store']);
    Route::put('/newselectic/{id}', [NewselecticController::class, 'update']);
    Route::post('/newselectic/{id}', [NewselecticController::class, 'update']);
    Route::delete('/newselectic/{id}', [NewselecticController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/policypayment', [PolicypaymentController::class, 'index']); // ดึงข้อมูลทั้งหมด
    Route::post('/policypayment', [PolicypaymentController::class, 'store']); // เพิ่มข้อมูลใหม่
    Route::put('/policypayment/{id}', [PolicypaymentController::class, 'update']); // อัปเดตข้อมูล
    Route::post('/policypayment/{id}', [PolicypaymentController::class, 'update']); // อัปเดตข้อมูล
    Route::delete('/policypayment/{id}', [PolicypaymentController::class, 'destroy']); // ลบข้อมูล
});


Route::group(['middleware' => 'api'], function () {
    Route::get('/proposeagenda', [ProposeagendaController::class, 'index']); // ดึงข้อมูลทั้งหมด
    Route::post('/proposeagenda', [ProposeagendaController::class, 'store']); // เพิ่มข้อมูลใหม่
    Route::put('/proposeagenda/{id}', [ProposeagendaController::class, 'update']); // อัปเดตข้อมูล
    Route::post('/proposeagenda/{id}', [ProposeagendaController::class, 'update']); // อัปเดตข้อมูล
    Route::delete('/proposeagenda/{id}', [ProposeagendaController::class, 'destroy']); // ลบข้อมูล
});


Route::group(['middleware' => 'api'], function () {
    Route::get('/meetinguser', [MeetinguserController::class, 'index']);
    Route::post('/meetinguser', [MeetinguserController::class, 'store']);
    Route::put('/meetinguser/{id}', [MeetinguserController::class, 'update']);
    Route::post('/meetinguser/{id}', [MeetinguserController::class, 'update']);
    Route::delete('/meetinguser/{id}', [MeetinguserController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/reportmtuser', [ReportmtuserController::class, 'index']);
    Route::post('/reportmtuser', [ReportmtuserController::class, 'store']);
    Route::put('/reportmtuser/{id}', [ReportmtuserController::class, 'update']);
    Route::post('/reportmtuser/{id}', [ReportmtuserController::class, 'update']);
    Route::delete('/reportmtuser/{id}', [ReportmtuserController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::put('/events/{id}', [EventController::class, 'update']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);
});


Route::group(['middleware' => 'api'], function () {
    Route::get('/doc_read', [DocreadController::class, 'index']);
    Route::post('/doc_read', [DocreadController::class, 'store']);
    Route::post('/doc_read/{id}', [DocreadController::class, 'update']);
    Route::delete('/doc_read/{id}', [DocreadController::class, 'destroy']);
    Route::get('/doc_read/{id}', [DocreadController::class, 'show']);

});



Route::group(['middleware' => 'api'], function () {
Route::get('/newsprint', [NewsprintController::class, 'index']);
Route::post('/newsprint', [NewsprintController::class, 'store']);
Route::put('/newsprint/{id}', [NewsprintController::class, 'update']);
Route::post('/newsprint/{id}', [NewsprintController::class, 'update']);
Route::delete('/newsprint/{id}', [NewsprintController::class, 'destroy']);
});



Route::group(['middleware' => 'api'], function () {
    Route::get('/finan-states', [FinanStateController::class, 'index']);
    Route::get('/finan-states/{year}', [FinanStateController::class, 'getByYear']);
    Route::post('/finan-states', [FinanStateController::class, 'store']);
    Route::post('/finan-states/{id}', [FinanStateController::class, 'update']); // ใช้ POST แทน PUT
    Route::delete('/finan-states/{id}', [FinanStateController::class, 'destroy']);

});



Route::group(['middleware' => 'api'], function () {
Route::get('/holders', [HolderStucController::class, 'index']);
Route::post('/holders', [HolderStucController::class, 'store']);
Route::put('/holders/{id}', [HolderStucController::class, 'update']);
Route::delete('/holders/{id}', [HolderStucController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/analysis', [AnalysisController::class, 'index']);
    Route::post('/analysis', [AnalysisController::class, 'store']);
    Route::put('/analysis/{id}', [AnalysisController::class, 'update']);
    Route::post('/analysis/{id}', [AnalysisController::class, 'update']);
    Route::delete('/analysis/{id}', [AnalysisController::class, 'destroy']);
});



Route::group(['middleware' => 'api'], function () {
    Route::get('/detailgenerations', [DetailgenerationController::class, 'index']);
    Route::post('/detailgenerations', [DetailgenerationController::class, 'store']);
    Route::post('/detailgenerations/{id}', [DetailgenerationController::class, 'update']);
    Route::delete('/detailgenerations/{id}', [DetailgenerationController::class, 'destroy']);
});

Route::group(['middleware' => 'api'], function () {
Route::get('/admins', [AdminofgodController::class, 'index']); // ดึงข้อมูลทั้งหมด
Route::get('/admins/{id}', [AdminofgodController::class, 'show']); // ดึงข้อมูลตาม ID
Route::post('/admins', [AdminofgodController::class, 'store']); // เพิ่มข้อมูลใหม่
Route::put('/admins/{id}', [AdminofgodController::class, 'update']); // อัปเดตข้อมูล
Route::delete('/admins/{id}', [AdminofgodController::class, 'destroy']); // ลบข้อมูล
Route::post('/admin/login', [AdminofgodController::class, 'login']);
});


Route::group(['middleware' => 'api'], function () {
    Route::get('/threeyear/all', [ThreeyearController::class, 'index']); // ดึงข้อมูลทั้งหมด
    Route::get('/threeyear/{id}', [ThreeyearController::class, 'show']); // ดึงข้อมูลตาม ID
    Route::post('/threeyear', [ThreeyearController::class, 'store']); // เพิ่มข้อมูล
    Route::put('/threeyear/{id}', [ThreeyearController::class, 'update']); // แก้ไขข้อมูลตาม ID
    Route::post('/threeyear/comments/update', [ThreeyearController::class, 'update']); // อัปเดต Comment
    Route::delete('/threeyear/{id}', [ThreeyearController::class, 'destroy']); // ลบข้อมูล
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/quarterly/all', [QuarterlyController::class, 'index']); // ดึงข้อมูลทั้งหมด
    Route::get('/quarterly/{id}', [QuarterlyController::class, 'show']); // ดึงข้อมูลตาม ID
    Route::post('/quarterly', [QuarterlyController::class, 'store']); // เพิ่มข้อมูล
    Route::put('/quarterly/{id}', [QuarterlyController::class, 'update']); // แก้ไขข้อมูล
    Route::delete('/quarterly/{id}', [QuarterlyController::class, 'destroy']); // ลบข้อมูล
});

Route::group(['middleware' => 'api'], function () {
    Route::get('/quarandyear/all', [QuarandyearController::class, 'index']); // ดึงข้อมูลทั้งหมด
    Route::get('/quarandyear/{id}', [QuarandyearController::class, 'show']); // ดึงข้อมูลตาม ID
    Route::post('/quarandyear', [QuarandyearController::class, 'store']); // เพิ่มข้อมูล
    Route::put('/quarandyear/{id}', [QuarandyearController::class, 'update']); // แก้ไขข้อมูล
    Route::delete('/quarandyear/{id}', [QuarandyearController::class, 'destroy']); // ลบข้อมูล
});



Route::group(['middleware' => 'api'], function () {
    Route::get('/vdomeet', [VdomeetController::class, 'index']);
    Route::post('/vdomeet', [VdomeetController::class, 'store']);
    Route::get('/vdomeet/{id}', [VdomeetController::class, 'show']);
    Route::put('/vdomeet/{id}', [VdomeetController::class, 'update']);
    Route::delete('/vdomeet/{id}', [VdomeetController::class, 'destroy']);
});


