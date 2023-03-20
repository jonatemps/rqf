<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('platform.login.auth');
});
Route::get('/storage/{link?}', function () {
    return redirect()->back();
})->name('download.file');
Route::get('/pdf-viewez/{path?}', function ($path) {
    dd(storage_path(str_replace('-',"\\","app-public-$path")));
    return response()->file(storage_path(str_replace('-',"\\","app-public-$path")));
    // return view('pdf_viewer');
})->name('pdf.viewer');

Route::get('/show-pdf', function() {
    return view('pdf_viewer');
})->name('show-pdf');

Route::get('/show-pdff', function() {
    // $file = YourFileModel::find($id);
    // return
    // dd(storage_path(str_replace('/',"\\",'public/2021/11/13/0bbd45d5e222fa3e28609f78c7212a39a92a87a6.pdf')));
    // http://127.0.0.1:8000/storage/2023/03/20/284f86e6c7131339e3a6cb7f724425e92892de14.pdf
    return response()->file('http://127.0.0.1:8000/storage/2023/03/20/284f86e6c7131339e3a6cb7f724425e92892de14.pdf');
    // return response()->file(storage_path(str_replace('/',"\\","storage/app/public/2023/03/20/284f86e6c7131339e3a6cb7f724425e92892de14.pdf")));

})->name('show-pdf');
