<?php
    use Pusher\Pusher;

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
    return redirect()->route('index');
});

Route::get('/master/changelang',[
    'uses' => 'Pages\MasterController@changelang',
    'as' => 'changelang'
]);

Route::get('/index/{proposal_Data?}',[
    'uses' => 'Pages\IndexController@index',
    'as' => 'index'
]);

Route::get('/contact', [
    'uses' =>'Pages\ContactController@index',
    'as' => 'contact'
]);

Route::get('/newgame/{sessionData_Random}', [
    'uses' =>'Pages\NewGameController@index',
    'as' => 'newgame'
]);

Route::get('/privacypolicy', [
    'uses' =>'Pages\PrivacyPolicyController@index',
    'as' => 'privacypolicy'
]);

Route::get('/themestopics', [
    'uses' =>'Pages\ThemesTopicsController@index',
    'as' => 'themestopics'
]);

Route::post('/master/answerLogToDB', 'Pages\MasterController@answerLogToDB');
Route::post('/master/mainthemeOfThemeTopic', 'Pages\MasterController@mainthemeOfThemeTopic');
Route::post('/master/topicsThemesOfTheme', 'Pages\MasterController@topicsThemesOfTheme');
Route::post('/master/mainthemethemetopicFromDB', 'Pages\MasterController@mainthemethemetopicFromDB');
Route::post('/master/proposalFromDB', 'Pages\MasterController@proposalFromDB');
Route::post('/master/quickgameFromDB', 'Pages\MasterController@quickgameFromDB');
Route::post('/master/webpagetextFromDB', 'Pages\MasterController@webpagetextFromDB');

Route::post('/contact/submitForm', 'Pages\ContactController@submitForm');

Route::post('/index/startNewGame', 'Pages\IndexController@startNewGame');
Route::post('/index/imageCountFromDB', 'Pages\IndexController@imageCountFromDB');

Route::post('/newgame/currentGameData', 'Pages\NewGameController@currentGameData');


Route::get('test', function () {
   Event::fire(new RecognitionGame\Events\NewGameLoadingEvent('KEZDŐDIK'));
    return "Event has been sent!";
});

Route::get('/{url}', 'Errors\Error404Controller@index');


