<?php

use Faker\Factory as Faker;
use App\Models\Page;
use App\Repositories\PageRepository;

trait MakePageTrait
{
    /**
     * Create fake instance of Page and save it in database
     *
     * @param array $pageFields
     * @return Page
     */
    public function makePage($pageFields = [])
    {
        /** @var PageRepository $pageRepo */
        $pageRepo = App::make(PageRepository::class);
        $theme = $this->fakePageData($pageFields);
        return $pageRepo->create($theme);
    }

    /**
     * Get fake instance of Page
     *
     * @param array $pageFields
     * @return Page
     */
    public function fakePage($pageFields = [])
    {
        return new Page($this->fakePageData($pageFields));
    }

    /**
     * Get fake data of Page
     *
     * @param array $postFields
     * @return array
     */
    public function fakePageData($pageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'slug' => $fake->word,
            'meta_title' => $fake->word,
            'meta_keywords' => $fake->word,
            'meta_description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $pageFields);
    }
}
