<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentNewsApiTest extends TestCase
{
    use MakeCommentNewsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCommentNews()
    {
        $commentNews = $this->fakeCommentNewsData();
        $this->json('POST', '/api/v1/commentNews', $commentNews);

        $this->assertApiResponse($commentNews);
    }

    /**
     * @test
     */
    public function testReadCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $this->json('GET', '/api/v1/commentNews/'.$commentNews->id);

        $this->assertApiResponse($commentNews->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $editedCommentNews = $this->fakeCommentNewsData();

        $this->json('PUT', '/api/v1/commentNews/'.$commentNews->id, $editedCommentNews);

        $this->assertApiResponse($editedCommentNews);
    }

    /**
     * @test
     */
    public function testDeleteCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $this->json('DELETE', '/api/v1/commentNews/'.$commentNews->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/commentNews/'.$commentNews->id);

        $this->assertResponseStatus(404);
    }
}
