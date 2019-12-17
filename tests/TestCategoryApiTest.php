<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCategoryApiTest extends TestCase
{
    use MakeTestCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTestCategory()
    {
        $testCategory = $this->fakeTestCategoryData();
        $this->json('POST', '/api/v1/testCategories', $testCategory);

        $this->assertApiResponse($testCategory);
    }

    /**
     * @test
     */
    public function testReadTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $this->json('GET', '/api/v1/testCategories/'.$testCategory->id);

        $this->assertApiResponse($testCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $editedTestCategory = $this->fakeTestCategoryData();

        $this->json('PUT', '/api/v1/testCategories/'.$testCategory->id, $editedTestCategory);

        $this->assertApiResponse($editedTestCategory);
    }

    /**
     * @test
     */
    public function testDeleteTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $this->json('DELETE', '/api/v1/testCategories/'.$testCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/testCategories/'.$testCategory->id);

        $this->assertResponseStatus(404);
    }
}
