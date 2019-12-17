<?php

use Faker\Factory as Faker;
use App\Models\CategoryTest;
use App\Repositories\CategoryTestRepository;

trait MakeCategoryTestTrait
{
    /**
     * Create fake instance of CategoryTest and save it in database
     *
     * @param array $categoryTestFields
     * @return CategoryTest
     */
    public function makeCategoryTest($categoryTestFields = [])
    {
        /** @var CategoryTestRepository $categoryTestRepo */
        $categoryTestRepo = App::make(CategoryTestRepository::class);
        $theme = $this->fakeCategoryTestData($categoryTestFields);
        return $categoryTestRepo->create($theme);
    }

    /**
     * Get fake instance of CategoryTest
     *
     * @param array $categoryTestFields
     * @return CategoryTest
     */
    public function fakeCategoryTest($categoryTestFields = [])
    {
        return new CategoryTest($this->fakeCategoryTestData($categoryTestFields));
    }

    /**
     * Get fake data of CategoryTest
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryTestData($categoryTestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'parent_id' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryTestFields);
    }
}
