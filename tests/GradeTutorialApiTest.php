<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GradeTutorialApiTest extends TestCase
{
    use MakeGradeTutorialTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateGradeTutorial()
    {
        $gradeTutorial = $this->fakeGradeTutorialData();
        $this->json('POST', '/api/v1/gradeTutorials', $gradeTutorial);

        $this->assertApiResponse($gradeTutorial);
    }

    /**
     * @test
     */
    public function testReadGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $this->json('GET', '/api/v1/gradeTutorials/'.$gradeTutorial->id);

        $this->assertApiResponse($gradeTutorial->toArray());
    }

    /**
     * @test
     */
    public function testUpdateGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $editedGradeTutorial = $this->fakeGradeTutorialData();

        $this->json('PUT', '/api/v1/gradeTutorials/'.$gradeTutorial->id, $editedGradeTutorial);

        $this->assertApiResponse($editedGradeTutorial);
    }

    /**
     * @test
     */
    public function testDeleteGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $this->json('DELETE', '/api/v1/gradeTutorials/'.$gradeTutorial->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/gradeTutorials/'.$gradeTutorial->id);

        $this->assertResponseStatus(404);
    }
}
