<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Get list of Products
Route::get('products','ProductController@index');
Route::get('depenses','ProductController@depenses');
Route::get('topVente','ProductController@topVente');
Route::get('topProduit','ProductController@topProduit');
Route::get('depenseTopStation','ProductController@depenseTopStation');
Route::get('depenseParStationEtDate','ProductController@depenseParStationEtDate');
Route::get('TopClient','ProductController@TopClient');
Route::get('NbClient','ProductController@NbClient');
Route::get('CA','ProductController@CA');
Route::get('DepenseParAnnee','ProductController@DepenseParAnnee');
Route::get('nbEmploye','ProductController@nbEmploye');
Route::get('nbVente','ProductController@nbVente');
Route::get('DebitCredit','ProductController@DebitCredit');
Route::get('ProduitVenduParNombre','ProductController@ProduitVenduParNombre');
Route::get('CAparAnnee','ProductController@CAparAnnee');
Route::get('StockArticle','ProductController@StockArticle');
Route::get('EvoClient','ProductController@EvoClient');
Route::get('FourniProd','ProductController@FourniProd');
Route::get('tabReglement','ProductController@tabReglement');
Route::get('DetailReglement','ProductController@DetailReglement');
Route::get('ChartComercial','ProductController@ChartComercial');
Route::get('CmdClt','ProductController@CmdClt');
Route::get('DateDep','ProductController@DateDep');
Route::get('DatePvd','ProductController@DatePvd');
Route::get('DebitCreditDetail','ProductController@DebitCreditDetail');
Route::get('DateCmdClte','ProductController@DateCmdClte');
Route::get('ChartComercialDate','ProductController@ChartComercialDate');
Route::get('ChartComercialDetail','ProductController@ChartComercialDetail');
Route::get('ChartDistinctComercial','ProductController@ChartDistinctComercial');















// Get specific Product
Route::get('product/{id}','ProductController@show');

// Delete a Product
Route::delete('product/{id}','ProductController@destroy');

// Update existing Product
Route::put('product/{id}','ProductController@update');

// Create new Product
Route::post('product','ProductController@store');
