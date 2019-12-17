<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\CommentNewsRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentTestRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Hash;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $commentDocRepository;
    private $commentNewsRepository;
    private $commentTestRepository;
    private $transactionRepository;

    public function __construct(UserRepository $userRepo, CommentRepository $commentRepo, CommentTestRepository $commentTestRepo, CommentNewsRepository $commentNewsRepo, TransactionRepository $transactionRepo)
    {
        $this->userRepository = $userRepo;
        $this->commentDocRepository = $commentRepo;
        $this->commentNewsRepository = $commentNewsRepo;
        $this->commentTestRepository = $commentTestRepo;
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchCondition = [];
        if (!empty($search)) {
            if (!empty($search['name'])) {
                array_push($searchCondition, ['name', 'LIKE', '%' . $search['name'] . '%']);
            }
            if (!empty($search['email'])) {
                array_push($searchCondition, ['email', 'LIKE', '%' . $search['email'] . '%']);
            }
            $users = $this->userRepository->search($searchCondition);
        } else
            $users = $this->userRepository->orderBy('updated_at', 'DESC')->paginate(15);
        $totalPages = 1;
        return view('backend.users.index')
            ->with('users', $users)->with('totalPages', $totalPages);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public
    function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public
    function store(CreateUserRequest $request)
    {
        if (strpos($request['phone'], '+84') !== false)
            $request['phone'] = str_replace('+84', '0', $request['phone']);
        if (!empty($request->avatar)) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('uploads'), $imageName);
            $request->avatar = $imageName;
            $input['avatar'] = '/uploads/' . $imageName;
        } else {
            $input['avatar'] = '/uploads/default-avatar.png';
        }
        $password = Hash::make($request->password);

        $input = $request->all();
        $input['password'] = $password;
        $this->userRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.users.index'));
        }

        return view('backend.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        $user['password'] = '';
        $edit = true;
        if (empty($user)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.users.index'));
        }

        return view('backend.users.edit')->with('user', $user)->with('edit', $edit);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public
    function update($id, UpdateUserRequest $request)
    {

        if (strpos($request['phone'], '+84') !== false)
            $request['phone'] = str_replace('+84', '0', $request['phone']);
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.users.index'));
        }

        if (!empty($request->password)) {
            $input = $request->all();
            $password = Hash::make($request->password);
            $input['password'] = $password;
        } else $input = $request->only(['name', 'sex', 'age', 'address', 'actived']);

        if (!empty($request->avatar)) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('uploads'), $imageName);
            $request->avatar = $imageName;
            $input['avatar'] = '/uploads/' . $imageName;
        }
        $user = $this->userRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (empty($request->ids)) Flash::error(__('messages.not-found'));
            else {
                foreach ($request->ids as $id) {
                    $users = $this->userRepository->findWithoutFail($id);

                    if (empty($users)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.users.index'));
                    }
                    $this->commentDocRepository->deleteByUser($id);
                    $this->commentTestRepository->deleteByUser($id);
                    $this->commentNewsRepository->deleteByUser($id);
                    $this->transactionRepository->deleteWhere(['user_id' => $id]);
                    $this->userRepository->delete($id);
                }

                Flash::success(__('messages.deleted'));
            }
        } else {
            $user = $this->userRepository->findWithoutFail($id);

            if (empty($user)) {
                Flash::error('messages.no-items');

                return redirect(route('admin.users.index'));
            }

            $this->commentDocRepository->deleteByUser($id);
            $this->commentTestRepository->deleteByUser($id);
            $this->commentNewsRepository->deleteByUser($id);
            $this->transactionRepository->deleteWhere(['user_id' => $id]);
            $this->userRepository->delete($id);

            Flash::success(__('messages.deleted'));
        }
        return redirect(route('admin.users.index'));
    }

    public function addMoney(Request $request, $id)
    {
//        $this->validator($request,['cost_vnd'=>'required|min:0', 'cost_know'=>'required|min:0']);
        $user = $this->userRepository->find($id);
        if ($user) {
            $vnd = preg_replace('/^\D+|\./', '', $request->cost_vnd);
            $know =  preg_replace('/^\D+|\./', '', $request->cost_know);
            $money =  $vnd ?  Helper::exchangeVNDtoKnow($vnd) : $know;
            if ($request->sign == 0) {
                $user->account_balance += $know;
                $this->transactionRepository->create([
                    'user_id' => $user->id,
                    'content' => Helper::$TRANS_RECHARGE,
                    'real_value' => $vnd? $vnd: null,
                    'money_transfer' => $know,
                    'description' => $request->description,
                    'status' => 1,
                ]);
            } else {
                $user->account_balance -= Helper::exchangeVNDtoKnow($vnd);
                $this->transactionRepository->create([
                    'user_id' => $user->id,
                    'content' => Helper::$TRANS_SUB_MONEY,
                    'real_value' => $vnd? $vnd: null,
                    'money_transfer' => $know,
                    'description' => $request->description,
                    'status' => 1,
                ]);
            }
            $user->save();
            return Response::json([
                'success' => true,
                'id' => $id,
                'account_balance' => Helper::format_money($user->account_balance, true, ' KNOW')
            ]);
        } else return Response::json([], 404);
    }
}
