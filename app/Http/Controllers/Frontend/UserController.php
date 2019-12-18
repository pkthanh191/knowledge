<?php

namespace App\Http\Controllers\Frontend;

use App\Libs\NganLuong\RechargeService;
use App\Repositories\NewsRepository;
use App\Repositories\TestRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\DocumentRepository;
use Illuminate\Support\Facades\Auth;
use Flash;
use Illuminate\Support\Facades\Validator;

class UserController extends FrontendBaseController
{
    private $userRepository;
    private $transactionRepository;
    private $documentRepository;
    private $newsRepository;
    private $testsRepository;
    private $rechargeService;

    public function __construct(UserRepository $userRepo, TransactionRepository $transactionRepo, DocumentRepository $documentRepo, NewsRepository $newsRepos, TestRepository $testRepo, RechargeService $recharge)
    {
        $this->userRepository = $userRepo;
        $this->transactionRepository = $transactionRepo;
        $this->documentRepository = $documentRepo;
        $this->newsRepository = $newsRepos;
        $this->testsRepository = $testRepo;
        $this->rechargeService = $recharge;
    }

    public function index(Request $request)
    {
        $documents = $this->documentRepository->getDocumentByUser(Auth::user()->id);
        $news = $this->newsRepository->getNewsByUser(Auth::user()->id);
        $tests = $this->testsRepository->getTestByUser(Auth::user()->id);
        $type = 'users';
        $user = $this->userRepository->findWithoutFail(Auth::user()->id);
        $transactions = $this->transactionRepository->orderBy('updated_at', 'desc')
            ->findByField('user_id', '=', Auth::user()->id, ['*'], false);
        try{
            $link_checkout = $this->rechargeService->checkout();
        } catch (\Exception $e){
            $link_checkout = false;
        }
        return view('frontend.users.index', compact('user', 'type', 'transactions', 'tests', 'news', 'documents', 'link_checkout'));
    }

    public function edit($id)
    {
        $type = 'users-edit';
        $user = $this->userRepository->findWithoutFail($id);
        $user['password'] = '';
        if (empty($user)) {
            Flash::error('messages.no-items');
            return redirect(route('users'));
        }

        return view('frontend.users.edit', compact('user', 'type'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), User::$rules_update, [], User::attributes());
        $validator->validate();
        $id = Auth::user()->id;
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('messages.no-items');

            return redirect(route('users'));
        }
        $input = $request->all();
        if (!empty($request->avatar)) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('uploads'), $imageName);
            $request->avatar = $imageName;
            $input['avatar'] = '/public/uploads/' . $imageName;
        }
        $input['name'] = $request['name'];
        $input['age'] = $request['age'];
        $input['sex'] = $request['sex'];
        $input['address'] = $request['address'];
        $this->userRepository->update($input, $id);

        Flash::success(__('messages.updated'));
        return redirect(route('users'));
    }

    public function change_pass(Request $request)
    {
        Validator::make($request->all(), ['new_password' => 'required|confirmed|min:6'],[],['new_password'=>__('messages.frontend_new_pass')])->validate();
        $user = Auth::user();

        if (Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
            if(Auth::attempt(['email' => $user->email, 'password' => $request->new_password])){
                Flash::error(__('messages.frontend_new_password_error'));
                return back();
            }
            $user->password = bcrypt($request->new_password);
            $user->save();
            Flash::success(__('messages.frontend_change_pass_success'));
            return back();
        }
        else {
            Flash::error(__('messages.frontend_password_error'));
            return back();
        }
    }
}