<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return Comment::class;
    }

    public function deleteByUser($user_id)
    {
        $comments = $this->model->where('user_id', '=', $user_id)->get();
        if ($comments) {
            foreach ($comments as $comment) {
                $childes = $comment->child()->get();
                if ($childes) {
                    foreach ($childes as $child) {
                        $child->delete();
                        $test = $child->document()->first();
                        $test->comment_counts -= 1;
                        $test->save();
                    }
                }
                $comment->delete();
                $test = $comment->document()->first();
                $test->comment_counts -= 1;
                $test->save();
            }
        }

        $this->resetModel();
    }
}
