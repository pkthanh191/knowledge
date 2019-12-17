<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTestApiTest extends TestCase
{
    use MakeCommentTestTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCommentTest()
    {
        $commentTest = $this->fakeCommentTestData();
        $this->json('POST', '/api/v1/commentTests', $commentTest);

        $this->assertApiResponse($commentTest);
    }

    /**
     * @test
     */
    public function testReadCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $this->json('GET', '/api/v1/commentTests/'.$commentTest->id);

        $this->assertApiResponse($commentTest->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $editedCommentTest = $this->fakeCommentTestData();

        $this->json('PUT', '/api/v1/commentTests/'.$commentTest->id, $editedCommentTest);

        $this->assertApiResponse($editedCommentTest);
    }

    /**
     * @test
     */
    public function testDeleteCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $this->json('DELETE', '/api/v1/commentTests/'.$commentTest->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/commentTests/'.$commentTest->id);

        $this->assertResponseStatus(404);
    }
}
