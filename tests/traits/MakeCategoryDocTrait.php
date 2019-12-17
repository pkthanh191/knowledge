<?php

use Faker\Factory as Faker;
use App\Models\CategoryDoc;
use App\Repositories\CategoryDocRepository;

trait MakeCategoryDocTrait
{
    /**
     * Create fake instance of CategoryDoc and save it in database
     *
     * @param array $categoryDocFields
     * @return CategoryDoc
     */
    public function makeCategoryDoc($categoryDocFields = [])
    {
        /** @var CategoryDocRepository $categoryDocRepo */
        $categoryDocRepo = App::make(CategoryDocRepository::class);
        $theme = $this->fakeCategoryDocData($categoryDocFields);
        return $categoryDocRepo->create($theme);
    }

    /**
     * Get fake instance of CategoryDoc
     *
     * @param array $categoryDocFields
     * @return CategoryDoc
     */
    public function fakeCategoryDoc($categoryDocFields = [])
    {
        return new CategoryDoc($this->fakeCategoryDocData($categoryDocFields));
    }

    /**
     * Get fake data of CategoryDoc
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryDocData($categoryDocFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'parent_id' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryDocFields);
    }
}
