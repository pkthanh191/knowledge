<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\TestRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CenterRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentTestRepository;
use App\Repositories\CourseOrderRepository;
use App\Repositories\TutorialRepository;
use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository;

class DashboardController extends Controller
{
    private $documentRepository;
    private $categoryDocReppository;
    private $courseRepository;
    private $testRepository;
    private $categoryTestRepository;
    private $teacherRepository;
    private $centerRepository;
    private $commentRepository;
    private $commentTestRepository;
    private $tutorialRepository;
    private $userRepository;
    private $transactionRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DocumentRepository $documentRepository, CategoryDocRepository $categoryDocRepository, CourseRepository $courseRepository, TestRepository $testRepository, CategoryTestRepository $categoryTestRepository, TeacherRepository $teacherRepository, CenterRepository $centerRepository, CommentRepository $commentRepository, CommentTestRepository $commentTestRepository, TutorialRepository $tutorialRepository, UserRepository $userRepository, TransactionRepository $transactionRepository)
    {
        $this->middleware('auth');
        $this->documentRepository = $documentRepository;
        $this->categoryDocReppository = $categoryDocRepository;
        $this->courseRepository = $courseRepository;
        $this->testRepository = $testRepository;
        $this->categoryTestRepository = $categoryTestRepository;
        $this->teacherRepository = $teacherRepository;
        $this->centerRepository = $centerRepository;
        $this->commentRepository = $commentRepository;
        $this->commentTestRepository = $commentTestRepository;
        $this->tutorialRepository = $tutorialRepository;
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countDocumentRepository = count($this->documentRepository->all());
        $countCategoryDocumentRepository = count($this->categoryDocReppository->all());
        $countCourseRepository = count($this->courseRepository->all());
        $countTestRepository = count($this->testRepository->all());
        $countTestCategoryRepository = count($this->categoryTestRepository->all());
        $countTeacherRepository = count($this->teacherRepository->all());
        $countCenterRepository = count($this->centerRepository->all());
        $countDocumentComment = count($this->commentRepository->all());
        $countTestComment = count($this->commentTestRepository->all());
        $countUserRepository = count($this->userRepository->all());
        $countTransactionRepository = $this->transactionRepository->all();

        $lastestComments = $this->commentRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->paginate(4);
        $lastestCommentTests = $this->commentTestRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->paginate(4);
        $lastestTutorial = $this->tutorialRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->paginate(4);
        $lastestUsers = $this->userRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->paginate(4);
        $lastestTransactions = $this->transactionRepository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->paginate(4);
        $lastestTransactions = $this->transactionRepository->orderBy('created_at','desc')->paginate(4);
        return view('backend.dashboard.index',compact('countDocumentRepository','countCategoryDocumentRepository','countCourseRepository','countTestRepository','countTestCategoryRepository','countTeacherRepository','countCenterRepository','lastestComments','countDocumentComment','countTestComment','lastestCommentTests','lastestTutorial','countUserRepository','lastestUsers','countTransactionRepository','lastestTransactions'));
    }
}
