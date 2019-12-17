<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TutorialApiTest extends TestCase
{
    use MakeTutorialTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTutorial()
    {
        $tutorial = $this->fakeTutorialData();
        $this->json('POST', '/api/v1/tutorials', $tutorial);

        $this->assertApiResponse($tutorial);
    }

    /**
     * @test
     */
    public function testReadTutorial()
    {
        $tutorial = $this->makeTutorial();
        $this->json('GET', '/api/v1/tutorials/'.$tutorial->id);

        $this->assertApiResponse($tutorial->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTutorial()
    {
        $tutorial = $this->makeTutorial();
        $editedTutorial = $this->fakeTutorialData();

        $this->json('PUT', '/api/v1/tutorials/'.$tutorial->id, $editedTutorial);

        $this->assertApiResponse($editedTutorial);
    }

    /**
     * @test
     */
    public function testDeleteTutorial()
    {
        $tutorial = $this->makeTutorial();
        $this->json('DELETE', '/api/v1/tutorials/'.$tutorial->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/tutorials/'.$tutorial->id);

        $this->assertResponseStatus(404);
    }
}
