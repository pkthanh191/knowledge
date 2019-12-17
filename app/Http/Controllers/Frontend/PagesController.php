<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\BannerRepository;
use Illuminate\Support\Facades\View;
use App\Models\Center;
use App\Models\Course;
use App\Models\Document;
use App\Models\Teacher;
use App\Models\Test;

class PagesController extends Controller
{
    private $pageRepository;
    private $categoryDocRepository;
    private $categoryTestRepository;
    protected $SEPARATOR_SPACE = '&nbsp;&nbsp;&nbsp;&nbsp;';
    private $bannerRepository;

    public function __construct(PageRepository $pageRepository, CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, BannerRepository $bannerRepo)
    {
        $this->pageRepository = $pageRepository;
        $this->categoryDocRepository = $categoryDocRepo;
        $this->categoryTestRepository = $categoryTestRepo;
        $this->bannerRepository = $bannerRepo;
    }

    public function index($slug)
    {
        $pages = $this->pageRepository->findWhere([['slug', '=', $slug]]);
        if($slug == 'gioi-thieu'){
            $type = 'about';
        }
        elseif ($slug == 'dieu-khoan-su-dung'){
            $type = 'termUse';
        }
        elseif ($slug == 'dieu-khoan-bao-mat'){
            $type = 'termSecurity';
        }


        $categorySlug = '';
        $parentArrayDoc = [];

        View::share('documentCount', count(Document::all()));
        View::share('testCount', count(Test::all()));
        View::share('teacherCount', count(Teacher::all()));
        View::share('centerCount', count(Center::all()));
        View::share('courseCount', count(Course::all()));
        $banners = $this->bannerRepository->getbyChecked();

        $docCategories = $this->categoryDocRepository->buildTree(['*'], $this->SEPARATOR_SPACE);
        $testCategories = $this->categoryTestRepository->buildTree(['*'], $this->SEPARATOR_SPACE);
        return view('frontend.pages.index', compact('pages', 'type', 'docCategories', 'testCategories', 'categorySlug', 'parentArrayDoc','banners'));
    }
}
