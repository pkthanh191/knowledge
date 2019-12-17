<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryCourseApiTest extends TestCase
{
    use MakeCategoryCourseTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryCourse()
    {
        $categoryCourse = $this->fakeCategoryCourseData();
        $this->json('POST', '/api/v1/categoryCourses', $categoryCourse);

        $this->assertApiResponse($categoryCourse);
    }

    /**
     * @test
     */
    public function testReadCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $this->json('GET', '/api/v1/categoryCourses/'.$categoryCourse->id);

        $this->assertApiResponse($categoryCourse->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $editedCategoryCourse = $this->fakeCategoryCourseData();

        $this->json('PUT', '/api/v1/categoryCourses/'.$categoryCourse->id, $editedCategoryCourse);

        $this->assertApiResponse($editedCategoryCourse);
    }

    /**
     * @test
     */
    public function testDeleteCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $this->json('DELETE', '/api/v1/categoryCourses/'.$categoryCourse->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryCourses/'.$categoryCourse->id);

        $this->assertResponseStatus(404);
    }
}
