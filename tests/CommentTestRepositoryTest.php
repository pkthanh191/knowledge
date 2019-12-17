<?php

use App\Models\CommentTest;
use App\Repositories\CommentTestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTestRepositoryTest extends TestCase
{
    use MakeCommentTestTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CommentTestRepository
     */
    protected $commentTestRepo;

    public function setUp()
    {
        parent::setUp();
        $this->commentTestRepo = App::make(CommentTestRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCommentTest()
    {
        $commentTest = $this->fakeCommentTestData();
        $createdCommentTest = $this->commentTestRepo->create($commentTest);
        $createdCommentTest = $createdCommentTest->toArray();
        $this->assertArrayHasKey('id', $createdCommentTest);
        $this->assertNotNull($createdCommentTest['id'], 'Created CommentTest must have id specified');
        $this->assertNotNull(CommentTest::find($createdCommentTest['id']), 'CommentTest with given id must be in DB');
        $this->assertModelData($commentTest, $createdCommentTest);
    }

    /**
     * @test read
     */
    public function testReadCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $dbCommentTest = $this->commentTestRepo->find($commentTest->id);
        $dbCommentTest = $dbCommentTest->toArray();
        $this->assertModelData($commentTest->toArray(), $dbCommentTest);
    }

    /**
     * @test update
     */
    public function testUpdateCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $fakeCommentTest = $this->fakeCommentTestData();
        $updatedCommentTest = $this->commentTestRepo->update($fakeCommentTest, $commentTest->id);
        $this->assertModelData($fakeCommentTest, $updatedCommentTest->toArray());
        $dbCommentTest = $this->commentTestRepo->find($commentTest->id);
        $this->assertModelData($fakeCommentTest, $dbCommentTest->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCommentTest()
    {
        $commentTest = $this->makeCommentTest();
        $resp = $this->commentTestRepo->delete($commentTest->id);
        $this->assertTrue($resp);
        $this->assertNull(CommentTest::find($commentTest->id), 'CommentTest should not exist in DB');
    }
}
