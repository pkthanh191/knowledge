<?php

use Faker\Factory as Faker;
use App\Models\DocumentMetaValue;
use App\Repositories\DocumentMetaValueRepository;

trait MakeDocumentMetaValueTrait
{
    /**
     * Create fake instance of DocumentMetaValue and save it in database
     *
     * @param array $documentMetaValueFields
     * @return DocumentMetaValue
     */
    public function makeDocumentMetaValue($documentMetaValueFields = [])
    {
        /** @var DocumentMetaValueRepository $documentMetaValueRepo */
        $documentMetaValueRepo = App::make(DocumentMetaValueRepository::class);
        $theme = $this->fakeDocumentMetaValueData($documentMetaValueFields);
        return $documentMetaValueRepo->create($theme);
    }

    /**
     * Get fake instance of DocumentMetaValue
     *
     * @param array $documentMetaValueFields
     * @return DocumentMetaValue
     */
    public function fakeDocumentMetaValue($documentMetaValueFields = [])
    {
        return new DocumentMetaValue($this->fakeDocumentMetaValueData($documentMetaValueFields));
    }

    /**
     * Get fake data of DocumentMetaValue
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDocumentMetaValueData($documentMetaValueFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'doc_id' => $fake->randomDigitNotNull,
            'doc_meta_id' => $fake->randomDigitNotNull,
            'value' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $documentMetaValueFields);
    }
}
