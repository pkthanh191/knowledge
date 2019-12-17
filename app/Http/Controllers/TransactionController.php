<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class TransactionController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;
    private $userRepository;

    public function __construct(TransactionRepository $transactionRepo, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepo;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the Transaction.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if (!empty($search)) {
            if (!empty($search['content']) && $search['content'] != 0) {
                $transactions = $this->transactionRepository->search($search['content']);
            }
            else{
                $transactions = $this->transactionRepository->orderBy('updated_at', 'desc')->paginate(15);
            }
        } else
            $transactions = $this->transactionRepository->orderBy('updated_at', 'desc')->paginate(15);
        return view('backend.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new Transaction.
     *
     * @return Response
     */
    public function create()
    {
        $users = $this->userRepository->pluck('name', 'id');
        $users->prepend(__('messages.selected'),0);
        return view('backend.transactions.create', compact('users'));
    }

    /**
     * Store a newly created Transaction in storage.
     *
     * @param CreateTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['money_transfer'] = Helper::convert_money($request['money_transfer']);

        $transaction = $this->transactionRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Display the specified Transaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->findWithoutFail($id);

        if (empty($transaction)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.transactions.index'));
        }

        return view('backend.transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified Transaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $transaction = $this->transactionRepository->findWithoutFail($id);

        if (empty($transaction)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.transactions.index'));
        }

        return view('backend.transactions.edit')->with('transaction', $transaction);
    }

    /**
     * Update the specified Transaction in storage.
     *
     * @param  int              $id
     * @param UpdateTransactionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionRequest $request)
    {
        $transaction = $this->transactionRepository->findWithoutFail($id);
        $input = $request->all();
        if (empty($transaction)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.transactions.index'));
        }
        $input['money_transfer'] = Helper::convert_money($request['money_transfer']);
        $transaction = $this->transactionRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (!is_null($request->ids)) {
                foreach ($request->ids as $id) {
                    $transaction = $this->transactionRepository->findWithoutFail($id);
                    $this->transactionRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.transactions.index'));
            } else {
                Flash::error(__('messages.checkTransaction'));
                return redirect(route('admin.transactions.index'));
            }
        } else {
            $transaction = $this->transactionRepository->findWithoutFail($id);
            if (empty($transaction)) {
                Flash::error(__('messages.no-items'));
                return redirect(route('admin.transactions.index'));
            }
            $this->transactionRepository->delete($id);
            Flash::success(__('messages.deleted'));
            return redirect(route('admin.transactions.index'));
        }
    }
}
