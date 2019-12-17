<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BGBaseRepository
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
        return News::class;
    }

    public function search($where)
    {
        $this->applyConditions($where);
        return $this->paginate(15);
    }

    public function getNewsByCategorySlug($categorySlug = null, $name = null, $page = 16)
    {
        $news = null;
        if (empty($categorySlug)) {
            $news = $this->model->where('name', 'LIKE', '%' . $name . '%')->orWhere('description', 'LIKE', '%' . $name . '%')->whereHas('categories')->paginate($page);
        } else {
            $news = $this->model->with('categories')->join('news_categories', function ($join) {
                $join->on('news.id', '=', 'news_categories.news_id');
            })->join('category_news', function ($join) {
                $join->on('category_news.id', '=', 'news_categories.category_news_id');
            })->where(function ($q) use ($name) {
                $q->where('news.name', 'LIKE', '%' . $name . '%')
                    ->orWhere('news.description', 'LIKE', '%' . $name . '%');
            })->where('category_news.slug', $categorySlug)->whereNull('news_categories.deleted_at')->paginate($page, ['news.*']);
        }

        $this->resetModel();
        return $news;
    }

    public function getRelatives($new)
    {
        $news = $this->model->where('news.id', '!=', $new->id)->limit(10)->get(['news.*']);

        $this->resetModel();
        return $news;
    }

    public function getNewsByUser($user)
    {
        $news = $this->model->join('comment_news', function ($join) {
            $join->on('news.id', '=', 'comment_news.news_id');
        })->where('comment_news.user_id', '=', $user)->distinct()->get(['news.*']);

        $this->resetModel();
        return $news;
    }

    public function getNewsByComment($category_id = null)
    {
        if ($category_id == null){
            $news = $this->model->join('comment_news', function ($join) {
                $join->on('news.id', '=', 'comment_news.news_id');
            })->distinct()->orderBy('updated_at', 'desc')->get(['news.*']);
        }
        else {
            $news = $this->model->join('comment_news', function ($join) {
                $join->on('news.id', '=', 'comment_news.news_id');
            })->join('news_categories', function ($join) {
                $join->on('news.id', '=', 'news_categories.news_id');
            })->where('news_categories.category_news_id', '=', $category_id)->distinct()->orderBy('updated_at', 'desc')->get(['news.*']);
        }

        $this->resetModel();
        return $news;
    }
}
