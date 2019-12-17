<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Test;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentCategoryRepository;
use App\Repositories\CategoryDocMetaRepository;
use App\Repositories\DocumentMetaRepository;
use App\Repositories\DocumentMetaValueRepository;
use App\Repositories\TestRepository;
use App\Repositories\CenterRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends FrontendBaseController
{
    private $documentRepository;
    private $testRepository;
    private $centerRepository;
    private $teacherRepository;
    private $documentCategoryRepository;
    private $categoryDocMetaRepository;
    private $documentMetaRepository;
    private $documentMetaValueRepository;
    private $courseRepository;
    private $bannerRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, DocumentRepository $documentRepo, TestRepository $testRepo, CenterRepository $centerRepo, TeacherRepository $teacherRepo, DocumentCategoryRepository $documentCategoryRepo, CategoryDocMetaRepository $categoryDocMetaRepo, DocumentMetaRepository $documentMetaRepo, DocumentMetaValueRepository $documentMetaValueRepo, CourseRepository  $courseRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);

        $this->documentRepository = $documentRepo;
        $this->testRepository = $testRepo;
        $this->centerRepository = $centerRepo;
        $this->teacherRepository = $teacherRepo;
        $this->documentCategoryRepository = $documentCategoryRepo;
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
        $this->documentMetaRepository = $documentMetaRepo;
        $this->documentMetaValueRepository = $documentMetaValueRepo;
        $this->courseRepository = $courseRepo;
        $this->bannerRepository = $bannerRepo;
    }

    public function index(Request $request)
    {
        $docCategories = $this->getDocCategories();
        $testCategories = $this->getTestCategories();

        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search != null) $search = $search['name'];

        $categorySlug = null;
        $parentArrayDoc= $categorySlug? $this->categoryDocRepository->getParentBySlug($categorySlug) : [];

        $type = 'home';

        $banners = $this->bannerRepository->getbyChecked();
        $documents = $this->documentRepository->result(12);
        $tests = $this->testRepository->result(12);
        $centers = $this->centerRepository->getWithout0();
        $teachers = $this->teacherRepository->getWithout0();
        $courses = $this->courseRepository->result(12);

        return view('frontend.home.index', compact('docCategories', 'testCategories', 'documents', 'tests', 'centers', 'teachers', 'courses','search', 'type', 'categorySlug','banners','parentArrayDoc'));    }

    public function forums(Request $request){
        $type = 'forums';

        $docCategories = $this->getDocCategories();
        $testCategories = $this->getTestCategories();
        $banners = $this->bannerRepository->getbyChecked();

        $categorySlug = null;
        $parentArrayDoc= $categorySlug? $this->categoryDocRepository->getParentBySlug($categorySlug) : [];

        $documents = $this->documentRepository->result(20);
        $tests = $this->testRepository->result(20);
        return view('frontend.home.forums', compact('type', 'documents', 'tests', 'docCategories', 'testCategories', 'categorySlug', 'parentArrayDoc','banners'));
    }
}
