<?php
/**
 * Created by PhpStorm.
 * User: BLOOMGOO.VN
 * Date: 08/06/2017
 * Time: 12:03 PM
 */

Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(__('messages.home'), route('home'));
});

Breadcrumbs::register('admin.dashboard.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.dashboard'), route('admin.dashboard.index'));
});

# START Documents
Breadcrumbs::register('admin.documents.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.document'), route('admin.documents.index'));
});
Breadcrumbs::register('admin.documents.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.documents.index');
    $breadcrumbs->push(__('messages.create'), route('admin.documents.create'));
});

Breadcrumbs::register('admin.documents.show', function($breadcrumbs, $document)
{
    $breadcrumbs->parent('admin.documents.index');
    $breadcrumbs->push(__('messages.show'), route('admin.documents.show', $document->id));
});

Breadcrumbs::register('admin.documents.edit', function($breadcrumbs, $document) {
    $breadcrumbs->parent('admin.documents.index');
    $breadcrumbs->push(__('messages.edit'), route('admin.documents.edit', $document->id));
});

Breadcrumbs::register('admin.documents.import', function($breadcrumbs) {
    $breadcrumbs->parent('admin.documents.index');
    $breadcrumbs->push(__('messages.import'), route('admin.documents.import'));
});
# END Documents

# START categoryDocMetas
Breadcrumbs::register('admin.categoryDocMetas.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push('Danh mục loại tài liệu', route('admin.categoryDocMetas.index'));
});

Breadcrumbs::register('admin.categoryDocMetas.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.categoryDocMetas.index');
    $breadcrumbs->push('Thêm mới', route('admin.categoryDocMetas.create'));
});

Breadcrumbs::register('admin.categoryDocMetas.show', function($breadcrumbs, $categoryDocMeta)
{
    $breadcrumbs->parent('admin.categoryDocMetas.index');
    $breadcrumbs->push('Chi tiết', route('admin.categoryDocMetas.show', $categoryDocMeta->id));
});

Breadcrumbs::register('admin.categoryDocMetas.edit', function($breadcrumbs, $categoryDocMeta)
{
    $breadcrumbs->parent('admin.categoryDocMetas.index');
    $breadcrumbs->push('Chỉnh sửa', route('admin.categoryDocMetas.edit', $categoryDocMeta->id));
});

# END categoryDocMetas

# START documentMetas
Breadcrumbs::register('admin.documentMetas.index', function($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push('Cấu hình loại Tài liệu', route('admin.documentMetas.index'));
});


Breadcrumbs::register('admin.documentMetas.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.documentMetas.index');
    $breadcrumbs->push('Thêm mới', route('admin.documentMetas.create'));
});

Breadcrumbs::register('admin.documentMetas.show', function($breadcrumbs, $documentMeta)
{
    $breadcrumbs->parent('admin.documentMetas.index');
    $breadcrumbs->push('Chi tiết', route('admin.documentMetas.show', $documentMeta->id));
});

Breadcrumbs::register('admin.documentMetas.edit', function($breadcrumbs, $documentMeta)
{
    $breadcrumbs->parent('admin.documentMetas.index');
    $breadcrumbs->push('Chỉnh sửa', route('admin.documentMetas.edit', $documentMeta->id));
});

# END documentMetas

#START categoryDocs
Breadcrumbs::register('admin.categoryDocs.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.category_docs'), route('admin.categoryDocs.index'));
});

Breadcrumbs::register('admin.categoryDocs.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.categoryDocs.index');
    $breadcrumbs->push(__('messages.create'), route('admin.categoryDocs.create'));
});

Breadcrumbs::register('admin.categoryDocs.edit', function($breadcrumbs, $categoryDoc)
{
    $breadcrumbs->parent('admin.categoryDocs.index');
    $breadcrumbs->push(__('messages.update'), route('admin.categoryDocs.edit', $categoryDoc->id));
});

Breadcrumbs::register('admin.categoryDocs.show', function($breadcrumbs, $categoryDoc)
{
    $breadcrumbs->parent('admin.categoryDocs.index');
    $breadcrumbs->push(__('messages.show'), route('admin.categoryDocs.show', $categoryDoc->id));
});
#END categoryDocs

Breadcrumbs::register('admin.teachers.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.teachers'), route('admin.teachers.index'));
});

Breadcrumbs::register('admin.teachers.show', function($breadcrumbs, $teacher)
{
    $breadcrumbs->parent('admin.teachers.index');
    $breadcrumbs->push(__('messages.show'), route('admin.teachers.index', $teacher->id));
});

Breadcrumbs::register('admin.teachers.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.teachers.index');
    $breadcrumbs->push(__('messages.create'), route('admin.teachers.create'));
});

Breadcrumbs::register('admin.teachers.edit', function($breadcrumbs, $teacher)
{
    $breadcrumbs->parent('admin.teachers.index');
    $breadcrumbs->push(__('messages.update'), route('admin.teachers.edit', $teacher->id));
});

Breadcrumbs::register('admin.courses.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push('Khóa học', route('admin.courses.index'));
});

Breadcrumbs::register('admin.courses.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.courses.index');
    $breadcrumbs->push('Thêm mới', route('admin.courses.create'));
});

Breadcrumbs::register('admin.courses.show', function($breadcrumbs, $course)
{
    $breadcrumbs->parent('admin.courses.index');
    $breadcrumbs->push('Chi tiết', route('admin.courses.index', $course->id));
});

Breadcrumbs::register('admin.courses.edit', function($breadcrumbs, $course)
{
    $breadcrumbs->parent('admin.courses.index');
    $breadcrumbs->push('Chỉnh sửa', route('admin.courses.edit', $course->id));
});

// Breadcrumbs Category Test
Breadcrumbs::register('admin.categoryTests.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.category_test'), route('admin.categoryTests.index'));
});

Breadcrumbs::register('admin.categoryTests.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.categoryTests.index');
    $breadcrumbs->push(__('messages.create'), route('admin.categoryTests.create'));
});

Breadcrumbs::register('admin.categoryTests.show', function($breadcrumbs, $categoryTest)
{
    $breadcrumbs->parent('admin.categoryTests.index');
    $breadcrumbs->push(__('messages.info'), route('admin.categoryTests.index', $categoryTest->id));
});

Breadcrumbs::register('admin.categoryTests.edit', function($breadcrumbs, $categoryTest)
{
    $breadcrumbs->parent('admin.categoryTests.index');
    $breadcrumbs->push(__('messages.update'), route('admin.categoryTests.edit', $categoryTest->id));
});
// Breadcrumbs Test
Breadcrumbs::register('admin.tests.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.test'), route('admin.tests.index'));
});

Breadcrumbs::register('admin.tests.show', function($breadcrumbs, $test)
{
    $breadcrumbs->parent('admin.tests.index');
    $breadcrumbs->push(__('messages.info'), route('admin.tests.index', $test->id));
});

Breadcrumbs::register('admin.tests.edit', function($breadcrumbs, $test)
{
    $breadcrumbs->parent('admin.tests.index');
    $breadcrumbs->push(__('messages.update'), route('admin.tests.edit', $test->id));
});


Breadcrumbs::register('admin.tests.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.tests.index');
    $breadcrumbs->push(__('messages.create'), route('admin.tests.create'));
});

Breadcrumbs::register('admin.tests.import', function($breadcrumbs) {
    $breadcrumbs->parent('admin.tests.index');
    $breadcrumbs->push(__('messages.import'), route('admin.tests.import'));
});


Breadcrumbs::register('admin.categoryNews.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.category_news'), route('admin.categoryNews.index'));
});

Breadcrumbs::register('admin.categoryNews.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.categoryNews.index');
    $breadcrumbs->push(__('messages.create'), route('admin.categoryNews.create'));
});

Breadcrumbs::register('admin.categoryNews.edit', function($breadcrumbs, $categoryNews)
{
    $breadcrumbs->parent('admin.categoryNews.index');
    $breadcrumbs->push(__('messages.update'), route('admin.categoryNews.edit', $categoryNews->id));
});

Breadcrumbs::register('admin.categoryNews.show', function($breadcrumbs, $categoryNews)
{
    $breadcrumbs->parent('admin.categoryNews.index');
    $breadcrumbs->push(__('messages.show'), route('admin.categoryNews.show', $categoryNews->id));
});


/** Couser_Category **/
Breadcrumbs::register('admin.categoryCourses.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.category_courses'), route('admin.categoryCourses.index'));
});

Breadcrumbs::register('admin.categoryCourses.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.categoryCourses.index');
    $breadcrumbs->push(__('messages.create'), route('admin.categoryCourses.create'));
});

Breadcrumbs::register('admin.categoryCourses.edit', function($breadcrumbs, $categoryCourses)
{
    $breadcrumbs->parent('admin.categoryCourses.index');
    $breadcrumbs->push(__('messages.update'), route('admin.categoryCourses.edit', $categoryCourses->id));
});

Breadcrumbs::register('admin.categoryCourses.show', function($breadcrumbs, $categoryCourses)
{
    $breadcrumbs->parent('admin.categoryCourses.index');
    $breadcrumbs->push(__('messages.show'), route('admin.categoryCourses.show', $categoryCourses->id));
});



Breadcrumbs::register('admin.news.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.news'), route('admin.news.index'));
});

Breadcrumbs::register('admin.news.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(__('messages.create'), route('admin.news.create'));
});

Breadcrumbs::register('admin.news.edit', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(__('messages.update'), route('admin.news.edit', $news->id));
});

Breadcrumbs::register('admin.news.show', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(__('messages.show'), route('admin.news.show', $news->id));
});


// Breadcrumbs Centers

Breadcrumbs::register('admin.centers.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.center'), route('admin.centers.index'));
});

Breadcrumbs::register('admin.centers.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.centers.index');
    $breadcrumbs->push(__('messages.create'), route('admin.centers.create'));
});

Breadcrumbs::register('admin.centers.edit', function($breadcrumbs, $center)
{
    $breadcrumbs->parent('admin.centers.index');
    $breadcrumbs->push(__('messages.update'), route('admin.centers.edit', $center->id));
});

Breadcrumbs::register('admin.centers.show', function($breadcrumbs, $center)
{
    $breadcrumbs->parent('admin.centers.index');
    $breadcrumbs->push(__('messages.show'), route('admin.centers.show', $center->id));
});

//End breadcrumbs Centers


# START comments
Breadcrumbs::register('admin.comments.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.comments'), route('admin.comments.index'));
});

Breadcrumbs::register('admin.comments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.comments.index');
    $breadcrumbs->push(__('messages.create'), route('admin.comments.create'));
});

Breadcrumbs::register('admin.comments.show', function($breadcrumbs, $comment)
{
    $breadcrumbs->parent('admin.comments.index');
    $breadcrumbs->push(__('messages.show'), route('admin.comments.show', $comment->id));
});

Breadcrumbs::register('admin.comments.edit', function($breadcrumbs, $comment)
{
    $breadcrumbs->parent('admin.comments.index');
    $breadcrumbs->push(__('messages.update'), route('admin.comments.edit', $comment->id));
});
# END comments


# START comment_tests
Breadcrumbs::register('admin.commentTests.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.comment_tests_title'), route('admin.commentTests.index'));
});

Breadcrumbs::register('admin.commentTests.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.commentTests.index');
    $breadcrumbs->push(__('messages.create'), route('admin.commentTests.create'));
});

Breadcrumbs::register('admin.commentTests.show', function($breadcrumbs, $comment_test)
{
    $breadcrumbs->parent('admin.commentTests.index');
    $breadcrumbs->push(__('messages.show'), route('admin.commentTests.show', $comment_test->id));
});

Breadcrumbs::register('admin.commentTests.edit', function($breadcrumbs, $comment_test)
{
    $breadcrumbs->parent('admin.commentTests.index');
    $breadcrumbs->push(__('messages.update'), route('admin.commentTests.edit', $comment_test->id));
});
# END comment_tests

# START comment_news
Breadcrumbs::register('admin.commentNews.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.comment_news'), route('admin.commentNews.index'));
});

Breadcrumbs::register('admin.commentNews.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.commentNews.index');
    $breadcrumbs->push(__('messages.create'), route('admin.commentNews.create'));
});

Breadcrumbs::register('admin.commentNews.show', function($breadcrumbs, $comment_news)
{
    $breadcrumbs->parent('admin.commentNews.index');
    $breadcrumbs->push(__('messages.show'), route('admin.commentNews.show', $comment_news->id));
});

Breadcrumbs::register('admin.commentNews.edit', function($breadcrumbs, $comment_news)
{
    $breadcrumbs->parent('admin.commentNews.index');
    $breadcrumbs->push(__('messages.update'), route('admin.commentNews.edit', $comment_news->id));
});
# END comment_news

# START User
Breadcrumbs::register('admin.users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.users'), route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push(__('messages.create'), route('admin.users.create'));
});

Breadcrumbs::register('admin.users.show', function($breadcrumbs, $comment)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push(__('messages.show'), route('admin.users.show', $comment->id));
});

Breadcrumbs::register('admin.users.edit', function($breadcrumbs, $comment)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push(__('messages.update'), route('admin.users.edit', $comment->id));
});

// Start pages
Breadcrumbs::register('admin.pages.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.static_pages'), route('admin.pages.index'));
});

Breadcrumbs::register('admin.pages.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(__('messages.create'), route('admin.pages.create'));
});

Breadcrumbs::register('admin.pages.edit', function($breadcrumbs, $pages)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(__('messages.update'), route('admin.pages.edit', $pages->id));
});

Breadcrumbs::register('admin.pages.show', function($breadcrumbs, $pages)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(__('messages.show'), route('admin.pages.show', $pages->id));
});

// Start configs
Breadcrumbs::register('admin.configs.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.configs'), route('admin.configs.index'));
});

Breadcrumbs::register('admin.configs.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.configs.index');
    $breadcrumbs->push(__('messages.create'), route('admin.configs.create'));
});

Breadcrumbs::register('admin.configs.edit', function($breadcrumbs, $keys)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(__('messages.update'), route('admin.configs.edit', $keys));
});

Breadcrumbs::register('admin.configs.show', function($breadcrumbs, $keys)
{
    $breadcrumbs->parent('admin.configs.index');
    $breadcrumbs->push(__('messages.show'), route('admin.configs.show', $keys));
});

// Start banners
Breadcrumbs::register('admin.banners.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.banners'), route('admin.banners.index'));
});

Breadcrumbs::register('admin.banners.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.banners.index');
    $breadcrumbs->push(__('messages.create'), route('admin.banners.create'));
});

Breadcrumbs::register('admin.banners.edit', function($breadcrumbs, $banners)
{
    $breadcrumbs->parent('admin.banners.index');
    $breadcrumbs->push(__('messages.update'), route('admin.banners.edit', $banners));
});

Breadcrumbs::register('admin.banners.show', function($breadcrumbs, $banners)
{
    $breadcrumbs->parent('admin.banners.index');
    $breadcrumbs->push(__('messages.show'), route('admin.banners.show', $banners));
});

# Start subjects
Breadcrumbs::register('admin.subjects.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.subjects'), route('admin.subjects.index'));
});

Breadcrumbs::register('admin.subjects.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.subjects.index');
    $breadcrumbs->push(__('messages.create'), route('admin.subjects.create'));
});

Breadcrumbs::register('admin.subjects.edit', function($breadcrumbs, $subjects)
{
    $breadcrumbs->parent('admin.banners.index');
    $breadcrumbs->push(__('messages.update'), route('admin.banners.edit', $subjects));
});

Breadcrumbs::register('admin.subjects.show', function($breadcrumbs, $subjects)
{
    $breadcrumbs->parent('admin.subjects.index');
    $breadcrumbs->push(__('messages.show'), route('admin.banners.show', $subjects));
});
# End subjects

# Start grades
Breadcrumbs::register('admin.grades.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.grades'), route('admin.grades.index'));
});

Breadcrumbs::register('admin.grades.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.grades.index');
    $breadcrumbs->push(__('messages.create'), route('admin.grades.create'));
});

Breadcrumbs::register('admin.grades.edit', function($breadcrumbs, $grades)
{
    $breadcrumbs->parent('admin.grades.index');
    $breadcrumbs->push(__('messages.update'), route('admin.grades.edit', $grades));
});

Breadcrumbs::register('admin.grades.show', function($breadcrumbs, $grades)
{
    $breadcrumbs->parent('admin.grades.index');
    $breadcrumbs->push(__('messages.show'), route('admin.grades.show', $grades));
});
# End grades



# Start tutorials
Breadcrumbs::register('admin.tutorials.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.tutorials'), route('admin.tutorials.index'));
});

Breadcrumbs::register('admin.tutorials.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.tutorials.index');
    $breadcrumbs->push(__('messages.create'), route('admin.tutorials.create'));
});

Breadcrumbs::register('admin.tutorials.edit', function($breadcrumbs, $tutorials)
{
    $breadcrumbs->parent('admin.tutorials.index');
    $breadcrumbs->push(__('messages.update'), route('admin.tutorials.edit', $tutorials));
});

Breadcrumbs::register('admin.tutorials.show', function($breadcrumbs, $tutorials)
{
    $breadcrumbs->parent('admin.tutorials.index');
    $breadcrumbs->push(__('messages.show'), route('admin.tutorials.show', $tutorials));
});
# End grades

// Start Transactions
Breadcrumbs::register('admin.transactions.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.transactions'), route('admin.transactions.index'));
});

Breadcrumbs::register('admin.transactions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.transactions.index');
    $breadcrumbs->push(__('messages.create'), route('admin.transactions.create'));
});

Breadcrumbs::register('admin.transactions.edit', function($breadcrumbs, $transactions)
{
    $breadcrumbs->parent('admin.transactions.index');
    $breadcrumbs->push(__('messages.update'), route('admin.transactions.edit', $transactions));
});

Breadcrumbs::register('admin.transactions.show', function($breadcrumbs, $transactions)
{
    $breadcrumbs->parent('admin.transactions.index');
    $breadcrumbs->push(__('messages.show'), route('admin.transactions.show', $transactions));
});
// End Transactions

// Start Coefficients
Breadcrumbs::register('admin.coefficients.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.dashboard.index');
    $breadcrumbs->push(__('messages.coefficients'), route('admin.coefficients.index'));
});

Breadcrumbs::register('admin.coefficients.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.coefficients.index');
    $breadcrumbs->push(__('messages.create'), route('admin.coefficients.create'));
});

Breadcrumbs::register('admin.coefficients.edit', function($breadcrumbs, $coefficients)
{
    $breadcrumbs->parent('admin.coefficients.index');
    $breadcrumbs->push(__('messages.update'), route('admin.coefficients.edit', $coefficients));
});

Breadcrumbs::register('admin.coefficients.show', function($breadcrumbs, $coefficients)
{
    $breadcrumbs->parent('admin.coefficients.index');
    $breadcrumbs->push(__('messages.show'), route('admin.coefficients.show', $coefficients));
});
// End Coefficients

// Start Front End
//Documents
Breadcrumbs::register('documents', function($breadcrumbs,$currentCategory)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.document'), route('documents'));
    if(!empty($currentCategory)){
        $breadcrumbs->push($currentCategory->name);
    }
});

Breadcrumbs::register('documents.show', function($breadcrumbs, $documents)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.document'), route('documents'));
    $breadcrumbs->push($documents->name, route('documents.show', $documents));
});

//Test

Breadcrumbs::register('tests', function($breadcrumbs,$currentCategory)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.test'), route('tests'));
    if(!empty($currentCategory)){
        $breadcrumbs->push($currentCategory->name);
    }
});

Breadcrumbs::register('tests.show', function($breadcrumbs, $tests)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.test'), route('tests'));
    $breadcrumbs->push($tests->name, route('tests.show', $tests));
});

//Teacher

Breadcrumbs::register('teachers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.teachers'), route('teachers'));
});

Breadcrumbs::register('teachers.show', function($breadcrumbs, $teachers)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.teachers'), route('teachers'));
    $breadcrumbs->push($teachers->name, route('teachers.show', $teachers));
});

//Center

Breadcrumbs::register('centers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.center'), route('centers'));
});

Breadcrumbs::register('centers.show', function($breadcrumbs, $centers)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.center'), route('centers'));
    $breadcrumbs->push($centers->name, route('centers.show', $centers));
});

//Course

Breadcrumbs::register('courses', function($breadcrumbs, $currentCategory)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.courses'), route('courses'));
    if(!empty($currentCategory)){
        $breadcrumbs->push($currentCategory->name);
    }
});

Breadcrumbs::register('courses.show', function($breadcrumbs, $courses)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.courses'), route('courses'));
    $breadcrumbs->push($courses->name, route('courses.show', $courses));
});

//News

Breadcrumbs::register('news', function($breadcrumbs, $currentCategory)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.news'), route('news'));
    if(!empty($currentCategory)){
        $breadcrumbs->push($currentCategory->name);
    }
});

Breadcrumbs::register('news.show', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.news'), route('news'));
    $breadcrumbs->push($news->name, route('news.show', $news));
});

//User

Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.users'), route('users'));
});

//Contact

Breadcrumbs::register('contacts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.menu_contacts'), route('contacts'));
});

//Tutorial

Breadcrumbs::register('tutorials', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('messages.menu_tutorials'), route('tutorials'));
});

//Tutorial Register

Breadcrumbs::register('tutorials-register', function($breadcrumbs)
{
    $breadcrumbs->parent('tutorials');
    $breadcrumbs->push(__('messages.menu_tutorials_register'), route('tutorials.register'));
});

//End FrontEnd
