<?php

use App\Models\Grade;
use App\Repositories\GradeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GradeRepositoryTest extends TestCase
{
    use MakeGradeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var GradeRepository
     */
    protected $gradeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->gradeRepo = App::make(GradeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateGrade()
    {
        $grade = $this->fakeGradeData();
        $createdGrade = $this->gradeRepo->create($grade);
        $createdGrade = $createdGrade->toArray();
        $this->assertArrayHasKey('id', $createdGrade);
        $this->assertNotNull($createdGrade['id'], 'Created Grade must have id specified');
        $this->assertNotNull(Grade::find($createdGrade['id']), 'Grade with given id must be in DB');
        $this->assertModelData($grade, $createdGrade);
    }

    /**
     * @test read
     */
    public function testReadGrade()
    {
        $grade = $this->makeGrade();
        $dbGrade = $this->gradeRepo->find($grade->id);
        $dbGrade = $dbGrade->toArray();
        $this->assertModelData($grade->toArray(), $dbGrade);
    }

    /**
     * @test update
     */
    public function testUpdateGrade()
    {
        $grade = $this->makeGrade();
        $fakeGrade = $this->fakeGradeData();
        $updatedGrade = $this->gradeRepo->update($fakeGrade, $grade->id);
        $this->assertModelData($fakeGrade, $updatedGrade->toArray());
        $dbGrade = $this->gradeRepo->find($grade->id);
        $this->assertModelData($fakeGrade, $dbGrade->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteGrade()
    {
        $grade = $this->makeGrade();
        $resp = $this->gradeRepo->delete($grade->id);
        $this->assertTrue($resp);
        $this->assertNull(Grade::find($grade->id), 'Grade should not exist in DB');
    }
}
