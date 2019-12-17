<?php

namespace App\Repositories;

use App\Models\CommentNews;
use InfyOm\Generator\Common\BaseRepository;

class CommentNewsRepository extends BGBaseRepository
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
        return CommentNews::class;
    }

    public function deleteByUser($user_id)
    {
        $comments = $this->model->where('user_id', '=', $user_id)->get();
        if ($comments) {
            foreach ($comments as $comment) {
                $childes = $comment->child()->get();
                if ($childes) {
                    foreach ($childes as $child) {
//                        $child->delete();
                        $test = $child->news()->first();
                        $test->comment_counts -= 1;
                        $test->save();
                    }
                }
                $comment->delete();
                $test = $comment->news()->first();
                $test->comment_counts -= 1;
                $test->save();
            }
        }

        $this->resetModel();
    }
}
