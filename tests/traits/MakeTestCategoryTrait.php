<?php

use Faker\Factory as Faker;
use App\Models\TestCategory;
use App\Repositories\TestCategoryRepository;

trait MakeTestCategoryTrait
{
    /**
     * Create fake instance of TestCategory and save it in database
     *
     * @param array $testCategoryFields
     * @return TestCategory
     */
    public function makeTestCategory($testCategoryFields = [])
    {
        /** @var TestCategoryRepository $testCategoryRepo */
        $testCategoryRepo = App::make(TestCategoryRepository::class);
        $theme = $this->fakeTestCategoryData($testCategoryFields);
        return $testCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of TestCategory
     *
     * @param array $testCategoryFields
     * @return TestCategory
     */
    public function fakeTestCategory($testCategoryFields = [])
    {
        return new TestCategory($this->fakeTestCategoryData($testCategoryFields));
    }

    /**
     * Get fake data of TestCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTestCategoryData($testCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'category_test_id' => $fake->randomDigitNotNull,
            'test_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $testCategoryFields);
    }
}
