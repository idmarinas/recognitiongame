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

Route::post('/master/answerLog_ToDB', 'Pages\MasterController@answerLog_ToDB');
//Route::post('/master/topicPath', 'Pages\MasterController@topicPath');
Route::post('/master/themesTopicsOfTheme', 'Pages\MasterController@themesTopicsOfTheme');
Route::post('/master/themesTopics_FromDB', 'Pages\MasterController@themesTopics_FromDB');
Route::post('/master/proposal_FromDB', 'Pages\MasterController@proposal_FromDB');
Route::post('/master/quickgame_FromDB', 'Pages\MasterController@quickgame_FromDB');
Route::post('/master/webpagetext_FromDB', 'Pages\MasterController@webpagetext_FromDB');

Route::post('/contact/init', 'Pages\ContactController@init');
Route::post('/contact/submitForm', 'Pages\ContactController@submitForm');

Route::post('/index/init', 'Pages\IndexController@init');
Route::post('/index/imageCount_FromDB', 'Pages\IndexController@imageCount_FromDB');
Route::post('/index/startNewGame', 'Pages\IndexController@startNewGame');

Route::post('/newgame/init', 'Pages\NewGameController@init');
Route::post('/newgame/currentGame_Data', 'Pages\NewGameController@currentGame_Data');
Route::post('/newgame/help_Change', 'Pages\NewGameController@help_Change');

Route::post('/privacypolicy/init', 'Pages\PrivacyPolicyController@init');

Route::post('/themestopics/init', 'Pages\ThemesTopicsController@init');

Route::get('test', function () {
   Event::fire(new RecognitionGame\Events\NewGameLoadingEvent('KEZDŐDIK'));
    return "Event has been sent!";
});

Route::get('/{url}', 'Errors\Error404Controller@index');


