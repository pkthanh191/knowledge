<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentMetaApiTest extends TestCase
{
    use MakeDocumentMetaTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDocumentMeta()
    {
        $documentMeta = $this->fakeDocumentMetaData();
        $this->json('POST', '/api/v1/documentMetas', $documentMeta);

        $this->assertApiResponse($documentMeta);
    }

    /**
     * @test
     */
    public function testReadDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $this->json('GET', '/api/v1/documentMetas/'.$documentMeta->id);

        $this->assertApiResponse($documentMeta->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $editedDocumentMeta = $this->fakeDocumentMetaData();

        $this->json('PUT', '/api/v1/documentMetas/'.$documentMeta->id, $editedDocumentMeta);

        $this->assertApiResponse($editedDocumentMeta);
    }

    /**
     * @test
     */
    public function testDeleteDocumentMeta()
    {
        $documentMeta = $this->makeDocumentMeta();
        $this->json('DELETE', '/api/v1/documentMetas/'.$documentMeta->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/documentMetas/'.$documentMeta->id);

        $this->assertResponseStatus(404);
    }
}
