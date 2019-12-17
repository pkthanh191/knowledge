<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CenterApiTest extends TestCase
{
    use MakeCenterTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCenter()
    {
        $center = $this->fakeCenterData();
        $this->json('POST', '/api/v1/centers', $center);

        $this->assertApiResponse($center);
    }

    /**
     * @test
     */
    public function testReadCenter()
    {
        $center = $this->makeCenter();
        $this->json('GET', '/api/v1/centers/'.$center->id);

        $this->assertApiResponse($center->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCenter()
    {
        $center = $this->makeCenter();
        $editedCenter = $this->fakeCenterData();

        $this->json('PUT', '/api/v1/centers/'.$center->id, $editedCenter);

        $this->assertApiResponse($editedCenter);
    }

    /**
     * @test
     */
    public function testDeleteCenter()
    {
        $center = $this->makeCenter();
        $this->json('DELETE', '/api/v1/centers/'.$center->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/centers/'.$center->id);

        $this->assertResponseStatus(404);
    }
}
