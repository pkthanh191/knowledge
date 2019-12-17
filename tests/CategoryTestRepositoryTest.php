<?php

use App\Models\CategoryTest;
use App\Repositories\CategoryTestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTestRepositoryTest extends TestCase
{
    use MakeCategoryTestTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryTestRepository
     */
    protected $categoryTestRepo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryTestRepo = App::make(CategoryTestRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryTest()
    {
        $categoryTest = $this->fakeCategoryTestData();
        $createdCategoryTest = $this->categoryTestRepo->create($categoryTest);
        $createdCategoryTest = $createdCategoryTest->toArray();
        $this->assertArrayHasKey('id', $createdCategoryTest);
        $this->assertNotNull($createdCategoryTest['id'], 'Created CategoryTest must have id specified');
        $this->assertNotNull(CategoryTest::find($createdCategoryTest['id']), 'CategoryTest with given id must be in DB');
        $this->assertModelData($categoryTest, $createdCategoryTest);
    }

    /**
     * @test read
     */
    public function testReadCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $dbCategoryTest = $this->categoryTestRepo->find($categoryTest->id);
        $dbCategoryTest = $dbCategoryTest->toArray();
        $this->assertModelData($categoryTest->toArray(), $dbCategoryTest);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $fakeCategoryTest = $this->fakeCategoryTestData();
        $updatedCategoryTest = $this->categoryTestRepo->update($fakeCategoryTest, $categoryTest->id);
        $this->assertModelData($fakeCategoryTest, $updatedCategoryTest->toArray());
        $dbCategoryTest = $this->categoryTestRepo->find($categoryTest->id);
        $this->assertModelData($fakeCategoryTest, $dbCategoryTest->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryTest()
    {
        $categoryTest = $this->makeCategoryTest();
        $resp = $this->categoryTestRepo->delete($categoryTest->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryTest::find($categoryTest->id), 'CategoryTest should not exist in DB');
    }
}
