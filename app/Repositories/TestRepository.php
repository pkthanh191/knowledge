<?php

namespace App\Repositories;

use App\Models\Test;

class TestRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return Test::class;
    }

    public function result($pageSize) {
        $tests = $this->model->inRandomOrder()->paginate($pageSize);
        $this->resetModel();
        return $tests;
    }

    public function search($where, $categoryId = null)
    {
        $this->applyConditions($where);
        if (!empty($categoryId)) {
            $tests = $this->model->with('categories')->join('test_categories', function ($join) {
                $join->on('tests.id', '=', 'test_categories.test_id');
            })->where('test_categories.category_test_id', $categoryId)->whereNull('test_categories.deleted_at');
        } else {
            $tests = $this->model->with('categories');
        }

        $this->resetModel();
        return $tests;
    }

    public function getTestsByCategorySlug($categorySlug = null, $name = null)
    {
        $tests = null;
        if (empty($categorySlug)) {
            $tests = $this->model->where('name', 'LIKE', '%' . $name . '%')->whereHas('categories')->inRandomOrder()->paginate(18);
        } else {
            $tests = $this->model->with('categories')->join('test_categories', function ($join) {
                $join->on('tests.id', '=', 'test_categories.test_id');
            })->join('category_tests', function ($join) {
                $join->on('category_tests.id', '=', 'test_categories.category_test_id');
            })->where(function ($q) use ($name) {
                $q->where('tests.name', 'LIKE', '%' . $name . '%');
            })->where('category_tests.slug', $categorySlug)->whereNull('test_categories.deleted_at')->paginate(18, ['tests.*']);
        }

        $this->resetModel();
        return $tests;
    }

    public function getRelatives($test)
    {
        $tests = $this->model->with('categories')->join('test_categories', function ($join) {
            $join->on('tests.id', '=', 'test_categories.test_id');
        })->where('tests.id', '!=', $test->id)->limit(10)->get(['tests.*']);

        $this->resetModel();
        return $tests;
    }

    public function getCategoryTest()
    {
        $tests = $this->model->with('categories')->join('test_categories', function ($join) {
            $join->on('tests.id', '=', 'test_categories.test_id');
        })->join('category_tests', function ($join) {
            $join->on('category_tests.id', '=', 'test_categories.category_test_id');
        });

        $this->resetModel();
        return $tests;
    }

    public function getTestByUser($user)
    {
        $tests = $this->model->join('comment_tests', function ($join) {
            $join->on('tests.id', '=', 'comment_tests.test_id');
        })->where('comment_tests.user_id','=',$user)->distinct()->get(['tests.*']);

        $this->resetModel();
        return $tests;
    }

    public function getTestByComment($category_id = null)
    {
        if ($category_id == null) {
            $tests = $this->model->join('comment_tests', function ($join) {
                $join->on('tests.id', '=', 'comment_tests.test_id');
            })->distinct()->orderBy('updated_at', 'desc')->get(['tests.*']);
        } else {
            $tests = $this->model->join('comment_tests', function ($join) {
                $join->on('tests.id', '=', 'comment_tests.test_id');
            })->join('test_categories', function ($join) {
                $join->on('tests.id', '=', 'test_categories.test_id');
            })->where('test_categories.category_test_id', '=', $category_id)->distinct()->orderBy('updated_at', 'desc')->get(['tests.*']);
        }

        $this->resetModel();
        return $tests;
    }
}
