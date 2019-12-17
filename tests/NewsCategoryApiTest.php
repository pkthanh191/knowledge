<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsCategoryApiTest extends TestCase
{
    use MakeNewsCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNewsCategory()
    {
        $newsCategory = $this->fakeNewsCategoryData();
        $this->json('POST', '/api/v1/newsCategories', $newsCategory);

        $this->assertApiResponse($newsCategory);
    }

    /**
     * @test
     */
    public function testReadNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $this->json('GET', '/api/v1/newsCategories/'.$newsCategory->id);

        $this->assertApiResponse($newsCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $editedNewsCategory = $this->fakeNewsCategoryData();

        $this->json('PUT', '/api/v1/newsCategories/'.$newsCategory->id, $editedNewsCategory);

        $this->assertApiResponse($editedNewsCategory);
    }

    /**
     * @test
     */
    public function testDeleteNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $this->json('DELETE', '/api/v1/newsCategories/'.$newsCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/newsCategories/'.$newsCategory->id);

        $this->assertResponseStatus(404);
    }
}
