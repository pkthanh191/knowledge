<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryDocMetaApiTest extends TestCase
{
    use MakeCategoryDocMetaTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryDocMeta()
    {
        $categoryDocMeta = $this->fakeCategoryDocMetaData();
        $this->json('POST', '/api/v1/categoryDocMetas', $categoryDocMeta);

        $this->assertApiResponse($categoryDocMeta);
    }

    /**
     * @test
     */
    public function testReadCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $this->json('GET', '/api/v1/categoryDocMetas/'.$categoryDocMeta->id);

        $this->assertApiResponse($categoryDocMeta->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $editedCategoryDocMeta = $this->fakeCategoryDocMetaData();

        $this->json('PUT', '/api/v1/categoryDocMetas/'.$categoryDocMeta->id, $editedCategoryDocMeta);

        $this->assertApiResponse($editedCategoryDocMeta);
    }

    /**
     * @test
     */
    public function testDeleteCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $this->json('DELETE', '/api/v1/categoryDocMetas/'.$categoryDocMeta->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryDocMetas/'.$categoryDocMeta->id);

        $this->assertResponseStatus(404);
    }
}
