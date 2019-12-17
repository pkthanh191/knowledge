<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectApiTest extends TestCase
{
    use MakeSubjectTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSubject()
    {
        $subject = $this->fakeSubjectData();
        $this->json('POST', '/api/v1/subjects', $subject);

        $this->assertApiResponse($subject);
    }

    /**
     * @test
     */
    public function testReadSubject()
    {
        $subject = $this->makeSubject();
        $this->json('GET', '/api/v1/subjects/'.$subject->id);

        $this->assertApiResponse($subject->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSubject()
    {
        $subject = $this->makeSubject();
        $editedSubject = $this->fakeSubjectData();

        $this->json('PUT', '/api/v1/subjects/'.$subject->id, $editedSubject);

        $this->assertApiResponse($editedSubject);
    }

    /**
     * @test
     */
    public function testDeleteSubject()
    {
        $subject = $this->makeSubject();
        $this->json('DELETE', '/api/v1/subjects/'.$subject->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/subjects/'.$subject->id);

        $this->assertResponseStatus(404);
    }
}
