<?php

use App\Models\CategoryDocMeta;
use App\Repositories\CategoryDocMetaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryDocMetaRepositoryTest extends TestCase
{
    use MakeCategoryDocMetaTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryDocMetaRepository
     */
    protected $categoryDocMetaRepo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryDocMetaRepo = App::make(CategoryDocMetaRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryDocMeta()
    {
        $categoryDocMeta = $this->fakeCategoryDocMetaData();
        $createdCategoryDocMeta = $this->categoryDocMetaRepo->create($categoryDocMeta);
        $createdCategoryDocMeta = $createdCategoryDocMeta->toArray();
        $this->assertArrayHasKey('id', $createdCategoryDocMeta);
        $this->assertNotNull($createdCategoryDocMeta['id'], 'Created CategoryDocMeta must have id specified');
        $this->assertNotNull(CategoryDocMeta::find($createdCategoryDocMeta['id']), 'CategoryDocMeta with given id must be in DB');
        $this->assertModelData($categoryDocMeta, $createdCategoryDocMeta);
    }

    /**
     * @test read
     */
    public function testReadCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $dbCategoryDocMeta = $this->categoryDocMetaRepo->find($categoryDocMeta->id);
        $dbCategoryDocMeta = $dbCategoryDocMeta->toArray();
        $this->assertModelData($categoryDocMeta->toArray(), $dbCategoryDocMeta);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $fakeCategoryDocMeta = $this->fakeCategoryDocMetaData();
        $updatedCategoryDocMeta = $this->categoryDocMetaRepo->update($fakeCategoryDocMeta, $categoryDocMeta->id);
        $this->assertModelData($fakeCategoryDocMeta, $updatedCategoryDocMeta->toArray());
        $dbCategoryDocMeta = $this->categoryDocMetaRepo->find($categoryDocMeta->id);
        $this->assertModelData($fakeCategoryDocMeta, $dbCategoryDocMeta->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryDocMeta()
    {
        $categoryDocMeta = $this->makeCategoryDocMeta();
        $resp = $this->categoryDocMetaRepo->delete($categoryDocMeta->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryDocMeta::find($categoryDocMeta->id), 'CategoryDocMeta should not exist in DB');
    }
}
