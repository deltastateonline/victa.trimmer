<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/', 'MapController@show');

$app->get('map', 'MapController@show');
$app->get('yellowfever', 'MapController@showhealthcenters');
$app->get('motorcycle', 'MapController@showmotocycles');

$app->get('repairers', 'MapController@repairers');
$app->get('healthcenters', 'MapController@healthcenters');
$app->get('motorcycles', 'MapController@motorcycles');

$app->get('budget', 'BudgetController@show');

$app->get('updategeolocation', 'MapController@updategeolocation');

