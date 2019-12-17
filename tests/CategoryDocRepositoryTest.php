<?php

use App\Models\CategoryDoc;
use App\Repositories\CategoryDocRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryDocRepositoryTest extends TestCase
{
    use MakeCategoryDocTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryDocRepository
     */
    protected $categoryDocRepo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryDocRepo = App::make(CategoryDocRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryDoc()
    {
        $categoryDoc = $this->fakeCategoryDocData();
        $createdCategoryDoc = $this->categoryDocRepo->create($categoryDoc);
        $createdCategoryDoc = $createdCategoryDoc->toArray();
        $this->assertArrayHasKey('id', $createdCategoryDoc);
        $this->assertNotNull($createdCategoryDoc['id'], 'Created CategoryDoc must have id specified');
        $this->assertNotNull(CategoryDoc::find($createdCategoryDoc['id']), 'CategoryDoc with given id must be in DB');
        $this->assertModelData($categoryDoc, $createdCategoryDoc);
    }

    /**
     * @test read
     */
    public function testReadCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $dbCategoryDoc = $this->categoryDocRepo->find($categoryDoc->id);
        $dbCategoryDoc = $dbCategoryDoc->toArray();
        $this->assertModelData($categoryDoc->toArray(), $dbCategoryDoc);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $fakeCategoryDoc = $this->fakeCategoryDocData();
        $updatedCategoryDoc = $this->categoryDocRepo->update($fakeCategoryDoc, $categoryDoc->id);
        $this->assertModelData($fakeCategoryDoc, $updatedCategoryDoc->toArray());
        $dbCategoryDoc = $this->categoryDocRepo->find($categoryDoc->id);
        $this->assertModelData($fakeCategoryDoc, $dbCategoryDoc->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryDoc()
    {
        $categoryDoc = $this->makeCategoryDoc();
        $resp = $this->categoryDocRepo->delete($categoryDoc->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryDoc::find($categoryDoc->id), 'CategoryDoc should not exist in DB');
    }
}
