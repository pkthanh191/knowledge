<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\CreateTutorialRequest;
use App\Repositories\CityRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\GradeRepository;
use App\Repositories\GradeTutorialRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectTutorialRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TutorialCodeRepository;
use App\Repositories\TutorialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use \Flash;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;

class TutorialsController extends FrontendBaseController
{
    private $tutorialRepository;
    private $subjectTutorialRepository;
    private $gradeTutorialRepository;
    private $subjectRepository;
    private $gradeRepository;
    private $cityRepository;
    private $districtRepository;
    private $transactionRepository;
    private $tutorialCodeRepository;
    protected $mailer;

    public function __construct(TutorialRepository $tutorialRepo, DistrictRepository $districtRepos, CityRepository $cityRepo, SubjectRepository $subjectRepo, GradeRepository $gradeRepo, SubjectTutorialRepository $subjectTutorialRepo, GradeTutorialRepository $gradeTutorialRepo, TransactionRepository $transactionRepository, TutorialCodeRepository $tutorialCodeRepo, Mailer $mailer)
    {
        $this->tutorialRepository = $tutorialRepo;
        $this->subjectTutorialRepository = $subjectTutorialRepo;
        $this->gradeTutorialRepository = $gradeTutorialRepo;
        $this->subjectRepository = $subjectRepo;
        $this->gradeRepository = $gradeRepo;
        $this->cityRepository = $cityRepo;
        $this->districtRepository = $districtRepos;
        $this->transactionRepository = $transactionRepository;
        $this->tutorialCodeRepository = $tutorialCodeRepo;
        $this->mailer = $mailer;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $searchConditions = [];
        $compare = [];

        if (!empty($search)) {
            if (!empty($search['subject']) && ($search['subject'] != 0)) {
                array_push($compare, ['subject_tutorials.subject_id', $search['subject']]);
            }

            if (!empty($search['grade']) && ($search['grade'] != 0)) {
                array_push($compare, ['grade_tutorials.grade_id', $search['grade']]);
            }

            if (!empty($search['city_code']) && $search['city_code'] != 0) {
                array_push($compare, ['cities.code', $search['city_code']]);
            }

            if (!empty($search['district']) && $search['district'] != 0) {
                array_push($compare, ['districts.id', $search['district']]);
            }

            $tutorials = $this->tutorialRepository->search($searchConditions, $compare, true);
            $first = false;
        }

        if (empty($search) || ($search['subject'] == 0 && $search['grade'] == 0 && $search['city_code'] == 0 && $search['district'] == 0)) {
            $tutorials_primary = $this->tutorialRepository->getByGrades(1);
            $tutorials_secondary = $this->tutorialRepository->getByGrades(2);
            $tutorials_high = $this->tutorialRepository->getByGrades(3);
            $tutorials_else = $this->tutorialRepository->getByGrades(4);
            $first = true;
        }

        $type = 'tutorials';
        $subjects = $this->subjectRepository->getAllForSelectBox(['*'], null, true, __('messages.tutorials_choose_subject'));
        $grades = $this->gradeRepository->getAllForSelectBox(['*'], null, true, __('messages.tutorials_choose_grade'));
        $cities = $this->cityRepository->getAllCitiesForSelectBox(['*'], null, true, __('messages.tutorials_choose_city'));
        if (!empty($search) && $search['city_code'] != 0)
            $districts = $this->districtRepository->getAllDistrictsByCodeCityForSelectBox(['*'], null, true, __('messages.tutorials_choose_district'), $search['city_code']);
        else
            $districts = [0 => '-- ' . __('messages.tutorials_choose_district') . ' --'];
        return view('frontend.tutorials.index', compact('first', 'type', 'tutorials', 'tutorials_primary', 'tutorials_secondary', 'tutorials_high', 'tutorials_else', 'subjects', 'grades', 'cities', 'districts'));
    }

    public function register()
    {
        $type = 'tutorials';
        $subjects = $this->subjectRepository->getAllForSelectBox(['*'], null, false);
        $grades = $this->gradeRepository->getAllForSelectBox(['*'], null, false);
        $cities = $this->cityRepository->getAllCitiesForSelectBox(['*'], null, true,__('messages.tutorials_choose_city'));
        $districts = $this->districtRepository->getAllDistrictsByCodeCityForSelectBox(['*'],null,true,__('messages.frontend_tutorial_select_district'),-1);
        return view('frontend.tutorials.register', compact('type', 'subjects', 'grades', 'cities', 'districts'));
    }

    public function create(CreateTutorialRequest $request)
    {
        if(strpos($request['phone'],'+84') === 0)
            $request['phone'] = str_replace('+84','0',$request['phone']);
        $input = $request->all();
        $tutorial = $this->tutorialRepository->create($input);



        $subjects = $this->subjectRepository->findWhereIn('id',$input['subjects']);
        $subject_text='';
        foreach ($subjects as $subject)
            $subject_text .= $subject->name.', ';
        $grades = $this->gradeRepository->findWhereIn('id',$input['grades']);
        $grade_text='';
        foreach ($grades as $grade)
            $grade_text .= $grade->name.', ';

        $cities = $this->cityRepository->findByField('code', '=', $input['city_id']);
        $cityName = '';
        foreach ($cities as $city) {
            $cityName .= $city->name.', ';
        }
        $text = '<b>Tiêu đề: </b>'.$tutorial['title']
            .'<br><b>Số điện thoại: </b>'.$tutorial['phone']
            .'<br><b>Email: </b>'.$tutorial['email']
            .'<br><b>Môn: </b>'.$subject_text
            .'<br><b>Lớp: </b>'.$grade_text
            .'<br><b>Số buổi/tuần: </b>'.$tutorial['frequency']
            .'<br><b>Thời điểm: </b>'.$tutorial['period']
            .'<br><b>Lương: </b>'.$tutorial['salary']
            .'<br><b>Địa chỉ: </b>'.$tutorial['address']
            .'<br><b>Thành phố: </b>'.$cityName
            .'<br><b>Quận/Huyện: </b>'.$this->districtRepository->findWithoutFail($input['district_id'])->name
            .'<br><b>Yêu cầu: </b>'.$tutorial['requirement'];

        Mail::send([], [], function ($message) use($text, $input, $tutorial) {
                $message->to(config('system.contact.value'))->subject('[Tìm gia sư] '.$tutorial['title'])->setBody($text, 'text/html'); // for HTML rich messages
        });

        Flash::success(__('messages.frontend_tutorial_registered'));
        return redirect(route('tutorials'));
    }

    public function sendMail(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $tutorial = $this->tutorialRepository->find($request['id']);
                $code = Helper::generateTel(6);
                $this->tutorialCodeRepository->create([
                    'code' => $code,
                    'start_date' => time(),
                    'end_date' => time() + 60 * 60 * 24 * Helper::rip_tags(config('system.time-effect.value')),
                    'tutorial_id' => $tutorial->id
                ]);
                $user = Auth::user();

                if ($user->account_balance >= Helper::rip_tags(config('system.minus-knows-tutorial.value'))) {
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-tutorial.value'));
                    $user->save();
                    $this->transactionRepository->create([
                        'content' => Helper::$TRANS_VIEW_TUTORIAL,
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-tutorial.value')),
                        'status' => 1,
                        'user_id' => $user->id,
                        'tutorial_id' => $tutorial->id,
                    ]);

                    $username = $user->name;
                    $tutorial_title = $tutorial->title;
                    $user_account_balance = $user->account_balance;
                    $this->mailer->send(['html' => 'emails.tutorial_code'], compact('username', 'tutorial_title','code','user_account_balance'), function (Message $m) use ($user) {
                        $m->to($user->email)->subject(__('messages.subject_receive_code'));
                    });

                    $result = array(
                        'user' => $user->name,
                        'account_balance' => $user->account_balance,
                        'know_tutorial' => Helper::rip_tags(config('system.minus-knows-tutorial.value'))
                    );
                    return Response::json($result);
                }
                else{
                    return Response::json(['account_balance' => $user->account_balance,
                        'know_tutorial' => Helper::rip_tags(config('system.minus-knows-tutorial.value')),
                        'success' => 'fail'
                    ]);
                }
            }
        }
    }

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            $tutorial = $this->tutorialRepository->find($request['id']);
            $tutorial_codes = DB::table('tutorial_codes')->where('tutorial_id','=',$request['id'])->select('*')->get();
            $check = false;
            foreach ($tutorial_codes as $key => $tutorial_code) {
                if ($tutorial_code->code == $request['code'] && (time() <= strtotime($tutorial_code->end_date))) {
                    $check = true;
                }
            }
            if ($check == true) {
                $result = array(
                    'phone' => $tutorial->phone,
                    'email' => $tutorial->email,
                    'address' => $tutorial->address,
                    'id' => $tutorial->id,
                );
                return Response::json($result);
            }
            else{
                return Response::json(['fail' => true,
                    'error' => __('messages.frontend_tutorial_code_error')]);
            }
        }

    }
}
