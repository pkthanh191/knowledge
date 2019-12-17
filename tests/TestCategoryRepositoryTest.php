<?php

use App\Models\TestCategory;
use App\Repositories\TestCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCategoryRepositoryTest extends TestCase
{
    use MakeTestCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TestCategoryRepository
     */
    protected $testCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->testCategoryRepo = App::make(TestCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTestCategory()
    {
        $testCategory = $this->fakeTestCategoryData();
        $createdTestCategory = $this->testCategoryRepo->create($testCategory);
        $createdTestCategory = $createdTestCategory->toArray();
        $this->assertArrayHasKey('id', $createdTestCategory);
        $this->assertNotNull($createdTestCategory['id'], 'Created TestCategory must have id specified');
        $this->assertNotNull(TestCategory::find($createdTestCategory['id']), 'TestCategory with given id must be in DB');
        $this->assertModelData($testCategory, $createdTestCategory);
    }

    /**
     * @test read
     */
    public function testReadTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $dbTestCategory = $this->testCategoryRepo->find($testCategory->id);
        $dbTestCategory = $dbTestCategory->toArray();
        $this->assertModelData($testCategory->toArray(), $dbTestCategory);
    }

    /**
     * @test update
     */
    public function testUpdateTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $fakeTestCategory = $this->fakeTestCategoryData();
        $updatedTestCategory = $this->testCategoryRepo->update($fakeTestCategory, $testCategory->id);
        $this->assertModelData($fakeTestCategory, $updatedTestCategory->toArray());
        $dbTestCategory = $this->testCategoryRepo->find($testCategory->id);
        $this->assertModelData($fakeTestCategory, $dbTestCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTestCategory()
    {
        $testCategory = $this->makeTestCategory();
        $resp = $this->testCategoryRepo->delete($testCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(TestCategory::find($testCategory->id), 'TestCategory should not exist in DB');
    }
}
