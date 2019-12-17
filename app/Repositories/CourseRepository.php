<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository extends BGBaseRepository
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
        return Course::class;
    }

    public function result($pageSize) {
        $courses = $this->model->inRandomOrder()->paginate($pageSize);
        $this->resetModel();
        return $courses;
    }

    public function search($where, $categoryId = null) {
        $this->applyConditions($where);
        if(!empty($categoryId)){
            $news = $this->model->with('categories')->join('news_categories', function ($join) {
                $join->on('news.id', '=', 'news_categories.news_id');
            })->where('news_categories.category_news_id', $categoryId)->whereNull('news_categories.deleted_at')->paginate(18, ['news.*']);
        }else{
            $news = $this->model->with('categories')->paginate(18);
        }

        $this->resetModel();
        return $news;
    }

    public function getCourses($name = null){
        $courses = $this->model->where('name', 'LIKE', '%'.$name.'%')->orWhere('description', 'LIKE', '%'.$name.'%')->paginate(18);
        $this->resetModel();
        return $courses;
    }

    public function getRelatives($course) {
        $courses = $this->model->where('courses.id', '!=', $course->id)->limit(10)->get(['courses.*']);
        $this->resetModel();
        return $courses;
    }

    public function getCoursesByCategorySlug($categorySlug = null, $name = null){
        $courses = null;
        if (empty($categorySlug)) {
            $courses = $this->model->where('name', 'LIKE', '%'.$name.'%')->orWhere('description', 'LIKE', '%'.$name.'%')->whereHas('categories')->paginate(18);
        }
        else {
            $courses = $this->model->with('categories')->join('course_categories', function ($join) {
                $join->on('courses.id', '=', 'course_categories.course_id');
            })->join('category_courses', function ($join) {
                $join->on('category_courses.id', '=', 'course_categories.category_course_id');
            })->where(function($q) use ($name) {
                $q->where('courses.name', 'LIKE', '%'.$name.'%')
                    ->orWhere('courses.description', 'LIKE', '%'.$name.'%');
            })->where('category_courses.slug', $categorySlug)->whereNull('course_categories.deleted_at')->paginate(18, ['courses.*']);
        }

        $this->resetModel();
        return $courses;
    }
}
