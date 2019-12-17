<?php

use Faker\Factory as Faker;
use App\Models\CourseOrder;
use App\Repositories\CourseOrderRepository;

trait MakeCourseOrderTrait
{
    /**
     * Create fake instance of CourseOrder and save it in database
     *
     * @param array $courseOrderFields
     * @return CourseOrder
     */
    public function makeCourseOrder($courseOrderFields = [])
    {
        /** @var CourseOrderRepository $courseOrderRepo */
        $courseOrderRepo = App::make(CourseOrderRepository::class);
        $theme = $this->fakeCourseOrderData($courseOrderFields);
        return $courseOrderRepo->create($theme);
    }

    /**
     * Get fake instance of CourseOrder
     *
     * @param array $courseOrderFields
     * @return CourseOrder
     */
    public function fakeCourseOrder($courseOrderFields = [])
    {
        return new CourseOrder($this->fakeCourseOrderData($courseOrderFields));
    }

    /**
     * Get fake data of CourseOrder
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCourseOrderData($courseOrderFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->text,
            'user_id' => $fake->randomDigitNotNull,
            'course_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $courseOrderFields);
    }
}
