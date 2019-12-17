<?php

use App\Models\DocumentMeta;
use App\Repositories\DocumentMetaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentMetaRepositoryTest extends TestCase
{
    use MakeDocumentMetaTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DocumentMetaRepository
     */
    protected $documentMetaRepo;

    public function setUp()
    {
        parent::setUp();
        $this->documentMetaRepo = App::make(DocumentMetaRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDocumentMeta()
    {
        $documentMeta = $this->fakeDocumentMetaData();
        $createdDocumentMeta = $this->documentMetaRepo->create($documentMeta);
        $createdDocumentMeta = $createdDocumentMeta->toArray();
        $this->assertArrayHasKey('id', $createdDocumentMeta);
        $this->assertNotNull($createdDocumentMeta['id'], 'Created DocumentMeta must have id specified');
        $this->assertNotNull(DocumentMeta::find($createdDocumentMeta['id']), 'DocumentMeta with given id must be in DB');
        $this->assertModelData($documentMeta, $createdDocumentMeta);
    }

    /**
     * @test read
     */
    public function testReadDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $dbDocumentMeta = $this->documentMetaRepo->find($documentMeta->id);
        $dbDocumentMeta = $dbDocumentMeta->toArray();
        $this->assertModelData($documentMeta->toArray(), $dbDocumentMeta);
    }

    /**
     * @test update
     */
    public function testUpdateDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $fakeDocumentMeta = $this->fakeDocumentMetaData();
        $updatedDocumentMeta = $this->documentMetaRepo->update($fakeDocumentMeta, $documentMeta->id);
        $this->assertModelData($fakeDocumentMeta, $updatedDocumentMeta->toArray());
        $dbDocumentMeta = $this->documentMetaRepo->find($documentMeta->id);
        $this->assertModelData($fakeDocumentMeta, $dbDocumentMeta->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $resp = $this->documentMetaRepo->delete($documentMeta->id);
        $this->assertTrue($resp);
        $this->assertNull(DocumentMeta::find($documentMeta->id), 'DocumentMeta should not exist in DB');
    }
}
