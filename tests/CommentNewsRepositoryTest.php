<?php

use App\Models\CommentNews;
use App\Repositories\CommentNewsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentNewsRepositoryTest extends TestCase
{
    use MakeCommentNewsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CommentNewsRepository
     */
    protected $commentNewsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->commentNewsRepo = App::make(CommentNewsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCommentNews()
    {
        $commentNews = $this->fakeCommentNewsData();
        $createdCommentNews = $this->commentNewsRepo->create($commentNews);
        $createdCommentNews = $createdCommentNews->toArray();
        $this->assertArrayHasKey('id', $createdCommentNews);
        $this->assertNotNull($createdCommentNews['id'], 'Created CommentNews must have id specified');
        $this->assertNotNull(CommentNews::find($createdCommentNews['id']), 'CommentNews with given id must be in DB');
        $this->assertModelData($commentNews, $createdCommentNews);
    }

    /**
     * @test read
     */
    public function testReadCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $dbCommentNews = $this->commentNewsRepo->find($commentNews->id);
        $dbCommentNews = $dbCommentNews->toArray();
        $this->assertModelData($commentNews->toArray(), $dbCommentNews);
    }

    /**
     * @test update
     */
    public function testUpdateCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $fakeCommentNews = $this->fakeCommentNewsData();
        $updatedCommentNews = $this->commentNewsRepo->update($fakeCommentNews, $commentNews->id);
        $this->assertModelData($fakeCommentNews, $updatedCommentNews->toArray());
        $dbCommentNews = $this->commentNewsRepo->find($commentNews->id);
        $this->assertModelData($fakeCommentNews, $dbCommentNews->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCommentNews()
    {
        $commentNews = $this->makeCommentNews();
        $resp = $this->commentNewsRepo->delete($commentNews->id);
        $this->assertTrue($resp);
        $this->assertNull(CommentNews::find($commentNews->id), 'CommentNews should not exist in DB');
    }
}
