<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseCategoryApiTest extends TestCase
{
    use MakeCourseCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCourseCategory()
    {
        $courseCategory = $this->fakeCourseCategoryData();
        $this->json('POST', '/api/v1/courseCategories', $courseCategory);

        $this->assertApiResponse($courseCategory);
    }

    /**
     * @test
     */
    public function testReadCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $this->json('GET', '/api/v1/courseCategories/'.$courseCategory->id);

        $this->assertApiResponse($courseCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $editedCourseCategory = $this->fakeCourseCategoryData();

        $this->json('PUT', '/api/v1/courseCategories/'.$courseCategory->id, $editedCourseCategory);

        $this->assertApiResponse($editedCourseCategory);
    }

    /**
     * @test
     */
    public function testDeleteCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $this->json('DELETE', '/api/v1/courseCategories/'.$courseCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/courseCategories/'.$courseCategory->id);

        $this->assertResponseStatus(404);
    }
}
