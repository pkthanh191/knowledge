<?php

namespace App\Repositories;

use App\Models\Transaction;
use InfyOm\Generator\Common\BaseRepository;

class TransactionRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return Transaction::class;
    }

    public function search($condition)
    {
        if(!empty($condition)){
            $transaction = $this->model->where('content','=',$condition)->orderBy('updated_at', 'desc')->paginate(15);
        }
        else{
            $transaction = $this->model->orderBy('updated_at', 'desc')->paginate(15);
        }
        $this->resetModel();
        return $transaction;
    }
}
