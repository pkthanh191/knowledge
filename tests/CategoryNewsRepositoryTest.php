<?php

use App\Models\CategoryNews;
use App\Repositories\CategoryNewsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryNewsRepositoryTest extends TestCase
{
    use MakeCategoryNewsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryNewsRepository
     */
    protected $categoryNewsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryNewsRepo = App::make(CategoryNewsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryNews()
    {
        $categoryNews = $this->fakeCategoryNewsData();
        $createdCategoryNews = $this->categoryNewsRepo->create($categoryNews);
        $createdCategoryNews = $createdCategoryNews->toArray();
        $this->assertArrayHasKey('id', $createdCategoryNews);
        $this->assertNotNull($createdCategoryNews['id'], 'Created CategoryNews must have id specified');
        $this->assertNotNull(CategoryNews::find($createdCategoryNews['id']), 'CategoryNews with given id must be in DB');
        $this->assertModelData($categoryNews, $createdCategoryNews);
    }

    /**
     * @test read
     */
    public function testReadCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $dbCategoryNews = $this->categoryNewsRepo->find($categoryNews->id);
        $dbCategoryNews = $dbCategoryNews->toArray();
        $this->assertModelData($categoryNews->toArray(), $dbCategoryNews);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $fakeCategoryNews = $this->fakeCategoryNewsData();
        $updatedCategoryNews = $this->categoryNewsRepo->update($fakeCategoryNews, $categoryNews->id);
        $this->assertModelData($fakeCategoryNews, $updatedCategoryNews->toArray());
        $dbCategoryNews = $this->categoryNewsRepo->find($categoryNews->id);
        $this->assertModelData($fakeCategoryNews, $dbCategoryNews->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryNews()
    {
        $categoryNews = $this->makeCategoryNews();
        $resp = $this->categoryNewsRepo->delete($categoryNews->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryNews::find($categoryNews->id), 'CategoryNews should not exist in DB');
    }
}
