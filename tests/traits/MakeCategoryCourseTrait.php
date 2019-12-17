<?php

use Faker\Factory as Faker;
use App\Models\CategoryCourse;
use App\Repositories\CategoryCourseRepository;

trait MakeCategoryCourseTrait
{
    /**
     * Create fake instance of CategoryCourse and save it in database
     *
     * @param array $categoryCourseFields
     * @return CategoryCourse
     */
    public function makeCategoryCourse($categoryCourseFields = [])
    {
        /** @var CategoryCourseRepository $categoryCourseRepo */
        $categoryCourseRepo = App::make(CategoryCourseRepository::class);
        $theme = $this->fakeCategoryCourseData($categoryCourseFields);
        return $categoryCourseRepo->create($theme);
    }

    /**
     * Get fake instance of CategoryCourse
     *
     * @param array $categoryCourseFields
     * @return CategoryCourse
     */
    public function fakeCategoryCourse($categoryCourseFields = [])
    {
        return new CategoryCourse($this->fakeCategoryCourseData($categoryCourseFields));
    }

    /**
     * Get fake data of CategoryCourse
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryCourseData($categoryCourseFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'category_course_type' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryCourseFields);
    }
}
