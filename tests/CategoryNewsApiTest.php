<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryNewsApiTest extends TestCase
{
    use MakeCategoryNewsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryNews()
    {
        $categoryNews = $this->fakeCategoryNewsData();
        $this->json('POST', '/api/v1/categoryNews', $categoryNews);

        $this->assertApiResponse($categoryNews);
    }

    /**
     * @test
     */
    public function testReadCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $this->json('GET', '/api/v1/categoryNews/'.$categoryNews->id);

        $this->assertApiResponse($categoryNews->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $editedCategoryNews = $this->fakeCategoryNewsData();

        $this->json('PUT', '/api/v1/categoryNews/'.$categoryNews->id, $editedCategoryNews);

        $this->assertApiResponse($editedCategoryNews);
    }

    /**
     * @test
     */
    public function testDeleteCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $this->json('DELETE', '/api/v1/categoryNews/'.$categoryNews->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryNews/'.$categoryNews->id);

        $this->assertResponseStatus(404);
    }
}
