<?php

use Faker\Factory as Faker;
use App\Models\Test;
use App\Repositories\TestRepository;

trait MakeTestTrait
{
    /**
     * Create fake instance of Test and save it in database
     *
     * @param array $testFields
     * @return Test
     */
    public function makeTest($testFields = [])
    {
        /** @var TestRepository $testRepo */
        $testRepo = App::make(TestRepository::class);
        $theme = $this->fakeTestData($testFields);
        return $testRepo->create($theme);
    }

    /**
     * Get fake instance of Test
     *
     * @param array $testFields
     * @return Test
     */
    public function fakeTest($testFields = [])
    {
        return new Test($this->fakeTestData($testFields));
    }

    /**
     * Get fake data of Test
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTestData($testFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'slug' => $fake->word,
            'comment_counts' => $fake->randomDigitNotNull,
            'view_counts' => $fake->randomDigitNotNull,
            'duration' => $fake->randomDigitNotNull,
            'image' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $testFields);
    }
}
