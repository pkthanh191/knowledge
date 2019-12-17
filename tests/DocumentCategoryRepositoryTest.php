<?php

use App\Models\DocumentCategory;
use App\Repositories\DocumentCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentCategoryRepositoryTest extends TestCase
{
    use MakeDocumentCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DocumentCategoryRepository
     */
    protected $documentCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->documentCategoryRepo = App::make(DocumentCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDocumentCategory()
    {
        $documentCategory = $this->fakeDocumentCategoryData();
        $createdDocumentCategory = $this->documentCategoryRepo->create($documentCategory);
        $createdDocumentCategory = $createdDocumentCategory->toArray();
        $this->assertArrayHasKey('id', $createdDocumentCategory);
        $this->assertNotNull($createdDocumentCategory['id'], 'Created DocumentCategory must have id specified');
        $this->assertNotNull(DocumentCategory::find($createdDocumentCategory['id']), 'DocumentCategory with given id must be in DB');
        $this->assertModelData($documentCategory, $createdDocumentCategory);
    }

    /**
     * @test read
     */
    public function testReadDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $dbDocumentCategory = $this->documentCategoryRepo->find($documentCategory->id);
        $dbDocumentCategory = $dbDocumentCategory->toArray();
        $this->assertModelData($documentCategory->toArray(), $dbDocumentCategory);
    }

    /**
     * @test update
     */
    public function testUpdateDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $fakeDocumentCategory = $this->fakeDocumentCategoryData();
        $updatedDocumentCategory = $this->documentCategoryRepo->update($fakeDocumentCategory, $documentCategory->id);
        $this->assertModelData($fakeDocumentCategory, $updatedDocumentCategory->toArray());
        $dbDocumentCategory = $this->documentCategoryRepo->find($documentCategory->id);
        $this->assertModelData($fakeDocumentCategory, $dbDocumentCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDocumentCategory()
    {
        $documentCategory = $this->makeDocumentCategory();
        $resp = $this->documentCategoryRepo->delete($documentCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(DocumentCategory::find($documentCategory->id), 'DocumentCategory should not exist in DB');
    }
}
