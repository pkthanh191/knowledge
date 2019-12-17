<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GradeApiTest extends TestCase
{
    use MakeGradeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateGrade()
    {
        $grade = $this->fakeGradeData();
        $this->json('POST', '/api/v1/grades', $grade);

        $this->assertApiResponse($grade);
    }

    /**
     * @test
     */
    public function testReadGrade()
    {
        $grade = $this->makeGrade();
        $this->json('GET', '/api/v1/grades/'.$grade->id);

        $this->assertApiResponse($grade->toArray());
    }

    /**
     * @test
     */
    public function testUpdateGrade()
    {
        $grade = $this->makeGrade();
        $editedGrade = $this->fakeGradeData();

        $this->json('PUT', '/api/v1/grades/'.$grade->id, $editedGrade);

        $this->assertApiResponse($editedGrade);
    }

    /**
     * @test
     */
    public function testDeleteGrade()
    {
        $grade = $this->makeGrade();
        $this->json('DELETE', '/api/v1/grades/'.$grade->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/grades/'.$grade->id);

        $this->assertResponseStatus(404);
    }
}
