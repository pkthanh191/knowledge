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

Route::get('admin/category_docs', 'CategoryDocAPIController@index');
Route::post('admin/category_docs', 'CategoryDocAPIController@store');
Route::get('admin/category_docs/{category_docs}', 'CategoryDocAPIController@show');
Route::put('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::patch('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::delete('admin/category_docs{category_docs}', 'CategoryDocAPIController@destroy');

Route::get('admin/category_doc_metas', 'CategoryDocMetaAPIController@index');
Route::post('admin/category_doc_metas', 'CategoryDocMetaAPIController@store');
Route::get('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@show');
Route::put('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::patch('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::delete('admin/category_doc_metas{category_doc_metas}', 'CategoryDocMetaAPIController@destroy');

Route::get('admin/documents', 'DocumentAPIController@index');
Route::post('admin/documents', 'DocumentAPIController@store');
Route::get('admin/documents/{documents}', 'DocumentAPIController@show');
Route::put('admin/documents/{documents}', 'DocumentAPIController@update');
Route::patch('admin/documents/{documents}', 'DocumentAPIController@update');
Route::delete('admin/documents{documents}', 'DocumentAPIController@destroy');
Route::get('admin/documents/{documents}/comments', 'DocumentAPIController@getComments');

Route::get('admin/document_metas', 'DocumentMetaAPIController@index');
Route::post('admin/document_metas', 'DocumentMetaAPIController@store');
Route::get('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@show');
Route::put('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::patch('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::delete('admin/document_metas{document_metas}', 'DocumentMetaAPIController@destroy');

Route::get('admin/document_meta_values', 'DocumentMetaValueAPIController@index');
Route::post('admin/document_meta_values', 'DocumentMetaValueAPIController@store');
Route::get('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@show');
Route::put('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::patch('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::delete('admin/document_meta_values{document_meta_values}', 'DocumentMetaValueAPIController@destroy');

Route::get('admin/document_categories', 'DocumentCategoryAPIController@index');
Route::post('admin/document_categories', 'DocumentCategoryAPIController@store');
Route::get('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@show');
Route::put('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::patch('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::delete('admin/document_categories{document_categories}', 'DocumentCategoryAPIController@destroy');

Route::get('admin/comments', 'CommentAPIController@index');
Route::post('admin/comments', 'CommentAPIController@store');
Route::get('admin/comments/{comments}', 'CommentAPIController@show');
Route::put('admin/comments/{comments}', 'CommentAPIController@update');
Route::patch('admin/comments/{comments}', 'CommentAPIController@update');
Route::delete('admin/comments{comments}', 'CommentAPIController@destroy');

Route::get('admin/category_news', 'CategoryNewsAPIController@index');
Route::post('admin/category_news', 'CategoryNewsAPIController@store');
Route::get('admin/category_news/{category_news}', 'CategoryNewsAPIController@show');
Route::put('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::patch('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::delete('admin/category_news{category_news}', 'CategoryNewsAPIController@destroy');

Route::get('admin/news', 'NewsAPIController@index');
Route::post('admin/news', 'NewsAPIController@store');
Route::get('admin/news/{news}', 'NewsAPIController@show');
Route::put('admin/news/{news}', 'NewsAPIController@update');
Route::patch('admin/news/{news}', 'NewsAPIController@update');
Route::delete('admin/news{news}', 'NewsAPIController@destroy');
Route::get('admin/news/{news}/comments', 'NewsAPIController@getComments');
Route::get('admin/news/{news}/news', 'NewsAPIController@getNews');

Route::get('admin/news_categories', 'NewsCategoryAPIController@index');
Route::post('admin/news_categories', 'NewsCategoryAPIController@store');
Route::get('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@show');
Route::put('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::patch('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::delete('admin/news_categories{news_categories}', 'NewsCategoryAPIController@destroy');

Route::get('admin/category_tests', 'CategoryTestAPIController@index');
Route::post('admin/category_tests', 'CategoryTestAPIController@store');
Route::get('admin/category_tests/{category_tests}', 'CategoryTestAPIController@show');
Route::put('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::patch('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::delete('admin/category_tests{category_tests}', 'CategoryTestAPIController@destroy');

Route::get('admin/tests', 'TestAPIController@index');
Route::post('admin/tests', 'TestAPIController@store');
Route::get('admin/tests/{tests}', 'TestAPIController@show');
Route::put('admin/tests/{tests}', 'TestAPIController@update');
Route::patch('admin/tests/{tests}', 'TestAPIController@update');
Route::delete('admin/tests{tests}', 'TestAPIController@destroy');
Route::get('admin/tests/{tests}/comments', 'TestAPIController@getComments');

Route::get('admin/test_categories', 'TestCategoryAPIController@index');
Route::post('admin/test_categories', 'TestCategoryAPIController@store');
Route::get('admin/test_categories/{test_categories}', 'TestCategoryAPIController@show');
Route::put('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::patch('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::delete('admin/test_categories{test_categories}', 'TestCategoryAPIController@destroy');

Route::get('admin/centers', 'CenterAPIController@index');
Route::post('admin/centers', 'CenterAPIController@store');
Route::get('admin/centers/{centers}', 'CenterAPIController@show');
Route::put('admin/centers/{centers}', 'CenterAPIController@update');
Route::patch('admin/centers/{centers}', 'CenterAPIController@update');
Route::delete('admin/centers{centers}', 'CenterAPIController@destroy');
Route::get('admin/centers/{centers}/teachers', 'CenterAPIController@getTeachers');

Route::get('admin/teachers', 'TeacherAPIController@index');
Route::post('admin/teachers', 'TeacherAPIController@store');
Route::get('admin/teachers/{teachers}', 'TeacherAPIController@show');
Route::put('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::patch('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::delete('admin/teachers{teachers}', 'TeacherAPIController@destroy');
Route::get('admin/teachers/free/center', 'TeacherAPIController@teacherFree');

Route::get('admin/category_courses', 'CategoryCourseAPIController@index');
Route::post('admin/category_courses', 'CategoryCourseAPIController@store');
Route::get('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@show');
Route::put('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::patch('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::delete('admin/category_courses{category_courses}', 'CategoryCourseAPIController@destroy');

Route::get('admin/courses', 'CourseAPIController@index');
Route::post('admin/courses', 'CourseAPIController@store');
Route::get('admin/courses/{courses}', 'CourseAPIController@show');
Route::put('admin/courses/{courses}', 'CourseAPIController@update');
Route::patch('admin/courses/{courses}', 'CourseAPIController@update');
Route::delete('admin/courses{courses}', 'CourseAPIController@destroy');

Route::get('admin/course_categories', 'CourseCategoryAPIController@index');
Route::post('admin/course_categories', 'CourseCategoryAPIController@store');
Route::get('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@show');
Route::put('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::patch('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::delete('admin/course_categories{course_categories}', 'CourseCategoryAPIController@destroy');

Route::get('admin/course_orders', 'CourseOrderAPIController@index');
Route::post('admin/course_orders', 'CourseOrderAPIController@store');
Route::get('admin/course_orders/{course_orders}', 'CourseOrderAPIController@show');
Route::put('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::patch('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::delete('admin/course_orders{course_orders}', 'CourseOrderAPIController@destroy');

































Route::get('admin/category_docs', 'CategoryDocAPIController@index');
Route::post('admin/category_docs', 'CategoryDocAPIController@store');
Route::get('admin/category_docs/{category_docs}', 'CategoryDocAPIController@show');
Route::put('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::patch('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::delete('admin/category_docs{category_docs}', 'CategoryDocAPIController@destroy');

Route::get('admin/category_doc_metas', 'CategoryDocMetaAPIController@index');
Route::post('admin/category_doc_metas', 'CategoryDocMetaAPIController@store');
Route::get('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@show');
Route::put('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::patch('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::delete('admin/category_doc_metas{category_doc_metas}', 'CategoryDocMetaAPIController@destroy');

Route::get('admin/documents', 'DocumentAPIController@index');
Route::post('admin/documents', 'DocumentAPIController@store');
Route::get('admin/documents/{documents}', 'DocumentAPIController@show');
Route::put('admin/documents/{documents}', 'DocumentAPIController@update');
Route::patch('admin/documents/{documents}', 'DocumentAPIController@update');
Route::delete('admin/documents{documents}', 'DocumentAPIController@destroy');
Route::get('admin/documents/{documents}/comments', 'DocumentAPIController@getComments');
Route::get('admin/documents/{documents}/documents', 'DocumentAPIController@getDocuments');

Route::get('admin/document_metas', 'DocumentMetaAPIController@index');
Route::post('admin/document_metas', 'DocumentMetaAPIController@store');
Route::get('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@show');
Route::put('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::patch('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::delete('admin/document_metas{document_metas}', 'DocumentMetaAPIController@destroy');

Route::get('admin/document_meta_values', 'DocumentMetaValueAPIController@index');
Route::post('admin/document_meta_values', 'DocumentMetaValueAPIController@store');
Route::get('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@show');
Route::put('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::patch('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::delete('admin/document_meta_values{document_meta_values}', 'DocumentMetaValueAPIController@destroy');

Route::get('admin/document_categories', 'DocumentCategoryAPIController@index');
Route::post('admin/document_categories', 'DocumentCategoryAPIController@store');
Route::get('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@show');
Route::put('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::patch('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::delete('admin/document_categories{document_categories}', 'DocumentCategoryAPIController@destroy');

Route::get('admin/comments', 'CommentAPIController@index');
Route::post('admin/comments', 'CommentAPIController@store');
Route::get('admin/comments/{comments}', 'CommentAPIController@show');
Route::put('admin/comments/{comments}', 'CommentAPIController@update');
Route::patch('admin/comments/{comments}', 'CommentAPIController@update');
Route::delete('admin/comments{comments}', 'CommentAPIController@destroy');

Route::get('admin/category_news', 'CategoryNewsAPIController@index');
Route::post('admin/category_news', 'CategoryNewsAPIController@store');
Route::get('admin/category_news/{category_news}', 'CategoryNewsAPIController@show');
Route::put('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::patch('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::delete('admin/category_news{category_news}', 'CategoryNewsAPIController@destroy');

Route::get('admin/news', 'NewsAPIController@index');
Route::post('admin/news', 'NewsAPIController@store');
Route::get('admin/news/{news}', 'NewsAPIController@show');
Route::put('admin/news/{news}', 'NewsAPIController@update');
Route::patch('admin/news/{news}', 'NewsAPIController@update');
Route::delete('admin/news{news}', 'NewsAPIController@destroy');

Route::get('admin/news_categories', 'NewsCategoryAPIController@index');
Route::post('admin/news_categories', 'NewsCategoryAPIController@store');
Route::get('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@show');
Route::put('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::patch('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::delete('admin/news_categories{news_categories}', 'NewsCategoryAPIController@destroy');

Route::get('admin/category_tests', 'CategoryTestAPIController@index');
Route::post('admin/category_tests', 'CategoryTestAPIController@store');
Route::get('admin/category_tests/{category_tests}', 'CategoryTestAPIController@show');
Route::put('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::patch('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::delete('admin/category_tests{category_tests}', 'CategoryTestAPIController@destroy');

Route::get('admin/tests', 'TestAPIController@index');
Route::post('admin/tests', 'TestAPIController@store');
Route::get('admin/tests/{tests}', 'TestAPIController@show');
Route::put('admin/tests/{tests}', 'TestAPIController@update');
Route::patch('admin/tests/{tests}', 'TestAPIController@update');
Route::delete('admin/tests{tests}', 'TestAPIController@destroy');
Route::get('admin/tests/{tests}/comments', 'TestAPIController@getComments');

Route::get('admin/test_categories', 'TestCategoryAPIController@index');
Route::post('admin/test_categories', 'TestCategoryAPIController@store');
Route::get('admin/test_categories/{test_categories}', 'TestCategoryAPIController@show');
Route::put('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::patch('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::delete('admin/test_categories{test_categories}', 'TestCategoryAPIController@destroy');

Route::get('admin/centers', 'CenterAPIController@index');
Route::post('admin/centers', 'CenterAPIController@store');
Route::get('admin/centers/{centers}', 'CenterAPIController@show');
Route::put('admin/centers/{centers}', 'CenterAPIController@update');
Route::patch('admin/centers/{centers}', 'CenterAPIController@update');
Route::delete('admin/centers{centers}', 'CenterAPIController@destroy');

Route::get('admin/teachers', 'TeacherAPIController@index');
Route::post('admin/teachers', 'TeacherAPIController@store');
Route::get('admin/teachers/{teachers}', 'TeacherAPIController@show');
Route::put('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::patch('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::delete('admin/teachers{teachers}', 'TeacherAPIController@destroy');

Route::get('admin/category_courses', 'CategoryCourseAPIController@index');
Route::post('admin/category_courses', 'CategoryCourseAPIController@store');
Route::get('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@show');
Route::put('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::patch('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::delete('admin/category_courses{category_courses}', 'CategoryCourseAPIController@destroy');

Route::get('admin/courses', 'CourseAPIController@index');
Route::post('admin/courses', 'CourseAPIController@store');
Route::get('admin/courses/{courses}', 'CourseAPIController@show');
Route::put('admin/courses/{courses}', 'CourseAPIController@update');
Route::patch('admin/courses/{courses}', 'CourseAPIController@update');
Route::delete('admin/courses{courses}', 'CourseAPIController@destroy');

Route::get('admin/course_categories', 'CourseCategoryAPIController@index');
Route::post('admin/course_categories', 'CourseCategoryAPIController@store');
Route::get('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@show');
Route::put('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::patch('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::delete('admin/course_categories{course_categories}', 'CourseCategoryAPIController@destroy');

Route::get('admin/course_orders', 'CourseOrderAPIController@index');
Route::post('admin/course_orders', 'CourseOrderAPIController@store');
Route::get('admin/course_orders/{course_orders}', 'CourseOrderAPIController@show');
Route::put('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::patch('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::delete('admin/course_orders{course_orders}', 'CourseOrderAPIController@destroy');

Route::get('admin/category_docs', 'CategoryDocAPIController@index');
Route::post('admin/category_docs', 'CategoryDocAPIController@store');
Route::get('admin/category_docs/{category_docs}', 'CategoryDocAPIController@show');
Route::put('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::patch('admin/category_docs/{category_docs}', 'CategoryDocAPIController@update');
Route::delete('admin/category_docs{category_docs}', 'CategoryDocAPIController@destroy');

Route::get('admin/category_doc_metas', 'CategoryDocMetaAPIController@index');
Route::post('admin/category_doc_metas', 'CategoryDocMetaAPIController@store');
Route::get('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@show');
Route::put('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::patch('admin/category_doc_metas/{category_doc_metas}', 'CategoryDocMetaAPIController@update');
Route::delete('admin/category_doc_metas{category_doc_metas}', 'CategoryDocMetaAPIController@destroy');

Route::get('admin/documents', 'DocumentAPIController@index');
Route::post('admin/documents', 'DocumentAPIController@store');
Route::get('admin/documents/{documents}', 'DocumentAPIController@show');
Route::put('admin/documents/{documents}', 'DocumentAPIController@update');
Route::patch('admin/documents/{documents}', 'DocumentAPIController@update');
Route::delete('admin/documents{documents}', 'DocumentAPIController@destroy');
Route::get('admin/documents/{documents}/comments', 'DocumentAPIController@getComments');

Route::get('admin/document_metas', 'DocumentMetaAPIController@index');
Route::post('admin/document_metas', 'DocumentMetaAPIController@store');
Route::get('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@show');
Route::put('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::patch('admin/document_metas/{document_metas}', 'DocumentMetaAPIController@update');
Route::delete('admin/document_metas{document_metas}', 'DocumentMetaAPIController@destroy');
Route::get('admin/document_metas/getByCateId/{id}', 'DocumentMetaAPIController@getDocumentMeta');

Route::get('admin/document_meta_values', 'DocumentMetaValueAPIController@index');
Route::post('admin/document_meta_values', 'DocumentMetaValueAPIController@store');
Route::get('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@show');
Route::put('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::patch('admin/document_meta_values/{document_meta_values}', 'DocumentMetaValueAPIController@update');
Route::delete('admin/document_meta_values{document_meta_values}', 'DocumentMetaValueAPIController@destroy');

Route::get('admin/document_categories', 'DocumentCategoryAPIController@index');
Route::post('admin/document_categories', 'DocumentCategoryAPIController@store');
Route::get('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@show');
Route::put('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::patch('admin/document_categories/{document_categories}', 'DocumentCategoryAPIController@update');
Route::delete('admin/document_categories{document_categories}', 'DocumentCategoryAPIController@destroy');

Route::get('admin/comments', 'CommentAPIController@index');
Route::post('admin/comments', 'CommentAPIController@store');
Route::get('admin/comments/{comments}', 'CommentAPIController@show');
Route::put('admin/comments/{comments}', 'CommentAPIController@update');
Route::patch('admin/comments/{comments}', 'CommentAPIController@update');
Route::delete('admin/comments{comments}', 'CommentAPIController@destroy');

Route::get('admin/category_news', 'CategoryNewsAPIController@index');
Route::post('admin/category_news', 'CategoryNewsAPIController@store');
Route::get('admin/category_news/{category_news}', 'CategoryNewsAPIController@show');
Route::put('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::patch('admin/category_news/{category_news}', 'CategoryNewsAPIController@update');
Route::delete('admin/category_news{category_news}', 'CategoryNewsAPIController@destroy');

Route::get('admin/news', 'NewsAPIController@index');
Route::post('admin/news', 'NewsAPIController@store');
Route::get('admin/news/{news}', 'NewsAPIController@show');
Route::put('admin/news/{news}', 'NewsAPIController@update');
Route::patch('admin/news/{news}', 'NewsAPIController@update');
Route::delete('admin/news{news}', 'NewsAPIController@destroy');

Route::get('admin/news_categories', 'NewsCategoryAPIController@index');
Route::post('admin/news_categories', 'NewsCategoryAPIController@store');
Route::get('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@show');
Route::put('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::patch('admin/news_categories/{news_categories}', 'NewsCategoryAPIController@update');
Route::delete('admin/news_categories{news_categories}', 'NewsCategoryAPIController@destroy');

Route::get('admin/category_tests', 'CategoryTestAPIController@index');
Route::post('admin/category_tests', 'CategoryTestAPIController@store');
Route::get('admin/category_tests/{category_tests}', 'CategoryTestAPIController@show');
Route::put('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::patch('admin/category_tests/{category_tests}', 'CategoryTestAPIController@update');
Route::delete('admin/category_tests{category_tests}', 'CategoryTestAPIController@destroy');

Route::get('admin/tests', 'TestAPIController@index');
Route::post('admin/tests', 'TestAPIController@store');
Route::get('admin/tests/{tests}', 'TestAPIController@show');
Route::put('admin/tests/{tests}', 'TestAPIController@update');
Route::patch('admin/tests/{tests}', 'TestAPIController@update');
Route::delete('admin/tests{tests}', 'TestAPIController@destroy');
Route::get('admin/tests/{tests}/comments', 'TestAPIController@getComments');
Route::get('admin/tests/{tests}/tests', 'TestAPIController@getTests');

Route::get('admin/test_categories', 'TestCategoryAPIController@index');
Route::post('admin/test_categories', 'TestCategoryAPIController@store');
Route::get('admin/test_categories/{test_categories}', 'TestCategoryAPIController@show');
Route::put('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::patch('admin/test_categories/{test_categories}', 'TestCategoryAPIController@update');
Route::delete('admin/test_categories{test_categories}', 'TestCategoryAPIController@destroy');

Route::get('admin/centers', 'CenterAPIController@index');
Route::post('admin/centers', 'CenterAPIController@store');
Route::get('admin/centers/{centers}', 'CenterAPIController@show');
Route::put('admin/centers/{centers}', 'CenterAPIController@update');
Route::patch('admin/centers/{centers}', 'CenterAPIController@update');
Route::delete('admin/centers{centers}', 'CenterAPIController@destroy');

Route::get('admin/teachers', 'TeacherAPIController@index');
Route::post('admin/teachers', 'TeacherAPIController@store');
Route::get('admin/teachers/{teachers}', 'TeacherAPIController@show');
Route::put('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::patch('admin/teachers/{teachers}', 'TeacherAPIController@update');
Route::delete('admin/teachers{teachers}', 'TeacherAPIController@destroy');

Route::get('admin/category_courses', 'CategoryCourseAPIController@index');
Route::post('admin/category_courses', 'CategoryCourseAPIController@store');
Route::get('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@show');
Route::put('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::patch('admin/category_courses/{category_courses}', 'CategoryCourseAPIController@update');
Route::delete('admin/category_courses{category_courses}', 'CategoryCourseAPIController@destroy');







Route::get('admin/courses', 'CourseAPIController@index');
Route::post('admin/courses', 'CourseAPIController@store');
Route::get('admin/courses/{courses}', 'CourseAPIController@show');
Route::put('admin/courses/{courses}', 'CourseAPIController@update');
Route::patch('admin/courses/{courses}', 'CourseAPIController@update');
Route::delete('admin/courses{courses}', 'CourseAPIController@destroy');

Route::get('admin/course_categories', 'CourseCategoryAPIController@index');
Route::post('admin/course_categories', 'CourseCategoryAPIController@store');
Route::get('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@show');
Route::put('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::patch('admin/course_categories/{course_categories}', 'CourseCategoryAPIController@update');
Route::delete('admin/course_categories{course_categories}', 'CourseCategoryAPIController@destroy');

Route::get('admin/course_orders', 'CourseOrderAPIController@index');
Route::post('admin/course_orders', 'CourseOrderAPIController@store');
Route::get('admin/course_orders/{course_orders}', 'CourseOrderAPIController@show');
Route::put('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::patch('admin/course_orders/{course_orders}', 'CourseOrderAPIController@update');
Route::delete('admin/course_orders{course_orders}', 'CourseOrderAPIController@destroy');

Route::get('admin/comment_tests', 'CommentTestAPIController@index');
Route::post('admin/comment_tests', 'CommentTestAPIController@store');
Route::get('admin/comment_tests/{comment_tests}', 'CommentTestAPIController@show');
Route::put('admin/comment_tests/{comment_tests}', 'CommentTestAPIController@update');
Route::patch('admin/comment_tests/{comment_tests}', 'CommentTestAPIController@update');
Route::delete('admin/comment_tests{comment_tests}', 'CommentTestAPIController@destroy');

Route::get('admin/users', 'UserAPIController@index');
Route::post('admin/users', 'UserAPIController@store');
Route::get('admin/users/{users}', 'UserAPIController@show');
Route::put('admin/users/{users}', 'UserAPIController@update');
Route::patch('admin/users/{users}', 'UserAPIController@update');
Route::delete('admin/users{users}', 'UserAPIController@destroy');


Route::get('admin/pages', 'PageAPIController@index');
Route::post('admin/pages', 'PageAPIController@store');
Route::get('admin/pages/{pages}', 'PageAPIController@show');
Route::put('admin/pages/{pages}', 'PageAPIController@update');
Route::patch('admin/pages/{pages}', 'PageAPIController@update');
Route::delete('admin/pages{pages}', 'PageAPIController@destroy');

Route::get('admin/banners', 'BannerAPIController@index');
Route::post('admin/banners', 'BannerAPIController@store');
Route::get('admin/banners/{banners}', 'BannerAPIController@show');
Route::put('admin/banners/{banners}', 'BannerAPIController@update');
Route::patch('admin/banners/{banners}', 'BannerAPIController@update');
Route::delete('admin/banners{banners}', 'BannerAPIController@destroy');

Route::get('admin/comment_news', 'CommentNewsAPIController@index');
Route::post('admin/comment_news', 'CommentNewsAPIController@store');
Route::get('admin/comment_news/{comment_news}', 'CommentNewsAPIController@show');
Route::put('admin/comment_news/{comment_news}', 'CommentNewsAPIController@update');
Route::patch('admin/comment_news/{comment_news}', 'CommentNewsAPIController@update');
Route::delete('admin/comment_news{comment_news}', 'CommentNewsAPIController@destroy');

Route::get('admin/subjects', 'SubjectAPIController@index');
Route::post('admin/subjects', 'SubjectAPIController@store');
Route::get('admin/subjects/{subjects}', 'SubjectAPIController@show');
Route::put('admin/subjects/{subjects}', 'SubjectAPIController@update');
Route::patch('admin/subjects/{subjects}', 'SubjectAPIController@update');
Route::delete('admin/subjects{subjects}', 'SubjectAPIController@destroy');

Route::get('admin/grades', 'GradeAPIController@index');
Route::post('admin/grades', 'GradeAPIController@store');
Route::get('admin/grades/{grades}', 'GradeAPIController@show');
Route::put('admin/grades/{grades}', 'GradeAPIController@update');
Route::patch('admin/grades/{grades}', 'GradeAPIController@update');
Route::delete('admin/grades{grades}', 'GradeAPIController@destroy');















Route::get('admin/tutorials', 'TutorialAPIController@index');
Route::post('admin/tutorials', 'TutorialAPIController@store');
Route::get('admin/tutorials/{tutorials}', 'TutorialAPIController@show');
Route::put('admin/tutorials/{tutorials}', 'TutorialAPIController@update');
Route::patch('admin/tutorials/{tutorials}', 'TutorialAPIController@update');
Route::delete('admin/tutorials{tutorials}', 'TutorialAPIController@destroy');
Route::patch('admin/tutorials/{tutorials}/updateActive', 'TutorialAPIController@updateActive');
Route::patch('admin/tutorials/update/ActiveAll', 'TutorialAPIController@updateActiveAll');
Route::patch('admin/tutorials/{tutorials}/updateConfirm', 'TutorialAPIController@updateConfirm');
Route::patch('admin/tutorials/update/ConfirmAll', 'TutorialAPIController@updateConfirmAll');

Route::get('admin/subject_tutorials', 'SubjectTutorialAPIController@index');
Route::post('admin/subject_tutorials', 'SubjectTutorialAPIController@store');
Route::get('admin/subject_tutorials/{subject_tutorials}', 'SubjectTutorialAPIController@show');
Route::put('admin/subject_tutorials/{subject_tutorials}', 'SubjectTutorialAPIController@update');
Route::patch('admin/subject_tutorials/{subject_tutorials}', 'SubjectTutorialAPIController@update');
Route::delete('admin/subject_tutorials{subject_tutorials}', 'SubjectTutorialAPIController@destroy');

Route::get('admin/grade_tutorials', 'GradeTutorialAPIController@index');
Route::post('admin/grade_tutorials', 'GradeTutorialAPIController@store');
Route::get('admin/grade_tutorials/{grade_tutorials}', 'GradeTutorialAPIController@show');
Route::put('admin/grade_tutorials/{grade_tutorials}', 'GradeTutorialAPIController@update');
Route::patch('admin/grade_tutorials/{grade_tutorials}', 'GradeTutorialAPIController@update');
Route::delete('admin/grade_tutorials{grade_tutorials}', 'GradeTutorialAPIController@destroy');

Route::get('admin/cities', 'CityAPIController@index');
Route::post('admin/cities', 'CityAPIController@store');
Route::get('admin/cities/{cities}', 'CityAPIController@show');
Route::put('admin/cities/{cities}', 'CityAPIController@update');
Route::patch('admin/cities/{cities}', 'CityAPIController@update');
Route::delete('admin/cities{cities}', 'CityAPIController@destroy');

Route::get('admin/districts', 'DistrictAPIController@index');
Route::post('admin/districts', 'DistrictAPIController@store');
Route::get('admin/districts/{districts}', 'DistrictAPIController@show');
Route::put('admin/districts/{districts}', 'DistrictAPIController@update');
Route::patch('admin/districts/{districts}', 'DistrictAPIController@update');
Route::delete('admin/districts{districts}', 'DistrictAPIController@destroy');
Route::get('admin/districts_by_code_city/{city_code}', 'DistrictAPIController@getDictrictByCityCode');

Route::get('admin/transactions', 'TransactionAPIController@index');
Route::post('admin/transactions', 'TransactionAPIController@store');
Route::get('admin/transactions/{transactions}', 'TransactionAPIController@show');
Route::put('admin/transactions/{transactions}', 'TransactionAPIController@update');
Route::patch('admin/transactions/{transactions}', 'TransactionAPIController@update');
Route::delete('admin/transactions{transactions}', 'TransactionAPIController@destroy');

Route::get('admin/coefficients', 'CoefficientAPIController@index');
Route::post('admin/coefficients', 'CoefficientAPIController@store');
Route::get('admin/coefficients/{coefficients}', 'CoefficientAPIController@show');
Route::put('admin/coefficients/{coefficients}', 'CoefficientAPIController@update');
Route::patch('admin/coefficients/{coefficients}', 'CoefficientAPIController@update');
Route::delete('admin/coefficients{coefficients}', 'CoefficientAPIController@destroy');