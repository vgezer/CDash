<?php

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

use App\Http\Controllers\Auth\RegisterController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

$routeList = array('verify' => true);

if(config('auth.user_registration_form_enabled') === false) {
    $routeList['register'] = false;
}
Auth::routes($routeList);

Route::get('/install.php', 'AdminController@install');
Route::post('/install.php', 'AdminController@install');

Route::get('/oauth/{service}', 'OAuthController@authenticate');
Route::get('/oauth/callback/{service}', 'OAuthController@login')
    ->name('oauth.callback');
Route::post('/saml2/login', 'Auth\LoginController@saml2Login');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/recoverPassword.php', 'UserController@recoverPassword');
Route::post('/recoverPassword.php', 'UserController@recoverPassword');

Route::get('/login.php', function () {
    return redirect('/login');
});

Route::get('ping', function (Response $response) {
    try {
        DB::connection()->getPdo();
        $response->setContent('OK');
    } catch (\Exception $exception) {
        $response->setStatusCode(503);
    }
    return $response;
});

Route::get('/authtokens/manage', 'AuthTokenController@manage');

Route::get('/image/{image}', 'ImageController@image');
Route::get('/displayImage.php', function (Request $request) {
    $imgid = $request->query('imgid');
    return redirect("/image/{$imgid}", 301);
});

Route::get('/build/{id}', 'BuildController@summary');
Route::get('/buildSummary.php', function (Request $request) {
    $buildid = $request->query('buildid');
    return redirect("/build/{$buildid}");
});

Route::get('/build/{id}/configure', 'BuildController@configure');
Route::get('/viewConfigure.php', function (Request $request) {
    $buildid = $request->query('buildid');
    return redirect("/build/{$buildid}/configure");
});

Route::get('/build/{id}/notes', 'BuildController@notes');
Route::get('/viewNotes.php', function (Request $request) {
    $buildid = $request->query('buildid');
    return redirect("/build/{$buildid}/notes");
});

Route::get('/project/{id}/edit', 'EditProjectController@edit');
Route::get('/project/new', 'EditProjectController@create');

Route::get('/project/{id}/testmeasurements', 'ManageMeasurementsController@show');

Route::get('/test/{id}', 'TestController@details');
Route::get('/testDetails.php', function (Request $request) {
    $buildid = $request->query('build');
    $testid = $request->query('test');
    $buildtest = \App\Models\BuildTest::where('buildid', $buildid)->where('testid', $testid)->first();
    if ($buildtest !== null) {
        return redirect("/test/{$buildtest->id}");
    }
    abort(404);
});

Route::get('/generateCTestConfig.php', 'AdminController@generateCTestConfig');

Route::get('/viewProjects.php', 'ViewProjectsController@viewAllProjects');

Route::get('/viewUpdate.php', 'AdminController@viewUpdate');

Route::get('/viewTest.php', 'ViewTestController@viewTest');

Route::get('/viewCoverage.php', 'CoverageController@viewCoverage');

Route::get('/viewCoverageFile.php', 'CoverageController@viewCoverageFile');

Route::get('/buildOverview.php', 'BuildController@buildOverview');

Route::get('/buildProperties.php', 'BuildController@buildProperties');

Route::get('/viewSubProjectDependenciesGraph.php', 'SubProjectController@dependenciesGraph');

Route::get('/viewSubProjectDependencies.php', 'SubProjectController@dependencies');

Route::get('/viewSite.php', 'SiteController@viewSite');

Route::get('/viewMap.php', 'MapController@viewMap');

Route::get('/viewFiles.php', 'BuildController@viewFiles');

// The user must be logged in to access routes in this section.
// Requests from users who are not logged in will be redirected to /login.
//
// TODO: (williamjallen) Many of these routes are admin-only pages.  Create an automated
//       means of verifying that the user is an administrator rather than relying upon
//       each individual file to perform the check.
Route::group(['middleware' => 'auth' ], function () {
    Route::get('/user.php', 'UserController@userPage');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/editUser.php', 'UserController@edit');
    Route::post('/editUser.php', 'UserController@edit');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/subscribeProject.php', 'SubscribeProjectController@subscribeProject');
    Route::post('/subscribeProject.php', 'SubscribeProjectController@subscribeProject');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/manageProjectRoles.php', 'ManageProjectRolesController@viewPage');
    Route::post('/manageProjectRoles.php', 'ManageProjectRolesController@viewPage');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/manageUsers.php', 'ManageUsersController@showPage');
    Route::post('/manageUsers.php', 'ManageUsersController@showPage');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/manageBanner.php', 'ManageBannerController@manageBanner');
    Route::post('/manageBanner.php', 'ManageBannerController@manageBanner');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/manageCoverage.php', 'CoverageController@manageCoverage');
    Route::post('/manageCoverage.php', 'CoverageController@manageCoverage');

    Route::get('/siteStatistics.php', 'SiteController@siteStatistics');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/editSite.php', 'SiteController@editSite');
    Route::post('/editSite.php', 'SiteController@editSite');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/upgrade.php', 'AdminController@upgrade');
    Route::post('/upgrade.php', 'AdminController@upgrade');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/import.php', 'AdminController@import');
    Route::post('/import.php', 'AdminController@import');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/importBackup.php', 'AdminController@importBackup');
    Route::post('/importBackup.php', 'AdminController@importBackup');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/manageBackup.php', 'AdminController@manageBackup');
    Route::post('/manageBackup.php', 'AdminController@manageBackup');

    Route::get('/monitor', 'MonitorController@monitor');
    Route::get('/monitor.php', function () {
        return redirect('/monitor');
    });

    Route::get('/gitinfo.php', 'AdminController@gitinfo');

    // TODO: (williamjallen) send the POST route to a different function
    Route::get('/removeBuilds.php', 'AdminController@removeBuilds');
    Route::post('/removeBuilds.php', 'AdminController@removeBuilds');
});


// API ROUTES /////////////////////////////////////////////////////////////////
// TODO: (williamjallen) The routes in this section should be moved to api.php
//       eventually.  The routing/middleware infrastructure needs to be refactored
//       and this should be moved to api.php as part of that process.  The current
//       blocker is the API middleware which requires bearer tokens instead of
//       standard Laravel web sessions.

Route::get('/api/authtokens/all', 'AuthTokenController@fetchAll');
Route::post('/api/authtokens/create', 'AuthTokenController@createToken');
Route::delete('/api/authtokens/delete/{token_hash}', 'AuthTokenController@deleteToken');

Route::get('/api/monitor', 'MonitorController@get');

// OLD ROUTES (these may not use Laravel fully)

Route::get('/api/v1/viewProjects.php', 'ViewProjectsController@fetchPageContent');

Route::get('/api/v1/viewUpdate.php', 'AdminController@viewUpdatePageContent');

Route::get('/api/v1/viewTest.php', 'ViewTestController@fetchPageContent');

Route::get('/api/v1/user.php', 'UserController@userPageContent');

///////////////////////////////////////////////////////////////////////////////

// this *MUST* be the last route in the file
Route::any('{url}', 'CDash')->where('url', '.*');
