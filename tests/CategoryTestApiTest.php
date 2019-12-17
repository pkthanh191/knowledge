<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTestApiTest extends TestCase
{
    use MakeCategoryTestTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryTest()
    {
        $categoryTest = $this->fakeCategoryTestData();
        $this->json('POST', '/api/v1/categoryTests', $categoryTest);

        $this->assertApiResponse($categoryTest);
    }

    /**
     * @test
     */
    public function testReadCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $this->json('GET', '/api/v1/categoryTests/'.$categoryTest->id);

        $this->assertApiResponse($categoryTest->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $editedCategoryTest = $this->fakeCategoryTestData();

        $this->json('PUT', '/api/v1/categoryTests/'.$categoryTest->id, $editedCategoryTest);

        $this->assertApiResponse($editedCategoryTest);
    }

    /**
     * @test
     */
    public function testDeleteCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $this->json('DELETE', '/api/v1/categoryTests/'.$categoryTest->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryTests/'.$categoryTest->id);

        $this->assertResponseStatus(404);
    }
}
