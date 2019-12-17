<?php

use App\Models\CourseOrder;
use App\Repositories\CourseOrderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseOrderRepositoryTest extends TestCase
{
    use MakeCourseOrderTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CourseOrderRepository
     */
    protected $courseOrderRepo;

    public function setUp()
    {
        parent::setUp();
        $this->courseOrderRepo = App::make(CourseOrderRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCourseOrder()
    {
        $courseOrder = $this->fakeCourseOrderData();
        $createdCourseOrder = $this->courseOrderRepo->create($courseOrder);
        $createdCourseOrder = $createdCourseOrder->toArray();
        $this->assertArrayHasKey('id', $createdCourseOrder);
        $this->assertNotNull($createdCourseOrder['id'], 'Created CourseOrder must have id specified');
        $this->assertNotNull(CourseOrder::find($createdCourseOrder['id']), 'CourseOrder with given id must be in DB');
        $this->assertModelData($courseOrder, $createdCourseOrder);
    }

    /**
     * @test read
     */
    public function testReadCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $dbCourseOrder = $this->courseOrderRepo->find($courseOrder->id);
        $dbCourseOrder = $dbCourseOrder->toArray();
        $this->assertModelData($courseOrder->toArray(), $dbCourseOrder);
    }

    /**
     * @test update
     */
    public function testUpdateCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $fakeCourseOrder = $this->fakeCourseOrderData();
        $updatedCourseOrder = $this->courseOrderRepo->update($fakeCourseOrder, $courseOrder->id);
        $this->assertModelData($fakeCourseOrder, $updatedCourseOrder->toArray());
        $dbCourseOrder = $this->courseOrderRepo->find($courseOrder->id);
        $this->assertModelData($fakeCourseOrder, $dbCourseOrder->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCourseOrder()
    {
        $courseOrder = $this->makeCourseOrder();
        $resp = $this->courseOrderRepo->delete($courseOrder->id);
        $this->assertTrue($resp);
        $this->assertNull(CourseOrder::find($courseOrder->id), 'CourseOrder should not exist in DB');
    }
}
