<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectTutorialApiTest extends TestCase
{
    use MakeSubjectTutorialTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSubjectTutorial()
    {
        $subjectTutorial = $this->fakeSubjectTutorialData();
        $this->json('POST', '/api/v1/subjectTutorials', $subjectTutorial);

        $this->assertApiResponse($subjectTutorial);
    }

    /**
     * @test
     */
    public function testReadSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $this->json('GET', '/api/v1/subjectTutorials/'.$subjectTutorial->id);

        $this->assertApiResponse($subjectTutorial->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $editedSubjectTutorial = $this->fakeSubjectTutorialData();

        $this->json('PUT', '/api/v1/subjectTutorials/'.$subjectTutorial->id, $editedSubjectTutorial);

        $this->assertApiResponse($editedSubjectTutorial);
    }

    /**
     * @test
     */
    public function testDeleteSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $this->json('DELETE', '/api/v1/subjectTutorials/'.$subjectTutorial->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/subjectTutorials/'.$subjectTutorial->id);

        $this->assertResponseStatus(404);
    }
}
