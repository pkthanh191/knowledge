<?php

namespace App\Repositories;

use InfyOm\Generator\Common\BaseRepository;

abstract class BGBaseRepository extends BaseRepository
{

    abstract public function BGModel();

    public function model()
    {
        return $this->BGModel();
    }

    public function findByField($field, $condition = '=', $value = null, $columns = ['*'], $is_paging = true, $limit = 18)
    {
        $this->applyCriteria();
        $this->applyScope();
        $limit = is_null($limit) ? config('repository.pagination.limit', 18) : $limit;
        if ($is_paging) $model = $this->model->where($field, $condition, $value)->paginate($limit, $columns);
        else $model = $this->model->where($field, $condition, $value)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findWhere(array $where, $columns = ['*'], $is_paging = true, $limit = 18)
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);

        $limit = is_null($limit) ? config('repository.pagination.limit', 18) : $limit;
        if ($is_paging) $model = $this->model->paginate($limit, $columns);
        else  $model = $this->model->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findWhereIn($field, array $values, $columns = ['*'], $is_paging = true, $limit = 18)
    {
        $this->applyCriteria();
        $this->applyScope();
        $limit = is_null($limit) ? config('repository.pagination.limit', 18) : $limit;
        if ($is_paging) $model = $this->model->whereIn($field, $values)->paginate($limit, $columns);
        else  $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'], $is_paging = true, $limit = 18)
    {
        $this->applyCriteria();
        $this->applyScope();

        $limit = is_null($limit) ? config('repository.pagination.limit', 18) : $limit;
        if ($is_paging) $model = $this->model->whereNotIn($field, $values)->paginate($limit, $columns);
        else $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    protected $categoriesTree = [];

    public function buildTree($columns = ['*'], $separator = '— ', $id = null)
    {
        $categoriesParent = $this->model->where('parent_id', '=', '0')->get($columns);
        if ($id != null) {
            $categoriesParent = $this->model->where('parent_id', '=', '0')->where('id', '<>', $id)->orderBy('updated_at','desc')->get($columns);
        }

        foreach ($categoriesParent as $category) {
            $this->categoriesTree[] = $category;
            $this->getChild($category, '', $columns, $separator, $id);
        }

        $this->resetModel();

        return $this->categoriesTree;
    }

    public function getChild($category, $level, $columns = ['*'], $separator = '— ', $id = null)
    {
        $level .= $separator;
        foreach ($category->children($columns) as $children) {
            if ($children->id != $id || $id == null) {
                $children->name = $level . $children->name;
                $this->categoriesTree[] = $children;
                $this->getChild($children, $level, $columns, $separator, $id);
            }
        }
    }

    public function buildTreeForSelectBox($columns = ['*'], $separator = '— ', $id = null, $defaultValue = "Chọn giá trị")
    {
        $categoryList = $this->orderBy('orderSort', 'asc')->orderBy('updated_at', 'desc')->buildTree($columns, $separator, $id);
        $categories = array();
        $categories[0] = '-- ' . $defaultValue . ' --';
        foreach ($categoryList as $category) {
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }

    public function getAllForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = "Chọn giá trị")
    {
        $categoryList = $this->model->all($columns);
        $categories = array();
        if ($blank) $categories[0] = '-- ' . $defaultValue . ' --';
        foreach ($categoryList as $category) {
            if ($category->id != $id || $id == null) {
                $categories[$category->id] = $category->name;
            }
        }

        $this->resetModel();

        return $categories;
    }

    public function getAllCommentForSelectBox($columns = ['*'], $id = null, $blank = true)
    {
        $commentList = $this->model->all($columns);
        $comments = array();
        if ($blank) $comments[0] = __('messages.selected');
        foreach ($commentList as $comment) {
            if ($comment->id != $id || $id == null) {
                $comments[$comment->id] = $comment->content;
            }
        }

        $this->resetModel();

        return $comments;
    }

    public function getAllCitiesForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = 'Chọn Tỉnh/Thành')
    {
        $citiesList = $this->model->all($columns);
        $cites = array();
        if ($blank) $cites[0] = '-- ' . $defaultValue . ' --';
        foreach ($citiesList as $city) {
            if ($city->id != $id || $id == null) {
                $cites[$city->code] = $city->name;
            }
        }

        $this->resetModel();

        return $cites;
    }

    public function getAllDistrictsByCodeCityForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = 'Chọn Quận/Huyện', $code_city = false)
    {
        if ($code_city) {
            $districtList = $this->model->where('code_city', '=', $code_city)->get($columns);
            $districts = array();
            if ($blank) $districts[0] = '-- ' . $defaultValue . ' --';
            foreach ($districtList as $district) {
                if ($district->id != $id || $id == null) {
                    $districts[$district->id] = $district->name;
                }
            }
        } else {
            if ($blank) $districts = [0=> '-- ' . $defaultValue . ' --'];
            $districts = array_merge($districts, $this->model->get(['*'])->pluck('name','id')->toArray());
        }

        $this->resetModel();

        return $districts;
    }

    public function getAllTeacherByCenterForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = "Chọn gia sư", $center_id = 0)
    {
        $teacherList = $this->model->where('center_id', '=', $center_id)->get($columns);
        $teachers = array();
        if ($blank) $teachers[0] = '-- ' . $defaultValue . ' --';
        foreach ($teacherList as $teacher) {
            if ($teacher->id != $id || $id == null) {
                $teachers[$teacher->id] = $teacher->name;
            }
        }

        $this->resetModel();

        return $teachers;
    }

    public function getAllDocumentByCategoryForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = "Chọn tài liệu", $category_id = 0)
    {
        $documentList = $this->model->join('document_categories', function ($join) {
            $join->on('documents.id', '=', 'document_categories.document_id');
        })->where('document_categories.category_id', '=', $category_id)->get($columns);
        $documents = array();
        if ($blank) $documents[0] = '-- ' . $defaultValue . ' --';
        foreach ($documentList as $document) {
            if ($document->id != $id || $id == null) {
                $documents[$document->id] = $document->name;
            }
        }

        $this->resetModel();

        return $documents;
    }

    public function getAllTestsByCategoryForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = "Chọn đề thi", $category_id = 0)
    {
        $testsList = $this->model->join('test_categories', function ($join) {
            $join->on('tests.id', '=', 'test_categories.test_id');
        })->where('test_categories.category_test_id', '=', $category_id)->get($columns);
        $tests = array();
        if ($blank) $tests[0] = '-- ' . $defaultValue . ' --';
        foreach ($testsList as $test) {
            if ($test->id != $id || $id == null) {
                $tests[$test->id] = $test->name;
            }
        }

        $this->resetModel();

        return $tests;
    }

    public function getAllNewsByCategoryForSelectBox($columns = ['*'], $id = null, $blank = true, $defaultValue = "Chọn tin tức", $category_id = 0)
    {
        $newsList = $this->model->join('news_categories', function ($join) {
            $join->on('news.id', '=', 'news_categories.news_id');
        })->where('news_categories.category_news_id', '=', $category_id)->get($columns);
        $news = array();
        if ($blank) $news[0] = '-- ' . $defaultValue . ' --';
        foreach ($newsList as $new) {
            if ($new->id != $id || $id == null) {
                $news[$new->id] = $new->name;
            }
        }

        $this->resetModel();

        return $news;
    }
}