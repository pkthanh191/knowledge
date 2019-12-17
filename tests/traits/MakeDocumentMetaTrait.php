<?php

use Faker\Factory as Faker;
use App\Models\DocumentMeta;
use App\Repositories\DocumentMetaRepository;

trait MakeDocumentMetaTrait
{
    /**
     * Create fake instance of DocumentMeta and save it in database
     *
     * @param array $documentMetaFields
     * @return DocumentMeta
     */
    public function makeDocumentMeta($documentMetaFields = [])
    {
        /** @var DocumentMetaRepository $documentMetaRepo */
        $documentMetaRepo = App::make(DocumentMetaRepository::class);
        $theme = $this->fakeDocumentMetaData($documentMetaFields);
        return $documentMetaRepo->create($theme);
    }

    /**
     * Get fake instance of DocumentMeta
     *
     * @param array $documentMetaFields
     * @return DocumentMeta
     */
    public function fakeDocumentMeta($documentMetaFields = [])
    {
        return new DocumentMeta($this->fakeDocumentMetaData($documentMetaFields));
    }

    /**
     * Get fake data of DocumentMeta
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDocumentMetaData($documentMetaFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'user_id' => $fake->randomDigitNotNull,
            'category_doc_meta_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $documentMetaFields);
    }
}
