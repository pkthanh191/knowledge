<?php

use App\Models\CourseCategory;
use App\Repositories\CourseCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseCategoryRepositoryTest extends TestCase
{
    use MakeCourseCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CourseCategoryRepository
     */
    protected $courseCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->courseCategoryRepo = App::make(CourseCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCourseCategory()
    {
        $courseCategory = $this->fakeCourseCategoryData();
        $createdCourseCategory = $this->courseCategoryRepo->create($courseCategory);
        $createdCourseCategory = $createdCourseCategory->toArray();
        $this->assertArrayHasKey('id', $createdCourseCategory);
        $this->assertNotNull($createdCourseCategory['id'], 'Created CourseCategory must have id specified');
        $this->assertNotNull(CourseCategory::find($createdCourseCategory['id']), 'CourseCategory with given id must be in DB');
        $this->assertModelData($courseCategory, $createdCourseCategory);
    }

    /**
     * @test read
     */
    public function testReadCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $dbCourseCategory = $this->courseCategoryRepo->find($courseCategory->id);
        $dbCourseCategory = $dbCourseCategory->toArray();
        $this->assertModelData($courseCategory->toArray(), $dbCourseCategory);
    }

    /**
     * @test update
     */
    public function testUpdateCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $fakeCourseCategory = $this->fakeCourseCategoryData();
        $updatedCourseCategory = $this->courseCategoryRepo->update($fakeCourseCategory, $courseCategory->id);
        $this->assertModelData($fakeCourseCategory, $updatedCourseCategory->toArray());
        $dbCourseCategory = $this->courseCategoryRepo->find($courseCategory->id);
        $this->assertModelData($fakeCourseCategory, $dbCourseCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCourseCategory()
    {
        $courseCategory = $this->makeCourseCategory();
        $resp = $this->courseCategoryRepo->delete($courseCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(CourseCategory::find($courseCategory->id), 'CourseCategory should not exist in DB');
    }
}
