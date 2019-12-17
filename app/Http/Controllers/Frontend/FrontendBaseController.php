<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Course;
use App\Models\Document;
use App\Models\Teacher;
use App\Models\Test;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use Illuminate\Support\Facades\View;

class FrontendBaseController extends Controller
{
    protected $SEPARATOR_SPACE = '&nbsp;&nbsp;&nbsp;&nbsp;';

    protected $categoryDocRepository;
    protected $categoryTestRepository;
    protected $categoryCourseRepository;

    public $meta_title = "";
    public $meta_keywords = "";
    public $meta_description = "";

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo)
    {
        $this->categoryDocRepository = $categoryDocRepo;
        $this->categoryTestRepository = $categoryTestRepo;

        View::share('documentCount', count(Document::all()));
        View::share('testCount', count(Test::all()));
        View::share('teacherCount', count(Teacher::all()));
        View::share('centerCount', count(Center::all()));
        View::share('courseCount', count(Course::all()));
    }

    public function getDocCategories(){
        $categories = $this->categoryDocRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree(['*'],$this->SEPARATOR_SPACE);
        return $categories;
    }

    public function getTestCategories(){
        $categories = $this->categoryTestRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree(['*'],$this->SEPARATOR_SPACE);
        return $categories;
    }
    public function getCourseCategories(){
        return $this->categoryCourseRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree(['*'],$this->SEPARATOR_SPACE);
    }

    // TODO: Thực thi nghiệp vụ xử lý trả về kết quả của các phần chung.

}
