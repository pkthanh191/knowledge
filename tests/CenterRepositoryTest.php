<?php

use App\Models\Center;
use App\Repositories\CenterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CenterRepositoryTest extends TestCase
{
    use MakeCenterTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CenterRepository
     */
    protected $centerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->centerRepo = App::make(CenterRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCenter()
    {
        $center = $this->fakeCenterData();
        $createdCenter = $this->centerRepo->create($center);
        $createdCenter = $createdCenter->toArray();
        $this->assertArrayHasKey('id', $createdCenter);
        $this->assertNotNull($createdCenter['id'], 'Created Center must have id specified');
        $this->assertNotNull(Center::find($createdCenter['id']), 'Center with given id must be in DB');
        $this->assertModelData($center, $createdCenter);
    }

    /**
     * @test read
     */
    public function testReadCenter()
    {
        $center = $this->makeCenter();
        $dbCenter = $this->centerRepo->find($center->id);
        $dbCenter = $dbCenter->toArray();
        $this->assertModelData($center->toArray(), $dbCenter);
    }

    /**
     * @test update
     */
    public function testUpdateCenter()
    {
        $center = $this->makeCenter();
        $fakeCenter = $this->fakeCenterData();
        $updatedCenter = $this->centerRepo->update($fakeCenter, $center->id);
        $this->assertModelData($fakeCenter, $updatedCenter->toArray());
        $dbCenter = $this->centerRepo->find($center->id);
        $this->assertModelData($fakeCenter, $dbCenter->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCenter()
    {
        $center = $this->makeCenter();
        $resp = $this->centerRepo->delete($center->id);
        $this->assertTrue($resp);
        $this->assertNull(Center::find($center->id), 'Center should not exist in DB');
    }
}
