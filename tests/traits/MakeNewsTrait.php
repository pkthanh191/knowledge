<?php

use Faker\Factory as Faker;
use App\Models\News;
use App\Repositories\NewsRepository;

trait MakeNewsTrait
{
    /**
     * Create fake instance of News and save it in database
     *
     * @param array $newsFields
     * @return News
     */
    public function makeNews($newsFields = [])
    {
        /** @var NewsRepository $newsRepo */
        $newsRepo = App::make(NewsRepository::class);
        $theme = $this->fakeNewsData($newsFields);
        return $newsRepo->create($theme);
    }

    /**
     * Get fake instance of News
     *
     * @param array $newsFields
     * @return News
     */
    public function fakeNews($newsFields = [])
    {
        return new News($this->fakeNewsData($newsFields));
    }

    /**
     * Get fake data of News
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNewsData($newsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'slug' => $fake->word,
            'image' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $newsFields);
    }
}
