<?php

use Faker\Factory as Faker;
use App\Models\DocumentCategory;
use App\Repositories\DocumentCategoryRepository;

trait MakeDocumentCategoryTrait
{
    /**
     * Create fake instance of DocumentCategory and save it in database
     *
     * @param array $documentCategoryFields
     * @return DocumentCategory
     */
    public function makeDocumentCategory($documentCategoryFields = [])
    {
        /** @var DocumentCategoryRepository $documentCategoryRepo */
        $documentCategoryRepo = App::make(DocumentCategoryRepository::class);
        $theme = $this->fakeDocumentCategoryData($documentCategoryFields);
        return $documentCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of DocumentCategory
     *
     * @param array $documentCategoryFields
     * @return DocumentCategory
     */
    public function fakeDocumentCategory($documentCategoryFields = [])
    {
        return new DocumentCategory($this->fakeDocumentCategoryData($documentCategoryFields));
    }

    /**
     * Get fake data of DocumentCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDocumentCategoryData($documentCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'category_id' => $fake->randomDigitNotNull,
            'document_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $documentCategoryFields);
    }
}
