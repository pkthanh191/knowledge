<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\CategoryCourseRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CenterRepository;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use App\Repositories\TeacherRepository;
use App\Repositories\CourseRepository;
use App\Repositories\DocumentRepository;

class CenterController extends FrontendBaseController
{
    private $centerRepository;
    private $teacherRepository;
    private $courseRepository;
    private $documentRepository;
    private $bannerRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, CenterRepository $centerRepo,TeacherRepository $teacherRepository,CourseRepository $courseRepository, CategoryCourseRepository $categoryCourseRepo, DocumentRepository $documentRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);

        $this->categoryCourseRepository = $categoryCourseRepo;
        $this->centerRepository = $centerRepo;
        $this->teacherRepository = $teacherRepository;
        $this->courseRepository = $courseRepository;
        $this->documentRepository = $documentRepo;
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

        $type = 'centers';

        $centers = $this->centerRepository->orderBy('updated_at','desc')->getCenters($search);
        $teachers = $this->teacherRepository->orderBy('feature','desc')->orderBy('updated_at','desc')->getTeachers($search);
        return view('frontend.centers.index', compact('docCategories','testCategories','courseCategories', 'centers', 'mode', 'search', 'categorySlug', 'type', 'banners', 'teachers'));
    }


    public function show($slug) {
        $center = $this->centerRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $teachers = $this->teacherRepository->findByField('center_id','=', $center->id, ['*'], false);
        $courses = $this->courseRepository->findByField('center_id','=', $center->id, ['*'], false);

        $centerRecent = $this->centerRepository->orderBy('created_at','desc')->paginate(6);
        $documentComments = $this->documentRepository->orderBy('comment_counts','desc')->paginate(6);
        $documentViews = $this->documentRepository->orderBy('view_counts','desc')->paginate(6);

        #TODO: Lấy phần liên quan khác phục vụ cho phần chi tiết.

        if (empty($center)) {
            #TODO: Xử lý
        }

        $type = 'centers';

        return view('frontend.centers.show', compact('center','teachers','courses', 'centerRecent', 'documentComments', 'documentViews', 'type'));
    }
}
