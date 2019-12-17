<?php

use App\Models\NewsCategory;
use App\Repositories\NewsCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsCategoryRepositoryTest extends TestCase
{
    use MakeNewsCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NewsCategoryRepository
     */
    protected $newsCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->newsCategoryRepo = App::make(NewsCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNewsCategory()
    {
        $newsCategory = $this->fakeNewsCategoryData();
        $createdNewsCategory = $this->newsCategoryRepo->create($newsCategory);
        $createdNewsCategory = $createdNewsCategory->toArray();
        $this->assertArrayHasKey('id', $createdNewsCategory);
        $this->assertNotNull($createdNewsCategory['id'], 'Created NewsCategory must have id specified');
        $this->assertNotNull(NewsCategory::find($createdNewsCategory['id']), 'NewsCategory with given id must be in DB');
        $this->assertModelData($newsCategory, $createdNewsCategory);
    }

    /**
     * @test read
     */
    public function testReadNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $dbNewsCategory = $this->newsCategoryRepo->find($newsCategory->id);
        $dbNewsCategory = $dbNewsCategory->toArray();
        $this->assertModelData($newsCategory->toArray(), $dbNewsCategory);
    }

    /**
     * @test update
     */
    public function testUpdateNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $fakeNewsCategory = $this->fakeNewsCategoryData();
        $updatedNewsCategory = $this->newsCategoryRepo->update($fakeNewsCategory, $newsCategory->id);
        $this->assertModelData($fakeNewsCategory, $updatedNewsCategory->toArray());
        $dbNewsCategory = $this->newsCategoryRepo->find($newsCategory->id);
        $this->assertModelData($fakeNewsCategory, $dbNewsCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNewsCategory()
    {
        $newsCategory = $this->makeNewsCategory();
        $resp = $this->newsCategoryRepo->delete($newsCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(NewsCategory::find($newsCategory->id), 'NewsCategory should not exist in DB');
    }
}
