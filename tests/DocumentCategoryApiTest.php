<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentCategoryApiTest extends TestCase
{
    use MakeDocumentCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDocumentCategory()
    {
        $documentCategory = $this->fakeDocumentCategoryData();
        $this->json('POST', '/api/v1/documentCategories', $documentCategory);

        $this->assertApiResponse($documentCategory);
    }

    /**
     * @test
     */
    public function testReadDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $this->json('GET', '/api/v1/documentCategories/'.$documentCategory->id);

        $this->assertApiResponse($documentCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $editedDocumentCategory = $this->fakeDocumentCategoryData();

        $this->json('PUT', '/api/v1/documentCategories/'.$documentCategory->id, $editedDocumentCategory);

        $this->assertApiResponse($editedDocumentCategory);
    }

    /**
     * @test
     */
    public function testDeleteDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $this->json('DELETE', '/api/v1/documentCategories/'.$documentCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/documentCategories/'.$documentCategory->id);

        $this->assertResponseStatus(404);
    }
}
