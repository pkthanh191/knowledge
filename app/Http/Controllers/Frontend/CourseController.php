<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\CategoryCourseRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CourseRepository;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

class CourseController extends FrontendBaseController
{
    private $courseRepository;
    private $bannerRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, CategoryCourseRepository $categoryCourseRepo,CourseRepository $courseRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);

        $this->categoryCourseRepository = $categoryCourseRepo;
        $this->courseRepository = $courseRepo;
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
        $currentCategory = $this->categoryCourseRepository->findWhere([['slug','=',$categorySlug]],['*'],false)->first();

        $type = 'courses';

        $courses = $this->courseRepository->orderBy('updated_at','desc')->getCoursesByCategorySlug($categorySlug, $search);

        return view('frontend.courses.index', compact('docCategories','testCategories','courseCategories','courseCategory', 'courses', 'mode', 'search', 'categorySlug', 'type','meta_title', 'meta_keywords', 'meta_description', 'currentCategory', 'banners'));
    }

    public function show($slug) {

        $courseCategories = $this->getCourseCategories();
        $course = $this->courseRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $courseRelatives = $this->courseRepository->getRelatives($course);
        $courseRecent = $this->courseRepository->orderBy('created_at','desc')->paginate(6);
        $courseViews = $this->courseRepository->orderBy('view_counts','desc')->paginate(6);
        $courseComments = $this->courseRepository->orderBy('comment_counts','desc')->paginate(6);

        $categorySlug = '';
        $type = 'courses';

        #TODO: Lấy phần liên quan khác phục vụ cho phần chi tiết.
        if (empty($course)) {
            #TODO: Xử lý
        }
        $course->view_counts = $course->view_counts+1;
        $course->save();
        return view('frontend.courses.show', compact('course', 'courseCategories','courseRelatives','courseRecent','courseComments','courseViews', 'type','meta_title', 'meta_keywords', 'meta_description','categorySlug'));
    }
}
