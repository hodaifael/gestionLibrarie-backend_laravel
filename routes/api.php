<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//STOCK//
Route::get('products', 'stockController@getProduct');

Route::get('productsglobal', 'stockController@getProductglobal');

Route::get('product/{id}', 'stockController@getProductById');

Route::post('addProduct', 'stockController@addProduct');

Route::post('duplicate', 'stockController@duplicate');

Route::post('updateProduct', 'stockController@updateProduct');

Route::post('editProduct', 'stockController@editProduct');

Route::delete('deleteProduct/{id}', 'stockController@deleteProduct');

Route::get('selectLastCodep', 'stockController@selectLastCodep');




/////commande

Route::post('AddProdInCommande', 'commandeController@AddProdInCommande');

Route::post('AddProdInNiveauCommande', 'commandeController@AddProdInNiveauCommande');

Route::post('UpdateProduct', 'commandeController@UpdateProduct');

Route::post('UpdateNumclient', 'commandeController@UpdateNumclient');

Route::get('selectLastc', 'commandeController@selectLastClient');

Route::post('getCommande', 'commandeController@getCommande');

Route::get('getCommandeinvoice/{id}', 'commandeController@getCommandeinvoice');

Route::post('videCommande', 'commandeController@videCommande');

Route::post('deleteProductOfCommand', 'commandeController@deleteProductOfCommand');




/////caisse

Route::post('AddProdIncaisses', 'caisseController@AddProdIncaisses');

Route::get('getcaisses/{date}', 'caisseController@getcaisses');

Route::post('UpdateProductcaisse', 'caisseController@UpdateProductcaisse');

Route::post('changenumclient', 'caisseController@changenumclient');

Route::delete('deleteProductOfcaisses/{id}', 'caisseController@deleteProductOfcaisses');



/////facture

Route::post('AddProdInFacture', 'factureController@AddProdInFacture');

Route::get('selectLastf', 'factureController@selectLastf');

Route::get('getFacture/{id}', 'factureController@getFacture');

Route::delete('deleteProductOfFacture/{id}', 'factureController@deleteProductOfFacture');

Route::post('updateFourAndFacture', 'factureController@updateFourAndFacture');

Route::post('transfer', 'factureController@transfer');

Route::post('UpdateProductFacture', 'factureController@UpdateProductFacture');




//fournisseur//
Route::get('fournisseurs', 'fourController@getfournisseur');

Route::post('addfournisseur', 'fourController@addfournisseur');

Route::delete('deletefournisseur/{id}', 'fourController@deletefournisseur');




//khadamt//
Route::get('getKhadamat/{date}', 'khadamatController@getKhadamat');

Route::post('addKhadamat', 'khadamatController@addKhadamat');

Route::delete('deleteKhadamat/{id}', 'khadamatController@deleteKhadamat');






//user
Route::get('users', 'userController@getusers');

Route::post('adduser', 'userController@adduser');

Route::delete('deleteusers/{id}', 'userController@deleteusers');




//  authentification
Route::post('auth', 'userController@auth');

Route::post('updatepass', 'userController@updatepass');



//chiffre
Route::get('getchiffreCommande/{id}', 'chiffreController@getchiffreCommande');




/////retour

Route::post('AddProdInRetour', 'retourController@AddProdInRetour');

Route::get('getretour', 'retourController@getretour');

Route::delete('deleteProductOfRetour/{id}', 'retourController@deleteProductOfRetour');

Route::post('addNumFacture', 'retourController@addNumFacture');



//Statistique

Route::post('getStatistique', 'statistiqueController@getStatistique');



//Entree//
Route::get('getEntree/{date}', 'EntreeSortieController@getEntree');

Route::post('addEntree', 'EntreeSortieController@addEntree');

Route::delete('deleteEntree/{id}', 'EntreeSortieController@deleteEntree');




//Sortie//
Route::get('getSortie/{date}', 'EntreeSortieController@getSortie');

Route::post('addSortie', 'EntreeSortieController@addSortie');

Route::delete('deleteSortie/{id}', 'EntreeSortieController@deleteSortie');




/////transfer

Route::post('AddProdIntransfer', 'transferController@AddProdIntransfer');

Route::get('gettransfer/{date}', 'transferController@gettransfer');

Route::post('updateProductTransfer', 'transferController@updateProductTransfer');

Route::delete('deleteProductOfTransfer/{id}', 'transferController@deleteProductOfTransfer');



/////Niveau

Route::post('AddProdInNiveau', 'commandeNiveauController@AddProdInNiveau');

Route::post('updateNomNiveau', 'commandeNiveauController@updateNomNiveau');

Route::post('UpdateProductNiveau', 'commandeNiveauController@UpdateProductNiveau');

Route::get('selectLastcNiveau', 'commandeNiveauController@selectLastcNiveau');

Route::get('getCommandeNiveau/{id}', 'commandeNiveauController@getCommandeNiveau');

Route::get('getNiveaux', 'commandeNiveauController@getNiveaux');

Route::get('getNomNiveau/{id}', 'commandeNiveauController@getNomNiveau');

Route::delete('deleteProductOfNiveau/{id}', 'commandeNiveauController@deleteProductOfNiveau');



//client
Route::get('getclients', 'clientfidelController@getclients');

Route::post('insertClient', 'clientfidelController@insertClient');

Route::delete('deleteclients/{id}', 'clientfidelController@deleteclients');


//beneficiaries
Route::get('getbeneficiaries', 'BeneficiariesController@getbeneficiaries');

Route::get('getbeneficiariesbyId/{id}', 'BeneficiariesController@getbeneficiariesbyId');

Route::post('insertbeneficiaries', 'BeneficiariesController@insertbeneficiaries');

Route::post('deletebeneficiaries', 'BeneficiariesController@deletebeneficiaries');



/////Commande Fournisseur

Route::post('AddProdInCmd', 'CmdFournissController@AddProdInCmd');

Route::get('selectLastCmd', 'CmdFournissController@selectLastCmd');

Route::get('getCmd/{id}', 'CmdFournissController@getCmd');

Route::delete('deleteProductOfCmd/{id}', 'CmdFournissController@deleteProductOfCmd');


Route::post('UpdateProductCmd', 'CmdFournissController@UpdateProductCmd');


/////QR Product

Route::post('AddProdInProductQR', 'SimpleQRcodeController@AddProdInProductQR');

Route::post('getProductQR', 'SimpleQRcodeController@getProductQR');

Route::get('getProductTypes', 'SimpleQRcodeController@getProductTypes');

Route::delete('deleteProductQR/{id}', 'SimpleQRcodeController@deleteProductQR');




//QR  Client
Route::get("generate", "SimpleQRcodeController@generate");




//debiteur
Route::get('getdebiteurs', 'debiteurController@getdebiteurs');

Route::post('insertdebiteurs', 'debiteurController@insertdebiteurs');

Route::post('changeavance', 'debiteurController@changeavance');

Route::delete('deletedebiteurs/{id}', 'debiteurController@deletedebiteurs');



//Detail benificiares


Route::get('detailcaisses/{numclient}', 'detailBenefController@detailcaisses');
Route::get('detailcommandes/{numclient}', 'detailBenefController@detailcommandes');
Route::get('transfer11/{date}', 'transferController@transfer11');
