<?php

use App\Models\DocumentMetaValue;
use App\Repositories\DocumentMetaValueRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentMetaValueRepositoryTest extends TestCase
{
    use MakeDocumentMetaValueTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DocumentMetaValueRepository
     */
    protected $documentMetaValueRepo;

    public function setUp()
    {
        parent::setUp();
        $this->documentMetaValueRepo = App::make(DocumentMetaValueRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDocumentMetaValue()
    {
        $documentMetaValue = $this->fakeDocumentMetaValueData();
        $createdDocumentMetaValue = $this->documentMetaValueRepo->create($documentMetaValue);
        $createdDocumentMetaValue = $createdDocumentMetaValue->toArray();
        $this->assertArrayHasKey('id', $createdDocumentMetaValue);
        $this->assertNotNull($createdDocumentMetaValue['id'], 'Created DocumentMetaValue must have id specified');
        $this->assertNotNull(DocumentMetaValue::find($createdDocumentMetaValue['id']), 'DocumentMetaValue with given id must be in DB');
        $this->assertModelData($documentMetaValue, $createdDocumentMetaValue);
    }

    /**
     * @test read
     */
    public function testReadDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $dbDocumentMetaValue = $this->documentMetaValueRepo->find($documentMetaValue->id);
        $dbDocumentMetaValue = $dbDocumentMetaValue->toArray();
        $this->assertModelData($documentMetaValue->toArray(), $dbDocumentMetaValue);
    }

    /**
     * @test update
     */
    public function testUpdateDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $fakeDocumentMetaValue = $this->fakeDocumentMetaValueData();
        $updatedDocumentMetaValue = $this->documentMetaValueRepo->update($fakeDocumentMetaValue, $documentMetaValue->id);
        $this->assertModelData($fakeDocumentMetaValue, $updatedDocumentMetaValue->toArray());
        $dbDocumentMetaValue = $this->documentMetaValueRepo->find($documentMetaValue->id);
        $this->assertModelData($fakeDocumentMetaValue, $dbDocumentMetaValue->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $resp = $this->documentMetaValueRepo->delete($documentMetaValue->id);
        $this->assertTrue($resp);
        $this->assertNull(DocumentMetaValue::find($documentMetaValue->id), 'DocumentMetaValue should not exist in DB');
    }
}
