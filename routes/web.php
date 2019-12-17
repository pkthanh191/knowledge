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

Route::get('/', ['as' => 'home', 'uses' => 'Frontend\HomeController@index']);
Route::get('/forums', ['as' => 'home.forums', 'uses' => 'Frontend\HomeController@forums']);
Route::post('getCoefficient','CoefficientController@getCoefficient');
/*DOCUMENT START SESSION*/
Route::get('/tai-lieu', ['as' => 'documents', 'uses' => 'Frontend\DocumentController@index']);
Route::post('/tai-lieu/download', ['as' => 'documents.download', 'uses' => 'Frontend\DocumentController@download']);
Route::post('/tai-lieu/link-download', ['as' => 'documents.link_download', 'uses' => 'Frontend\DocumentController@link_download']);
Route::get('/tai-lieu/{slug}', ['as' => 'documents.show', 'uses' => 'Frontend\DocumentController@show']);
Route::post('/tai-lieu/comment', ['as' => 'documents.comment', 'uses' => 'Frontend\DocumentController@comment']);

/*DOCUMENT END SESSION*/

/*NEWS START SESSION*/
Route::get('/tin-tuc', ['as' => 'news', 'uses' => 'Frontend\NewsController@index']);
Route::get('/tin-tuc/{slug}', ['as' => 'news.show', 'uses' => 'Frontend\NewsController@show']);
Route::post('/tin-tuc/comment', ['as' => 'news.comment', 'uses' => 'Frontend\NewsController@comment']);
/*NEWS END SESSION*/

//USER ACTIVITIES
Route::get('/nguoi-dung', ['as' => 'users', 'uses' => 'Frontend\UserController@index']);
Route::post('/nguoi-dung', ['as' => 'users.update', 'uses' => 'Frontend\UserController@update']);
Route::post('/doi-mat-khau/', ['as' => 'users.change_pass', 'uses' => 'Frontend\UserController@change_pass']);
//END USER ACTIVITIES

/*TEST START SESSION*/
Route::get('/de-thi', ['as' => 'tests', 'uses' => 'Frontend\TestController@index']);
Route::post('/de-thi/download', ['as' => 'tests.download', 'uses' => 'Frontend\TestController@download']);
Route::post('/de-thi/link-download', ['as' => 'tests.link_download', 'uses' => 'Frontend\TestController@link_download']);
Route::get('/de-thi/{slug}', ['as' => 'tests.show', 'uses' => 'Frontend\TestController@show']);
Route::post('/de-thi/comment', ['as' => 'tests.comment', 'uses' => 'Frontend\TestController@comment']);

/*TEST END SESSION*/

//CENTER START
Route::get('/trung-tam-gia-su', ['as' => 'centers', 'uses' => 'Frontend\CenterController@index']);

Route::get('/trung-tam-gia-su/{slug}', ['as' => 'centers.show', 'uses' => 'Frontend\CenterController@show']);

//CENTER END


/*TEACHER START SESSION*/

Route::get('/gia-su', ['as' => 'teachers', 'uses' => 'Frontend\TeacherController@index']);
Route::get('/gia-su/{slug}', ['as' => 'teachers.show', 'uses' => 'Frontend\TeacherController@show']);

/*TEACHER END SESSION*/

Route::get('/khoa-hoc', ['as' => 'courses', 'uses' => 'Frontend\CourseController@index']);
Route::get('/khoa-hoc/{slug}', ['as' => 'courses.show', 'uses' => 'Frontend\CourseController@show']);
//COURSE START SESSION
Route::get('/tin-tuc', ['as' => 'news', 'uses' => 'Frontend\NewsController@index']);
Route::get('/lien-he', ['as' => 'contacts', 'uses' => 'Frontend\ContactsController@index']);
Route::post('/lien-he', ['as' => 'contacts', 'uses' => 'Frontend\ContactsController@contact']);
// Pages
Route::get('/trang/{slug}', ['as' => 'pages', 'uses' => 'Frontend\PagesController@index']);

// Start banners
Route::get('banner', 'Frontend\BannerController@banner');
// End banners

// Start Recharge
Route::post('/check-user', ['as' => 'check_user', 'uses' => 'Frontend\RechargeController@check_user']);
Route::post('/nap-tien', ['as' => 'recharge', 'uses' => 'Frontend\RechargeController@recharge']);
Route::get('/checkout', ['as' => 'checkout', 'uses' => 'Frontend\RechargeController@checkout']);
Route::get('/payment-success', ['as' => 'payment_success', 'uses' => 'Frontend\RechargeController@payment_success']);
// End Recharge

//Auth::routes();
Route::group(['middleware' => ['guest']], function () {
// User
    Route::get('dang-ky', 'Auth\RegisterController@authenticate');
    Route::post('dang-nhap', ['as' => 'login-user', 'uses' => 'Auth\LoginController@authenticate']);
    Route::post('dang-ky', ['as'=>'register','uses'=>'Auth\ActivationController@register']);
    Route::post('quen-mat-khau',['as'=>'forgot-password', 'uses'=>'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('quen-mat-khau', ['as'=>'forgot-password', 'uses'=>'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('dat-lai-mat-khau', ['as'=>'reset-password', 'uses'=>'Auth\ResetPasswordController@reset']);
    Route::get('dat-lai-mat-khau/{token}', ['as'=>'password.reset', 'uses'=>'Auth\ResetPasswordController@showResetForm']);
    Route::get('xac-thuc-tai-khoan/{token}', 'Auth\ActivationController@activateUser')->name('user.activate');
// Socialite Facebook & Google
    Route::get('/dang-nhap-facebook', 'Auth\SocialAuthController@redirectFacebook')->name('login-facebook');
    Route::get('/dang-nhap-google', 'Auth\SocialAuthController@redirectGoogle')->name('login-google');
    Route::get('/callback-facebook', 'Auth\SocialAuthController@callbackFacebook')->name('callback-facebook');
    Route::get('/callback-google', 'Auth\SocialAuthController@callbackGoogle')->name('callback-google');
    Route::post('/xac-nhan-email', 'Auth\SocialAuthController@authEmail')->name('auth-email');
// Admin
    Route::get('dang-nhap-quan-tri', ['as'=>'login', 'uses'=>'Auth\AdminAuthController@showLoginForm']);
    Route::post('dang-nhap-quan-tri', ['as'=>'login-manager', 'uses'=>'Auth\AdminAuthController@authenticate']);
});
Route::post('dang-xuat',['as'=>'logout', 'uses'=>'Auth\LoginController@logout']);
// End login routes

// Start Tutorial
Route::get('/tim-gia-su', ['as' => 'tutorials', 'uses' => 'Frontend\TutorialsController@index']);
Route::get('/tim-gia-su/dang-ky', ['as' => 'tutorials.register', 'uses' => 'Frontend\TutorialsController@register']);
Route::post('/tim-gia-su/create', ['as' => 'tutorials.register.create', 'uses' => 'Frontend\TutorialsController@create']);
Route::post('/tim-gia-su/detail', ['as' => 'tutorials.detail', 'uses' => 'Frontend\TutorialsController@detail']);
Route::post('/tim-gia-su/sendMail', ['as' => 'tutorials.sendMail', 'uses' => 'Frontend\TutorialsController@sendMail']);

// End Tutorial

Route::group(['middleware' => ['auth.admin']], function () {

    Route::get('admin/dashboard', ['as' => 'admin.dashboard.index', 'uses' => 'DashboardController@index']);

    Route::get('admin/categoryDocs', ['as' => 'admin.categoryDocs.index', 'uses' => 'CategoryDocController@index']);
    Route::post('admin/categoryDocs', ['as' => 'admin.categoryDocs.store', 'uses' => 'CategoryDocController@store']);
    Route::get('admin/categoryDocs/create', ['as' => 'admin.categoryDocs.create', 'uses' => 'CategoryDocController@create']);
    Route::put('admin/categoryDocs/{categoryDocs}', ['as' => 'admin.categoryDocs.update', 'uses' => 'CategoryDocController@update']);
    Route::patch('admin/categoryDocs/{categoryDocs}', ['as' => 'admin.categoryDocs.update', 'uses' => 'CategoryDocController@update']);
    Route::delete('admin/categoryDocs/{categoryDocs}', ['as' => 'admin.categoryDocs.destroy', 'uses' => 'CategoryDocController@destroy']);
    Route::get('admin/categoryDocs/{categoryDocs}', ['as' => 'admin.categoryDocs.show', 'uses' => 'CategoryDocController@show']);
    Route::get('admin/categoryDocs/{categoryDocs}/edit', ['as' => 'admin.categoryDocs.edit', 'uses' => 'CategoryDocController@edit']);


    Route::get('admin/categoryDocMetas', ['as' => 'admin.categoryDocMetas.index', 'uses' => 'CategoryDocMetaController@index']);
    Route::post('admin/categoryDocMetas', ['as' => 'admin.categoryDocMetas.store', 'uses' => 'CategoryDocMetaController@store']);
    Route::get('admin/categoryDocMetas/create', ['as' => 'admin.categoryDocMetas.create', 'uses' => 'CategoryDocMetaController@create']);
    Route::put('admin/categoryDocMetas/{categoryDocMetas}', ['as' => 'admin.categoryDocMetas.update', 'uses' => 'CategoryDocMetaController@update']);
    Route::patch('admin/categoryDocMetas/{categoryDocMetas}', ['as' => 'admin.categoryDocMetas.update', 'uses' => 'CategoryDocMetaController@update']);
    Route::delete('admin/categoryDocMetas/{categoryDocMetas}', ['as' => 'admin.categoryDocMetas.destroy', 'uses' => 'CategoryDocMetaController@destroy']);
    Route::get('admin/categoryDocMetas/{categoryDocMetas}', ['as' => 'admin.categoryDocMetas.show', 'uses' => 'CategoryDocMetaController@show']);
    Route::get('admin/categoryDocMetas/{categoryDocMetas}/edit', ['as' => 'admin.categoryDocMetas.edit', 'uses' => 'CategoryDocMetaController@edit']);


    Route::get('admin/documents', ['as' => 'admin.documents.index', 'uses' => 'DocumentController@index']);
    Route::post('admin/documents', ['as' => 'admin.documents.store', 'uses' => 'DocumentController@store']);
    Route::get('admin/documents/create', ['as' => 'admin.documents.create', 'uses' => 'DocumentController@create']);
    Route::post('admin/documents/export',['as'=>'admin.documents.export', 'uses'=>'DocumentController@exportExcel']);
    Route::get('admin/documents/formImport',['as'=>'admin.documents.formImport', 'uses'=>'DocumentController@formImport']);
    Route::get('admin/documents/import',['as'=>'admin.documents.import', 'uses'=>'DocumentController@showImport']);
    Route::post('admin/documents/import',['as'=>'admin.documents.import', 'uses'=>'DocumentController@importExcel']);
    Route::put('admin/documents/{documents}', ['as' => 'admin.documents.update', 'uses' => 'DocumentController@update']);
    Route::patch('admin/documents/{documents}', ['as' => 'admin.documents.update', 'uses' => 'DocumentController@update']);
    Route::delete('admin/documents/{documents}', ['as' => 'admin.documents.destroy', 'uses' => 'DocumentController@destroy']);
    Route::get('admin/documents/{documents}', ['as' => 'admin.documents.show', 'uses' => 'DocumentController@show']);
    Route::get('admin/documents/{documents}/edit', ['as' => 'admin.documents.edit', 'uses' => 'DocumentController@edit']);

    Route::get('admin/documentMetas', ['as' => 'admin.documentMetas.index', 'uses' => 'DocumentMetaController@index']);
    Route::post('admin/documentMetas', ['as' => 'admin.documentMetas.store', 'uses' => 'DocumentMetaController@store']);
    Route::get('admin/documentMetas/create', ['as' => 'admin.documentMetas.create', 'uses' => 'DocumentMetaController@create']);
    Route::put('admin/documentMetas/{documentMetas}', ['as' => 'admin.documentMetas.update', 'uses' => 'DocumentMetaController@update']);
    Route::patch('admin/documentMetas/{documentMetas}', ['as' => 'admin.documentMetas.update', 'uses' => 'DocumentMetaController@update']);
    Route::delete('admin/documentMetas/{documentMetas}', ['as' => 'admin.documentMetas.destroy', 'uses' => 'DocumentMetaController@destroy']);
    Route::get('admin/documentMetas/{documentMetas}', ['as' => 'admin.documentMetas.show', 'uses' => 'DocumentMetaController@show']);
    Route::get('admin/documentMetas/{documentMetas}/edit', ['as' => 'admin.documentMetas.edit', 'uses' => 'DocumentMetaController@edit']);


    Route::get('admin/documentMetaValues', ['as' => 'admin.documentMetaValues.index', 'uses' => 'DocumentMetaValueController@index']);
    Route::post('admin/documentMetaValues', ['as' => 'admin.documentMetaValues.store', 'uses' => 'DocumentMetaValueController@store']);
    Route::get('admin/documentMetaValues/create', ['as' => 'admin.documentMetaValues.create', 'uses' => 'DocumentMetaValueController@create']);
    Route::put('admin/documentMetaValues/{documentMetaValues}', ['as' => 'admin.documentMetaValues.update', 'uses' => 'DocumentMetaValueController@update']);
    Route::patch('admin/documentMetaValues/{documentMetaValues}', ['as' => 'admin.documentMetaValues.update', 'uses' => 'DocumentMetaValueController@update']);
    Route::delete('admin/documentMetaValues/{documentMetaValues}', ['as' => 'admin.documentMetaValues.destroy', 'uses' => 'DocumentMetaValueController@destroy']);
    Route::get('admin/documentMetaValues/{documentMetaValues}', ['as' => 'admin.documentMetaValues.show', 'uses' => 'DocumentMetaValueController@show']);
    Route::get('admin/documentMetaValues/{documentMetaValues}/edit', ['as' => 'admin.documentMetaValues.edit', 'uses' => 'DocumentMetaValueController@edit']);


    Route::get('admin/documentCategories', ['as' => 'admin.documentCategories.index', 'uses' => 'DocumentCategoryController@index']);
    Route::post('admin/documentCategories', ['as' => 'admin.documentCategories.store', 'uses' => 'DocumentCategoryController@store']);
    Route::get('admin/documentCategories/create', ['as' => 'admin.documentCategories.create', 'uses' => 'DocumentCategoryController@create']);
    Route::put('admin/documentCategories/{documentCategories}', ['as' => 'admin.documentCategories.update', 'uses' => 'DocumentCategoryController@update']);
    Route::patch('admin/documentCategories/{documentCategories}', ['as' => 'admin.documentCategories.update', 'uses' => 'DocumentCategoryController@update']);
    Route::delete('admin/documentCategories/{documentCategories}', ['as' => 'admin.documentCategories.destroy', 'uses' => 'DocumentCategoryController@destroy']);
    Route::get('admin/documentCategories/{documentCategories}', ['as' => 'admin.documentCategories.show', 'uses' => 'DocumentCategoryController@show']);
    Route::get('admin/documentCategories/{documentCategories}/edit', ['as' => 'admin.documentCategories.edit', 'uses' => 'DocumentCategoryController@edit']);


    Route::get('admin/comments', ['as' => 'admin.comments.index', 'uses' => 'CommentController@index']);
    Route::post('admin/comments', ['as' => 'admin.comments.store', 'uses' => 'CommentController@store']);
    Route::get('admin/comments/create', ['as' => 'admin.comments.create', 'uses' => 'CommentController@create']);
    Route::put('admin/comments/{comments}', ['as' => 'admin.comments.update', 'uses' => 'CommentController@update']);
    Route::patch('admin/comments/{comments}', ['as' => 'admin.comments.update', 'uses' => 'CommentController@update']);
    Route::delete('admin/comments/{comments}', ['as' => 'admin.comments.destroy', 'uses' => 'CommentController@destroy']);
    Route::get('admin/comments/{comments}', ['as' => 'admin.comments.show', 'uses' => 'CommentController@show']);
    Route::get('admin/comments/{comments}/edit', ['as' => 'admin.comments.edit', 'uses' => 'CommentController@edit']);
    Route::post('admin/comments/autoComment', ['as'=> 'admin.comments.autoComment', 'uses' => 'CommentController@autoComment']);
    Route::post('admin/comments/comment', ['as' => 'admin.comments.comment', 'uses' => 'CommentController@comment']);


    Route::get('admin/categoryNews', ['as' => 'admin.categoryNews.index', 'uses' => 'CategoryNewsController@index']);
    Route::post('admin/categoryNews', ['as' => 'admin.categoryNews.store', 'uses' => 'CategoryNewsController@store']);
    Route::get('admin/categoryNews/create', ['as' => 'admin.categoryNews.create', 'uses' => 'CategoryNewsController@create']);
    Route::put('admin/categoryNews/{categoryNews}', ['as' => 'admin.categoryNews.update', 'uses' => 'CategoryNewsController@update']);
    Route::patch('admin/categoryNews/{categoryNews}', ['as' => 'admin.categoryNews.update', 'uses' => 'CategoryNewsController@update']);
    Route::delete('admin/categoryNews/{categoryNews}', ['as' => 'admin.categoryNews.destroy', 'uses' => 'CategoryNewsController@destroy']);
    Route::get('admin/categoryNews/{categoryNews}', ['as' => 'admin.categoryNews.show', 'uses' => 'CategoryNewsController@show']);
    Route::get('admin/categoryNews/{categoryNews}/edit', ['as' => 'admin.categoryNews.edit', 'uses' => 'CategoryNewsController@edit']);


    Route::get('admin/news', ['as' => 'admin.news.index', 'uses' => 'NewsController@index']);
    Route::post('admin/news', ['as' => 'admin.news.store', 'uses' => 'NewsController@store']);
    Route::get('admin/news/create', ['as' => 'admin.news.create', 'uses' => 'NewsController@create']);
    Route::put('admin/news/{news}', ['as' => 'admin.news.update', 'uses' => 'NewsController@update']);
    Route::patch('admin/news/{news}', ['as' => 'admin.news.update', 'uses' => 'NewsController@update']);
    Route::delete('admin/news/{news}', ['as' => 'admin.news.destroy', 'uses' => 'NewsController@destroy']);
    Route::get('admin/news/{news}', ['as' => 'admin.news.show', 'uses' => 'NewsController@show']);
    Route::get('admin/news/{news}/edit', ['as' => 'admin.news.edit', 'uses' => 'NewsController@edit']);


    Route::get('admin/newsCategories', ['as' => 'admin.newsCategories.index', 'uses' => 'NewsCategoryController@index']);
    Route::post('admin/newsCategories', ['as' => 'admin.newsCategories.store', 'uses' => 'NewsCategoryController@store']);
    Route::get('admin/newsCategories/create', ['as' => 'admin.newsCategories.create', 'uses' => 'NewsCategoryController@create']);
    Route::put('admin/newsCategories/{newsCategories}', ['as' => 'admin.newsCategories.update', 'uses' => 'NewsCategoryController@update']);
    Route::patch('admin/newsCategories/{newsCategories}', ['as' => 'admin.newsCategories.update', 'uses' => 'NewsCategoryController@update']);
    Route::delete('admin/newsCategories/{newsCategories}', ['as' => 'admin.newsCategories.destroy', 'uses' => 'NewsCategoryController@destroy']);
    Route::get('admin/newsCategories/{newsCategories}', ['as' => 'admin.newsCategories.show', 'uses' => 'NewsCategoryController@show']);
    Route::get('admin/newsCategories/{newsCategories}/edit', ['as' => 'admin.newsCategories.edit', 'uses' => 'NewsCategoryController@edit']);


    Route::get('admin/categoryTests', ['as' => 'admin.categoryTests.index', 'uses' => 'CategoryTestController@index']);
    Route::post('admin/categoryTests', ['as' => 'admin.categoryTests.store', 'uses' => 'CategoryTestController@store']);
    Route::get('admin/categoryTests/create', ['as' => 'admin.categoryTests.create', 'uses' => 'CategoryTestController@create']);
    Route::put('admin/categoryTests/{categoryTests}', ['as' => 'admin.categoryTests.update', 'uses' => 'CategoryTestController@update']);
    Route::patch('admin/categoryTests/{categoryTests}', ['as' => 'admin.categoryTests.update', 'uses' => 'CategoryTestController@update']);
    Route::delete('admin/categoryTests/{categoryTests}', ['as' => 'admin.categoryTests.destroy', 'uses' => 'CategoryTestController@destroy']);
    Route::get('admin/categoryTests/{categoryTests}', ['as' => 'admin.categoryTests.show', 'uses' => 'CategoryTestController@show']);
    Route::get('admin/categoryTests/{categoryTests}/edit', ['as' => 'admin.categoryTests.edit', 'uses' => 'CategoryTestController@edit']);


    Route::get('admin/tests', ['as' => 'admin.tests.index', 'uses' => 'TestController@index']);
    Route::post('admin/tests', ['as' => 'admin.tests.store', 'uses' => 'TestController@store']);
    Route::get('admin/tests/create', ['as' => 'admin.tests.create', 'uses' => 'TestController@create']);
    Route::post('admin/tests/export', ['as' => 'admin.tests.export', 'uses' => 'TestController@exportExcel']);
    Route::get('admin/tests/import', ['as' => 'admin.tests.import', 'uses' => 'TestController@showImport']);
    Route::get('admin/tests/formImport', ['as' => 'admin.tests.formImport', 'uses' => 'TestController@formImport']);
    Route::post('admin/tests/import', ['as' => 'admin.tests.import', 'uses' => 'TestController@importExcel']);
    Route::put('admin/tests/{tests}', ['as' => 'admin.tests.update', 'uses' => 'TestController@update']);
    Route::patch('admin/tests/{tests}', ['as' => 'admin.tests.update', 'uses' => 'TestController@update']);
    Route::delete('admin/tests/{tests}', ['as' => 'admin.tests.destroy', 'uses' => 'TestController@destroy']);
    Route::get('admin/tests/{tests}', ['as' => 'admin.tests.show', 'uses' => 'TestController@show']);
    Route::get('admin/tests/{tests}/edit', ['as' => 'admin.tests.edit', 'uses' => 'TestController@edit']);


    Route::get('admin/testCategories', ['as' => 'admin.testCategories.index', 'uses' => 'TestCategoryController@index']);
    Route::post('admin/testCategories', ['as' => 'admin.testCategories.store', 'uses' => 'TestCategoryController@store']);
    Route::get('admin/testCategories/create', ['as' => 'admin.testCategories.create', 'uses' => 'TestCategoryController@create']);
    Route::put('admin/testCategories/{testCategories}', ['as' => 'admin.testCategories.update', 'uses' => 'TestCategoryController@update']);
    Route::patch('admin/testCategories/{testCategories}', ['as' => 'admin.testCategories.update', 'uses' => 'TestCategoryController@update']);
    Route::delete('admin/testCategories/{testCategories}', ['as' => 'admin.testCategories.destroy', 'uses' => 'TestCategoryController@destroy']);
    Route::get('admin/testCategories/{testCategories}', ['as' => 'admin.testCategories.show', 'uses' => 'TestCategoryController@show']);
    Route::get('admin/testCategories/{testCategories}/edit', ['as' => 'admin.testCategories.edit', 'uses' => 'TestCategoryController@edit']);


    Route::get('admin/centers', ['as' => 'admin.centers.index', 'uses' => 'CenterController@index']);
    Route::post('admin/centers', ['as' => 'admin.centers.store', 'uses' => 'CenterController@store']);
    Route::get('admin/centers/create', ['as' => 'admin.centers.create', 'uses' => 'CenterController@create']);
    Route::put('admin/centers/{centers}', ['as' => 'admin.centers.update', 'uses' => 'CenterController@update']);
    Route::patch('admin/centers/{centers}', ['as' => 'admin.centers.update', 'uses' => 'CenterController@update']);
    Route::delete('admin/centers/{centers}', ['as' => 'admin.centers.destroy', 'uses' => 'CenterController@destroy']);
    Route::get('admin/centers/{centers}', ['as' => 'admin.centers.show', 'uses' => 'CenterController@show']);
    Route::get('admin/centers/{centers}/edit', ['as' => 'admin.centers.edit', 'uses' => 'CenterController@edit']);


    Route::get('admin/teachers', ['as' => 'admin.teachers.index', 'uses' => 'TeacherController@index']);
    Route::post('admin/teachers', ['as' => 'admin.teachers.store', 'uses' => 'TeacherController@store']);
    Route::get('admin/teachers/create', ['as' => 'admin.teachers.create', 'uses' => 'TeacherController@create']);
    Route::put('admin/teachers/{teachers}', ['as' => 'admin.teachers.update', 'uses' => 'TeacherController@update']);
    Route::patch('admin/teachers/{teachers}', ['as' => 'admin.teachers.update', 'uses' => 'TeacherController@update']);
    Route::delete('admin/teachers/{teachers}', ['as' => 'admin.teachers.destroy', 'uses' => 'TeacherController@destroy']);
    Route::get('admin/teachers/{teachers}', ['as' => 'admin.teachers.show', 'uses' => 'TeacherController@show']);
    Route::get('admin/teachers/{teachers}/edit', ['as' => 'admin.teachers.edit', 'uses' => 'TeacherController@edit']);


    Route::get('admin/categoryCourses', ['as' => 'admin.categoryCourses.index', 'uses' => 'CategoryCourseController@index']);
    Route::post('admin/categoryCourses', ['as' => 'admin.categoryCourses.store', 'uses' => 'CategoryCourseController@store']);
    Route::get('admin/categoryCourses/create', ['as' => 'admin.categoryCourses.create', 'uses' => 'CategoryCourseController@create']);
    Route::put('admin/categoryCourses/{categoryCourses}', ['as' => 'admin.categoryCourses.update', 'uses' => 'CategoryCourseController@update']);
    Route::patch('admin/categoryCourses/{categoryCourses}', ['as' => 'admin.categoryCourses.update', 'uses' => 'CategoryCourseController@update']);
    Route::delete('admin/categoryCourses/{categoryCourses}', ['as' => 'admin.categoryCourses.destroy', 'uses' => 'CategoryCourseController@destroy']);
    Route::get('admin/categoryCourses/{categoryCourses}', ['as' => 'admin.categoryCourses.show', 'uses' => 'CategoryCourseController@show']);
    Route::get('admin/categoryCourses/{categoryCourses}/edit', ['as' => 'admin.categoryCourses.edit', 'uses' => 'CategoryCourseController@edit']);

    Route::get('admin/courses', ['as' => 'admin.courses.index', 'uses' => 'CourseController@index']);
    Route::post('admin/courses', ['as' => 'admin.courses.store', 'uses' => 'CourseController@store']);
    Route::get('admin/courses/create', ['as' => 'admin.courses.create', 'uses' => 'CourseController@create']);
    Route::put('admin/courses/{courses}', ['as' => 'admin.courses.update', 'uses' => 'CourseController@update']);
    Route::patch('admin/courses/{courses}', ['as' => 'admin.courses.update', 'uses' => 'CourseController@update']);
    Route::delete('admin/courses/{courses}', ['as' => 'admin.courses.destroy', 'uses' => 'CourseController@destroy']);
    Route::get('admin/courses/{courses}', ['as' => 'admin.courses.show', 'uses' => 'CourseController@show']);
    Route::get('admin/courses/{courses}/edit', ['as' => 'admin.courses.edit', 'uses' => 'CourseController@edit']);


    Route::get('admin/courseCategories', ['as' => 'admin.courseCategories.index', 'uses' => 'CourseCategoryController@index']);
    Route::post('admin/courseCategories', ['as' => 'admin.courseCategories.store', 'uses' => 'CourseCategoryController@store']);
    Route::get('admin/courseCategories/create', ['as' => 'admin.courseCategories.create', 'uses' => 'CourseCategoryController@create']);
    Route::put('admin/courseCategories/{courseCategories}', ['as' => 'admin.courseCategories.update', 'uses' => 'CourseCategoryController@update']);
    Route::patch('admin/courseCategories/{courseCategories}', ['as' => 'admin.courseCategories.update', 'uses' => 'CourseCategoryController@update']);
    Route::delete('admin/courseCategories/{courseCategories}', ['as' => 'admin.courseCategories.destroy', 'uses' => 'CourseCategoryController@destroy']);
    Route::get('admin/courseCategories/{courseCategories}', ['as' => 'admin.courseCategories.show', 'uses' => 'CourseCategoryController@show']);
    Route::get('admin/courseCategories/{courseCategories}/edit', ['as' => 'admin.courseCategories.edit', 'uses' => 'CourseCategoryController@edit']);

    Route::get('admin/courseOrders', ['as' => 'admin.courseOrders.index', 'uses' => 'CourseOrderController@index']);
    Route::post('admin/courseOrders', ['as' => 'admin.courseOrders.store', 'uses' => 'CourseOrderController@store']);
    Route::get('admin/courseOrders/create', ['as' => 'admin.courseOrders.create', 'uses' => 'CourseOrderController@create']);
    Route::put('admin/courseOrders/{courseOrders}', ['as' => 'admin.courseOrders.update', 'uses' => 'CourseOrderController@update']);
    Route::patch('admin/courseOrders/{courseOrders}', ['as' => 'admin.courseOrders.update', 'uses' => 'CourseOrderController@update']);
    Route::delete('admin/courseOrders/{courseOrders}', ['as' => 'admin.courseOrders.destroy', 'uses' => 'CourseOrderController@destroy']);
    Route::get('admin/courseOrders/{courseOrders}', ['as' => 'admin.courseOrders.show', 'uses' => 'CourseOrderController@show']);
    Route::get('admin/courseOrders/{courseOrders}/edit', ['as' => 'admin.courseOrders.edit', 'uses' => 'CourseOrderController@edit']);


    Route::get('admin/commentTests', ['as'=> 'admin.commentTests.index', 'uses' => 'CommentTestController@index']);
    Route::post('admin/commentTests', ['as'=> 'admin.commentTests.store', 'uses' => 'CommentTestController@store']);
    Route::get('admin/commentTests/create', ['as'=> 'admin.commentTests.create', 'uses' => 'CommentTestController@create']);
    Route::put('admin/commentTests/{commentTests}', ['as'=> 'admin.commentTests.update', 'uses' => 'CommentTestController@update']);
    Route::patch('admin/commentTests/{commentTests}', ['as'=> 'admin.commentTests.update', 'uses' => 'CommentTestController@update']);
    Route::delete('admin/commentTests/{commentTests}', ['as'=> 'admin.commentTests.destroy', 'uses' => 'CommentTestController@destroy']);
    Route::get('admin/commentTests/{commentTests}', ['as'=> 'admin.commentTests.show', 'uses' => 'CommentTestController@show']);
    Route::get('admin/commentTests/{commentTests}/edit', ['as'=> 'admin.commentTests.edit', 'uses' => 'CommentTestController@edit']);
    Route::post('admin/commentTests/autoComment', ['as'=> 'admin.commentTests.autoComment', 'uses' => 'CommentTestController@autoComment']);
    Route::post('admin/commentTests/comment', ['as' => 'admin.commentTests.comment', 'uses' => 'CommentTestController@comment']);
   
    Route::get('admin/users', ['as' => 'admin.users.index', 'uses' => 'UserController@index']);
    Route::post('admin/users', ['as' => 'admin.users.store', 'uses' => 'UserController@store']);
    Route::get('admin/users/create', ['as' => 'admin.users.create', 'uses' => 'UserController@create']);
    Route::put('admin/users/{users}', ['as' => 'admin.users.update', 'uses' => 'UserController@update']);
    Route::patch('admin/users/{users}', ['as' => 'admin.users.update', 'uses' => 'UserController@update']);
    Route::delete('admin/users/{users}', ['as' => 'admin.users.destroy', 'uses' => 'UserController@destroy']);
    Route::get('admin/users/{users}', ['as' => 'admin.users.show', 'uses' => 'UserController@show']);
    Route::get('admin/users/{users}/edit', ['as' => 'admin.users.edit', 'uses' => 'UserController@edit']);
    Route::POST('admin/users/{users}', ['as' => 'admin.users.addMoney', 'uses' => 'UserController@addMoney']);

    Route::get('admin/pages', ['as'=> 'admin.pages.index', 'uses' => 'PageController@index']);
    Route::post('admin/pages', ['as'=> 'admin.pages.store', 'uses' => 'PageController@store']);
    Route::get('admin/pages/create', ['as'=> 'admin.pages.create', 'uses' => 'PageController@create']);
    Route::put('admin/pages/{pages}', ['as'=> 'admin.pages.update', 'uses' => 'PageController@update']);
    Route::patch('admin/pages/{pages}', ['as'=> 'admin.pages.update', 'uses' => 'PageController@update']);
    Route::delete('admin/pages/{pages}', ['as'=> 'admin.pages.destroy', 'uses' => 'PageController@destroy']);
    Route::get('admin/pages/{pages}', ['as'=> 'admin.pages.show', 'uses' => 'PageController@show']);
    Route::get('admin/pages/{pages}/edit', ['as'=> 'admin.pages.edit', 'uses' => 'PageController@edit']);

    Route::get('admin/configs', ['as'=> 'admin.configs.index', 'uses' => 'ConfigController@index']);
    Route::post('admin/configs', ['as'=> 'admin.configs.store', 'uses' => 'ConfigController@store']);
    Route::get('admin/configs/create', ['as'=> 'admin.configs.create', 'uses' => 'ConfigController@create']);
    Route::put('admin/configs/{configs}', ['as'=> 'admin.configs.update', 'uses' => 'ConfigController@update']);
    Route::patch('admin/configs/{configs}', ['as'=> 'admin.configs.update', 'uses' => 'ConfigController@update']);
    Route::delete('admin/configs/{configs}', ['as'=> 'admin.configs.destroy', 'uses' => 'ConfigController@destroy']);
    Route::get('admin/configs/{configs}', ['as'=> 'admin.configs.show', 'uses' => 'ConfigController@show']);
    Route::get('admin/configs/{configs}/edit', ['as'=> 'admin.configs.edit', 'uses' => 'ConfigController@edit']);

    Route::get('admin/banners', ['as'=> 'admin.banners.index', 'uses' => 'BannerController@index']);
    Route::post('admin/banners', ['as'=> 'admin.banners.store', 'uses' => 'BannerController@store']);
    Route::get('admin/banners/create', ['as'=> 'admin.banners.create', 'uses' => 'BannerController@create']);
    Route::put('admin/banners/{banners}', ['as'=> 'admin.banners.update', 'uses' => 'BannerController@update']);
    Route::patch('admin/banners/{banners}', ['as'=> 'admin.banners.update', 'uses' => 'BannerController@update']);
    Route::delete('admin/banners/{banners}', ['as'=> 'admin.banners.destroy', 'uses' => 'BannerController@destroy']);
    Route::get('admin/banners/{banners}', ['as'=> 'admin.banners.show', 'uses' => 'BannerController@show']);
    Route::get('admin/banners/{banners}/edit', ['as'=> 'admin.banners.edit', 'uses' => 'BannerController@edit']);

    Route::get('admin/commentNews', ['as'=> 'admin.commentNews.index', 'uses' => 'CommentNewsController@index']);
    Route::post('admin/commentNews', ['as'=> 'admin.commentNews.store', 'uses' => 'CommentNewsController@store']);
    Route::get('admin/commentNews/create', ['as'=> 'admin.commentNews.create', 'uses' => 'CommentNewsController@create']);
    Route::put('admin/commentNews/{commentNews}', ['as'=> 'admin.commentNews.update', 'uses' => 'CommentNewsController@update']);
    Route::patch('admin/commentNews/{commentNews}', ['as'=> 'admin.commentNews.update', 'uses' => 'CommentNewsController@update']);
    Route::delete('admin/commentNews/{commentNews}', ['as'=> 'admin.commentNews.destroy', 'uses' => 'CommentNewsController@destroy']);
    Route::get('admin/commentNews/{commentNews}', ['as'=> 'admin.commentNews.show', 'uses' => 'CommentNewsController@show']);
    Route::get('admin/commentNews/{commentNews}/edit', ['as'=> 'admin.commentNews.edit', 'uses' => 'CommentNewsController@edit']);
    Route::post('admin/commentNews/autoComment', ['as'=> 'admin.commentNews.autoComment', 'uses' => 'CommentNewsController@autoComment']);
    Route::post('admin/commentNews/comment', ['as' => 'admin.commentNews.comment', 'uses' => 'CommentNewsController@comment']);

    Route::get('admin/subjects', ['as'=> 'admin.subjects.index', 'uses' => 'SubjectController@index']);
    Route::post('admin/subjects', ['as'=> 'admin.subjects.store', 'uses' => 'SubjectController@store']);
    Route::get('admin/subjects/create', ['as'=> 'admin.subjects.create', 'uses' => 'SubjectController@create']);
    Route::put('admin/subjects/{subjects}', ['as'=> 'admin.subjects.update', 'uses' => 'SubjectController@update']);
    Route::patch('admin/subjects/{subjects}', ['as'=> 'admin.subjects.update', 'uses' => 'SubjectController@update']);
    Route::delete('admin/subjects/{subjects}', ['as'=> 'admin.subjects.destroy', 'uses' => 'SubjectController@destroy']);
    Route::get('admin/subjects/{subjects}', ['as'=> 'admin.subjects.show', 'uses' => 'SubjectController@show']);
    Route::get('admin/subjects/{subjects}/edit', ['as'=> 'admin.subjects.edit', 'uses' => 'SubjectController@edit']);


    Route::get('admin/grades', ['as'=> 'admin.grades.index', 'uses' => 'GradeController@index']);
    Route::post('admin/grades', ['as'=> 'admin.grades.store', 'uses' => 'GradeController@store']);
    Route::get('admin/grades/create', ['as'=> 'admin.grades.create', 'uses' => 'GradeController@create']);
    Route::put('admin/grades/{grades}', ['as'=> 'admin.grades.update', 'uses' => 'GradeController@update']);
    Route::patch('admin/grades/{grades}', ['as'=> 'admin.grades.update', 'uses' => 'GradeController@update']);
    Route::delete('admin/grades/{grades}', ['as'=> 'admin.grades.destroy', 'uses' => 'GradeController@destroy']);
    Route::get('admin/grades/{grades}', ['as'=> 'admin.grades.show', 'uses' => 'GradeController@show']);
    Route::get('admin/grades/{grades}/edit', ['as'=> 'admin.grades.edit', 'uses' => 'GradeController@edit']);


    Route::get('admin/tutorials', ['as'=> 'admin.tutorials.index', 'uses' => 'TutorialController@index']);
    Route::post('admin/tutorials', ['as'=> 'admin.tutorials.store', 'uses' => 'TutorialController@store']);
    Route::get('admin/tutorials/create', ['as'=> 'admin.tutorials.create', 'uses' => 'TutorialController@create']);
    Route::put('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::patch('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::delete('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.destroy', 'uses' => 'TutorialController@destroy']);
    Route::get('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.show', 'uses' => 'TutorialController@show']);
    Route::get('admin/tutorials/{tutorials}/edit', ['as'=> 'admin.tutorials.edit', 'uses' => 'TutorialController@edit']);


    Route::get('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.index', 'uses' => 'SubjectTutorialController@index']);
    Route::post('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.store', 'uses' => 'SubjectTutorialController@store']);
    Route::get('admin/subjectTutorials/create', ['as'=> 'admin.subjectTutorials.create', 'uses' => 'SubjectTutorialController@create']);
    Route::put('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::patch('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::delete('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.destroy', 'uses' => 'SubjectTutorialController@destroy']);
    Route::get('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.show', 'uses' => 'SubjectTutorialController@show']);
    Route::get('admin/subjectTutorials/{subjectTutorials}/edit', ['as'=> 'admin.subjectTutorials.edit', 'uses' => 'SubjectTutorialController@edit']);


    Route::get('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.index', 'uses' => 'GradeTutorialController@index']);
    Route::post('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.store', 'uses' => 'GradeTutorialController@store']);
    Route::get('admin/gradeTutorials/create', ['as'=> 'admin.gradeTutorials.create', 'uses' => 'GradeTutorialController@create']);
    Route::put('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::patch('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::delete('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.destroy', 'uses' => 'GradeTutorialController@destroy']);
    Route::get('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.show', 'uses' => 'GradeTutorialController@show']);
    Route::get('admin/gradeTutorials/{gradeTutorials}/edit', ['as'=> 'admin.gradeTutorials.edit', 'uses' => 'GradeTutorialController@edit']);

    Route::get('admin/tutorials', ['as'=> 'admin.tutorials.index', 'uses' => 'TutorialController@index']);
    Route::post('admin/tutorials', ['as'=> 'admin.tutorials.store', 'uses' => 'TutorialController@store']);
    Route::get('admin/tutorials/create', ['as'=> 'admin.tutorials.create', 'uses' => 'TutorialController@create']);
    Route::put('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::patch('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::delete('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.destroy', 'uses' => 'TutorialController@destroy']);
    Route::get('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.show', 'uses' => 'TutorialController@show']);
    Route::get('admin/tutorials/{tutorials}/edit', ['as'=> 'admin.tutorials.edit', 'uses' => 'TutorialController@edit']);


    Route::get('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.index', 'uses' => 'SubjectTutorialController@index']);
    Route::post('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.store', 'uses' => 'SubjectTutorialController@store']);
    Route::get('admin/subjectTutorials/create', ['as'=> 'admin.subjectTutorials.create', 'uses' => 'SubjectTutorialController@create']);
    Route::put('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::patch('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::delete('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.destroy', 'uses' => 'SubjectTutorialController@destroy']);
    Route::get('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.show', 'uses' => 'SubjectTutorialController@show']);
    Route::get('admin/subjectTutorials/{subjectTutorials}/edit', ['as'=> 'admin.subjectTutorials.edit', 'uses' => 'SubjectTutorialController@edit']);


    Route::get('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.index', 'uses' => 'GradeTutorialController@index']);
    Route::post('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.store', 'uses' => 'GradeTutorialController@store']);
    Route::get('admin/gradeTutorials/create', ['as'=> 'admin.gradeTutorials.create', 'uses' => 'GradeTutorialController@create']);
    Route::put('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::patch('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::delete('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.destroy', 'uses' => 'GradeTutorialController@destroy']);
    Route::get('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.show', 'uses' => 'GradeTutorialController@show']);
    Route::get('admin/gradeTutorials/{gradeTutorials}/edit', ['as'=> 'admin.gradeTutorials.edit', 'uses' => 'GradeTutorialController@edit']);

    Route::get('admin/tutorials', ['as'=> 'admin.tutorials.index', 'uses' => 'TutorialController@index']);
    Route::post('admin/tutorials', ['as'=> 'admin.tutorials.store', 'uses' => 'TutorialController@store']);
    Route::get('admin/tutorials/create', ['as'=> 'admin.tutorials.create', 'uses' => 'TutorialController@create']);
    Route::put('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::patch('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.update', 'uses' => 'TutorialController@update']);
    Route::delete('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.destroy', 'uses' => 'TutorialController@destroy']);
    Route::get('admin/tutorials/{tutorials}', ['as'=> 'admin.tutorials.show', 'uses' => 'TutorialController@show']);
    Route::get('admin/tutorials/{tutorials}/edit', ['as'=> 'admin.tutorials.edit', 'uses' => 'TutorialController@edit']);


    Route::get('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.index', 'uses' => 'SubjectTutorialController@index']);
    Route::post('admin/subjectTutorials', ['as'=> 'admin.subjectTutorials.store', 'uses' => 'SubjectTutorialController@store']);
    Route::get('admin/subjectTutorials/create', ['as'=> 'admin.subjectTutorials.create', 'uses' => 'SubjectTutorialController@create']);
    Route::put('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::patch('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.update', 'uses' => 'SubjectTutorialController@update']);
    Route::delete('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.destroy', 'uses' => 'SubjectTutorialController@destroy']);
    Route::get('admin/subjectTutorials/{subjectTutorials}', ['as'=> 'admin.subjectTutorials.show', 'uses' => 'SubjectTutorialController@show']);
    Route::get('admin/subjectTutorials/{subjectTutorials}/edit', ['as'=> 'admin.subjectTutorials.edit', 'uses' => 'SubjectTutorialController@edit']);


    Route::get('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.index', 'uses' => 'GradeTutorialController@index']);
    Route::post('admin/gradeTutorials', ['as'=> 'admin.gradeTutorials.store', 'uses' => 'GradeTutorialController@store']);
    Route::get('admin/gradeTutorials/create', ['as'=> 'admin.gradeTutorials.create', 'uses' => 'GradeTutorialController@create']);
    Route::put('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::patch('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.update', 'uses' => 'GradeTutorialController@update']);
    Route::delete('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.destroy', 'uses' => 'GradeTutorialController@destroy']);
    Route::get('admin/gradeTutorials/{gradeTutorials}', ['as'=> 'admin.gradeTutorials.show', 'uses' => 'GradeTutorialController@show']);
    Route::get('admin/gradeTutorials/{gradeTutorials}/edit', ['as'=> 'admin.gradeTutorials.edit', 'uses' => 'GradeTutorialController@edit']);

    Route::get('admin/cities', ['as'=> 'admin.cities.index', 'uses' => 'CityController@index']);
    Route::post('admin/cities', ['as'=> 'admin.cities.store', 'uses' => 'CityController@store']);
    Route::get('admin/cities/create', ['as'=> 'admin.cities.create', 'uses' => 'CityController@create']);
    Route::put('admin/cities/{cities}', ['as'=> 'admin.cities.update', 'uses' => 'CityController@update']);
    Route::patch('admin/cities/{cities}', ['as'=> 'admin.cities.update', 'uses' => 'CityController@update']);
    Route::delete('admin/cities/{cities}', ['as'=> 'admin.cities.destroy', 'uses' => 'CityController@destroy']);
    Route::get('admin/cities/{cities}', ['as'=> 'admin.cities.show', 'uses' => 'CityController@show']);
    Route::get('admin/cities/{cities}/edit', ['as'=> 'admin.cities.edit', 'uses' => 'CityController@edit']);


    Route::get('admin/districts', ['as'=> 'admin.districts.index', 'uses' => 'DistrictController@index']);
    Route::post('admin/districts', ['as'=> 'admin.districts.store', 'uses' => 'DistrictController@store']);
    Route::get('admin/districts/create', ['as'=> 'admin.districts.create', 'uses' => 'DistrictController@create']);
    Route::put('admin/districts/{districts}', ['as'=> 'admin.districts.update', 'uses' => 'DistrictController@update']);
    Route::patch('admin/districts/{districts}', ['as'=> 'admin.districts.update', 'uses' => 'DistrictController@update']);
    Route::delete('admin/districts/{districts}', ['as'=> 'admin.districts.destroy', 'uses' => 'DistrictController@destroy']);
    Route::get('admin/districts/{districts}', ['as'=> 'admin.districts.show', 'uses' => 'DistrictController@show']);
    Route::get('admin/districts/{districts}/edit', ['as'=> 'admin.districts.edit', 'uses' => 'DistrictController@edit']);

    Route::get('admin/transactions', ['as'=> 'admin.transactions.index', 'uses' => 'TransactionController@index']);
    Route::post('admin/transactions', ['as'=> 'admin.transactions.store', 'uses' => 'TransactionController@store']);
    Route::get('admin/transactions/create', ['as'=> 'admin.transactions.create', 'uses' => 'TransactionController@create']);
    Route::put('admin/transactions/{transactions}', ['as'=> 'admin.transactions.update', 'uses' => 'TransactionController@update']);
    Route::patch('admin/transactions/{transactions}', ['as'=> 'admin.transactions.update', 'uses' => 'TransactionController@update']);
    Route::delete('admin/transactions/{transactions}', ['as'=> 'admin.transactions.destroy', 'uses' => 'TransactionController@destroy']);
    Route::get('admin/transactions/{transactions}', ['as'=> 'admin.transactions.show', 'uses' => 'TransactionController@show']);
    Route::get('admin/transactions/{transactions}/edit', ['as'=> 'admin.transactions.edit', 'uses' => 'TransactionController@edit']);


    Route::get('admin/coefficients', ['as'=> 'admin.coefficients.index', 'uses' => 'CoefficientController@index']);
    Route::post('admin/coefficients', ['as'=> 'admin.coefficients.store', 'uses' => 'CoefficientController@store']);
    Route::get('admin/coefficients/create', ['as'=> 'admin.coefficients.create', 'uses' => 'CoefficientController@create']);
    Route::put('admin/coefficients/{coefficients}', ['as'=> 'admin.coefficients.update', 'uses' => 'CoefficientController@update']);
    Route::patch('admin/coefficients/{coefficients}', ['as'=> 'admin.coefficients.update', 'uses' => 'CoefficientController@update']);
    Route::delete('admin/coefficients/{coefficients}', ['as'=> 'admin.coefficients.destroy', 'uses' => 'CoefficientController@destroy']);
    Route::get('admin/coefficients/{coefficients}', ['as'=> 'admin.coefficients.show', 'uses' => 'CoefficientController@show']);
    Route::get('admin/coefficients/{coefficients}/edit', ['as'=> 'admin.coefficients.edit', 'uses' => 'CoefficientController@edit']);
});