<?php

namespace App\Repositories;

use App\Models\CommentTest;

class CommentTestRepository extends BGBaseRepository
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
        return CommentTest::class;
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
                        $test = $child->test()->first();
                        $test->comment_counts -= 1;
                        $test->save();
                    }
                }
                $comment->delete();
                $test = $comment->test()->first();
                $test->comment_counts -= 1;
                $test->save();
            }
        }

        $this->resetModel();
    }
}
