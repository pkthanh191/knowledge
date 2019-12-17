<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentMetaValueApiTest extends TestCase
{
    use MakeDocumentMetaValueTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDocumentMetaValue()
    {
        $documentMetaValue = $this->fakeDocumentMetaValueData();
        $this->json('POST', '/api/v1/documentMetaValues', $documentMetaValue);

        $this->assertApiResponse($documentMetaValue);
    }

    /**
     * @test
     */
    public function testReadDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $this->json('GET', '/api/v1/documentMetaValues/'.$documentMetaValue->id);

        $this->assertApiResponse($documentMetaValue->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $editedDocumentMetaValue = $this->fakeDocumentMetaValueData();

        $this->json('PUT', '/api/v1/documentMetaValues/'.$documentMetaValue->id, $editedDocumentMetaValue);

        $this->assertApiResponse($editedDocumentMetaValue);
    }

    /**
     * @test
     */
    public function testDeleteDocumentMetaValue()
    {
        $documentMetaValue = $this->makeDocumentMetaValue();
        $this->json('DELETE', '/api/v1/documentMetaValues/'.$documentMetaValue->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/documentMetaValues/'.$documentMetaValue->id);

        $this->assertResponseStatus(404);
    }
}
