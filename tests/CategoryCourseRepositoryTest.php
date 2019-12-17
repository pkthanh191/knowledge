<?php

use App\Models\CategoryCourse;
use App\Repositories\CategoryCourseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryCourseRepositoryTest extends TestCase
{
    use MakeCategoryCourseTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryCourseRepository
     */
    protected $categoryCourseRepo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryCourseRepo = App::make(CategoryCourseRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryCourse()
    {
        $categoryCourse = $this->fakeCategoryCourseData();
        $createdCategoryCourse = $this->categoryCourseRepo->create($categoryCourse);
        $createdCategoryCourse = $createdCategoryCourse->toArray();
        $this->assertArrayHasKey('id', $createdCategoryCourse);
        $this->assertNotNull($createdCategoryCourse['id'], 'Created CategoryCourse must have id specified');
        $this->assertNotNull(CategoryCourse::find($createdCategoryCourse['id']), 'CategoryCourse with given id must be in DB');
        $this->assertModelData($categoryCourse, $createdCategoryCourse);
    }

    /**
     * @test read
     */
    public function testReadCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $dbCategoryCourse = $this->categoryCourseRepo->find($categoryCourse->id);
        $dbCategoryCourse = $dbCategoryCourse->toArray();
        $this->assertModelData($categoryCourse->toArray(), $dbCategoryCourse);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $fakeCategoryCourse = $this->fakeCategoryCourseData();
        $updatedCategoryCourse = $this->categoryCourseRepo->update($fakeCategoryCourse, $categoryCourse->id);
        $this->assertModelData($fakeCategoryCourse, $updatedCategoryCourse->toArray());
        $dbCategoryCourse = $this->categoryCourseRepo->find($categoryCourse->id);
        $this->assertModelData($fakeCategoryCourse, $dbCategoryCourse->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryCourse()
    {
        $categoryCourse = $this->makeCategoryCourse();
        $resp = $this->categoryCourseRepo->delete($categoryCourse->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryCourse::find($categoryCourse->id), 'CategoryCourse should not exist in DB');
    }
}
