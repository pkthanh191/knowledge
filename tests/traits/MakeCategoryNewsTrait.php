<?php

use Faker\Factory as Faker;
use App\Models\CategoryNews;
use App\Repositories\CategoryNewsRepository;

trait MakeCategoryNewsTrait
{
    /**
     * Create fake instance of CategoryNews and save it in database
     *
     * @param array $categoryNewsFields
     * @return CategoryNews
     */
    public function makeCategoryNews($categoryNewsFields = [])
    {
        /** @var CategoryNewsRepository $categoryNewsRepo */
        $categoryNewsRepo = App::make(CategoryNewsRepository::class);
        $theme = $this->fakeCategoryNewsData($categoryNewsFields);
        return $categoryNewsRepo->create($theme);
    }

    /**
     * Get fake instance of CategoryNews
     *
     * @param array $categoryNewsFields
     * @return CategoryNews
     */
    public function fakeCategoryNews($categoryNewsFields = [])
    {
        return new CategoryNews($this->fakeCategoryNewsData($categoryNewsFields));
    }

    /**
     * Get fake data of CategoryNews
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryNewsData($categoryNewsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'slug' => $fake->word,
            'parent_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryNewsFields);
    }
}
