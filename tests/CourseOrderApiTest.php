<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseOrderApiTest extends TestCase
{
    use MakeCourseOrderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCourseOrder()
    {
        $courseOrder = $this->fakeCourseOrderData();
        $this->json('POST', '/api/v1/courseOrders', $courseOrder);

        $this->assertApiResponse($courseOrder);
    }

    /**
     * @test
     */
    public function testReadCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $this->json('GET', '/api/v1/courseOrders/'.$courseOrder->id);

        $this->assertApiResponse($courseOrder->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $editedCourseOrder = $this->fakeCourseOrderData();

        $this->json('PUT', '/api/v1/courseOrders/'.$courseOrder->id, $editedCourseOrder);

        $this->assertApiResponse($editedCourseOrder);
    }

    /**
     * @test
     */
    public function testDeleteCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $this->json('DELETE', '/api/v1/courseOrders/'.$courseOrder->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/courseOrders/'.$courseOrder->id);

        $this->assertResponseStatus(404);
    }
}
