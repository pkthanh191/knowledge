<?php

use Faker\Factory as Faker;
use App\Models\CourseCategory;
use App\Repositories\CourseCategoryRepository;

trait MakeCourseCategoryTrait
{
    /**
     * Create fake instance of CourseCategory and save it in database
     *
     * @param array $courseCategoryFields
     * @return CourseCategory
     */
    public function makeCourseCategory($courseCategoryFields = [])
    {
        /** @var CourseCategoryRepository $courseCategoryRepo */
        $courseCategoryRepo = App::make(CourseCategoryRepository::class);
        $theme = $this->fakeCourseCategoryData($courseCategoryFields);
        return $courseCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of CourseCategory
     *
     * @param array $courseCategoryFields
     * @return CourseCategory
     */
    public function fakeCourseCategory($courseCategoryFields = [])
    {
        return new CourseCategory($this->fakeCourseCategoryData($courseCategoryFields));
    }

    /**
     * Get fake data of CourseCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCourseCategoryData($courseCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'category_course_id' => $fake->randomDigitNotNull,
            'course_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $courseCategoryFields);
    }
}
