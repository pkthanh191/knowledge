<?php

use Faker\Factory as Faker;
use App\Models\NewsCategory;
use App\Repositories\NewsCategoryRepository;

trait MakeNewsCategoryTrait
{
    /**
     * Create fake instance of NewsCategory and save it in database
     *
     * @param array $newsCategoryFields
     * @return NewsCategory
     */
    public function makeNewsCategory($newsCategoryFields = [])
    {
        /** @var NewsCategoryRepository $newsCategoryRepo */
        $newsCategoryRepo = App::make(NewsCategoryRepository::class);
        $theme = $this->fakeNewsCategoryData($newsCategoryFields);
        return $newsCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of NewsCategory
     *
     * @param array $newsCategoryFields
     * @return NewsCategory
     */
    public function fakeNewsCategory($newsCategoryFields = [])
    {
        return new NewsCategory($this->fakeNewsCategoryData($newsCategoryFields));
    }

    /**
     * Get fake data of NewsCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNewsCategoryData($newsCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'category_news_id' => $fake->randomDigitNotNull,
            'news_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $newsCategoryFields);
    }
}
