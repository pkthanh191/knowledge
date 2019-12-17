<?php

use Faker\Factory as Faker;
use App\Models\CategoryDocMeta;
use App\Repositories\CategoryDocMetaRepository;

trait MakeCategoryDocMetaTrait
{
    /**
     * Create fake instance of CategoryDocMeta and save it in database
     *
     * @param array $categoryDocMetaFields
     * @return CategoryDocMeta
     */
    public function makeCategoryDocMeta($categoryDocMetaFields = [])
    {
        /** @var CategoryDocMetaRepository $categoryDocMetaRepo */
        $categoryDocMetaRepo = App::make(CategoryDocMetaRepository::class);
        $theme = $this->fakeCategoryDocMetaData($categoryDocMetaFields);
        return $categoryDocMetaRepo->create($theme);
    }

    /**
     * Get fake instance of CategoryDocMeta
     *
     * @param array $categoryDocMetaFields
     * @return CategoryDocMeta
     */
    public function fakeCategoryDocMeta($categoryDocMetaFields = [])
    {
        return new CategoryDocMeta($this->fakeCategoryDocMetaData($categoryDocMetaFields));
    }

    /**
     * Get fake data of CategoryDocMeta
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryDocMetaData($categoryDocMetaFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'slug' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryDocMetaFields);
    }
}
