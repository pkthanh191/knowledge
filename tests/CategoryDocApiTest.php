<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryDocApiTest extends TestCase
{
    use MakeCategoryDocTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryDoc()
    {
        $categoryDoc = $this->fakeCategoryDocData();
        $this->json('POST', '/api/v1/categoryDocs', $categoryDoc);

        $this->assertApiResponse($categoryDoc);
    }

    /**
     * @test
     */
    public function testReadCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $this->json('GET', '/api/v1/categoryDocs/'.$categoryDoc->id);

        $this->assertApiResponse($categoryDoc->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $editedCategoryDoc = $this->fakeCategoryDocData();

        $this->json('PUT', '/api/v1/categoryDocs/'.$categoryDoc->id, $editedCategoryDoc);

        $this->assertApiResponse($editedCategoryDoc);
    }

    /**
     * @test
     */
    public function testDeleteCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $this->json('DELETE', '/api/v1/categoryDocs/'.$categoryDoc->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryDocs/'.$categoryDoc->id);

        $this->assertResponseStatus(404);
    }
}
