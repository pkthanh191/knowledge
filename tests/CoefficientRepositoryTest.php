<?php

use App\Models\Coefficient;
use App\Repositories\CoefficientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoefficientRepositoryTest extends TestCase
{
    use MakeCoefficientTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CoefficientRepository
     */
    protected $coefficientRepo;

    public function setUp()
    {
        parent::setUp();
        $this->coefficientRepo = App::make(CoefficientRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCoefficient()
    {
        $coefficient = $this->fakeCoefficientData();
        $createdCoefficient = $this->coefficientRepo->create($coefficient);
        $createdCoefficient = $createdCoefficient->toArray();
        $this->assertArrayHasKey('id', $createdCoefficient);
        $this->assertNotNull($createdCoefficient['id'], 'Created Coefficient must have id specified');
        $this->assertNotNull(Coefficient::find($createdCoefficient['id']), 'Coefficient with given id must be in DB');
        $this->assertModelData($coefficient, $createdCoefficient);
    }

    /**
     * @test read
     */
    public function testReadCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $dbCoefficient = $this->coefficientRepo->find($coefficient->id);
        $dbCoefficient = $dbCoefficient->toArray();
        $this->assertModelData($coefficient->toArray(), $dbCoefficient);
    }

    /**
     * @test update
     */
    public function testUpdateCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $fakeCoefficient = $this->fakeCoefficientData();
        $updatedCoefficient = $this->coefficientRepo->update($fakeCoefficient, $coefficient->id);
        $this->assertModelData($fakeCoefficient, $updatedCoefficient->toArray());
        $dbCoefficient = $this->coefficientRepo->find($coefficient->id);
        $this->assertModelData($fakeCoefficient, $dbCoefficient->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCoefficient()
    {
        $coefficient = $this->makeCoefficient();
        $resp = $this->coefficientRepo->delete($coefficient->id);
        $this->assertTrue($resp);
        $this->assertNull(Coefficient::find($coefficient->id), 'Coefficient should not exist in DB');
    }
}
