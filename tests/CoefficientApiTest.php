<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoefficientApiTest extends TestCase
{
    use MakeCoefficientTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCoefficient()
    {
        $coefficient = $this->fakeCoefficientData();
        $this->json('POST', '/api/v1/coefficients', $coefficient);

        $this->assertApiResponse($coefficient);
    }

    /**
     * @test
     */
    public function testReadCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $this->json('GET', '/api/v1/coefficients/'.$coefficient->id);

        $this->assertApiResponse($coefficient->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $editedCoefficient = $this->fakeCoefficientData();

        $this->json('PUT', '/api/v1/coefficients/'.$coefficient->id, $editedCoefficient);

        $this->assertApiResponse($editedCoefficient);
    }

    /**
     * @test
     */
    public function testDeleteCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $this->json('DELETE', '/api/v1/coefficients/'.$coefficient->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/coefficients/'.$coefficient->id);

        $this->assertResponseStatus(404);
    }
}
