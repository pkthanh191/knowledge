<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\CategoryCourseRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CenterRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\BannerRepository;


use Illuminate\Http\Request;

class TeacherController extends FrontendBaseController
{
    private $teacherRepository, $courseRepository, $centerRepository;

    private $bannerRepository;


    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, TeacherRepository $teacherRepo, CourseRepository $courseRepo, CenterRepository $centerRepo, CategoryCourseRepository $categoryCourseRepo, DocumentRepository $documentRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);

        $this->teacherRepository = $teacherRepo;
        $this->courseRepository = $courseRepo;
        $this->centerRepository = $centerRepo;
        $this->documentRepository = $documentRepo;
        $this->categoryCourseRepository = $categoryCourseRepo;
        $this->bannerRepository = $bannerRepo;

    }
    public function index(Request $request)
    {
        $docCategories = $this->getDocCategories();
        $testCategories = $this->getTestCategories();
        $courseCategories = $this->getCourseCategories();
        $banners = $this->bannerRepository->getbyChecked();

        $categorySlug = $request['danh-muc'];
        $mode = $request['mode'];

        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search!= null) $search = $search['name'];

        $type = 'teachers';
//        $currentCategory = $this->categoryDocRepository->findWhere([['slug','=',$categorySlug]],['*'],false)->first();

        $teachers = $this->teacherRepository->orderBy('feature','desc')->orderBy('updated_at','desc')->getTeachers($search);
        return view('frontend.teachers.index', compact('docCategories','testCategories','courseCategories', 'teachers', 'mode', 'search', 'categorySlug', 'type', 'banners'));
    }

    public function show($slug) {
        $teacher = $this->teacherRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $other_teachers = $this->teacherRepository->findByField('id', '!=', $teacher->id, ['*'], 6);
        $courses = $this->courseRepository->findByField('teacher_id', '=', $teacher->id, ['*'], false);
        $center = $this->centerRepository->findByField('id', '=', $teacher->center_id, ['*'], false)->first();
        $other_teachers = $this->teacherRepository->findWhere([['center_id', '=', $center->id],['id', '!=', $teacher->id],['id', '!=', 0]])->take(6);

        $documentRecent = $this->documentRepository->orderBy('created_at','desc')->paginate(6);
        $documentComments = $this->documentRepository->orderBy('comment_counts','desc')->paginate(6);
        $documentViews = $this->documentRepository->orderBy('view_counts','desc')->paginate(6);
        #TODO: Lấy phần liên quan khác phục vụ cho phần chi tiết.

        if (empty($document)) {
            #TODO: Xử lý
        }

        $type = 'teachers';

        return view('frontend.teachers.show', compact('teacher', 'courses', 'other_teachers', 'center', 'documentRecent', 'documentViews', 'documentComments', 'meta_title', 'meta_keywords', 'meta_description', 'type'));
    }
}
