<?php

use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectRepositoryTest extends TestCase
{
    use MakeSubjectTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubjectRepository
     */
    protected $subjectRepo;

    public function setUp()
    {
        parent::setUp();
        $this->subjectRepo = App::make(SubjectRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSubject()
    {
        $subject = $this->fakeSubjectData();
        $createdSubject = $this->subjectRepo->create($subject);
        $createdSubject = $createdSubject->toArray();
        $this->assertArrayHasKey('id', $createdSubject);
        $this->assertNotNull($createdSubject['id'], 'Created Subject must have id specified');
        $this->assertNotNull(Subject::find($createdSubject['id']), 'Subject with given id must be in DB');
        $this->assertModelData($subject, $createdSubject);
    }

    /**
     * @test read
     */
    public function testReadSubject()
    {
        $subject = $this->makeSubject();
        $dbSubject = $this->subjectRepo->find($subject->id);
        $dbSubject = $dbSubject->toArray();
        $this->assertModelData($subject->toArray(), $dbSubject);
    }

    /**
     * @test update
     */
    public function testUpdateSubject()
    {
        $subject = $this->makeSubject();
        $fakeSubject = $this->fakeSubjectData();
        $updatedSubject = $this->subjectRepo->update($fakeSubject, $subject->id);
        $this->assertModelData($fakeSubject, $updatedSubject->toArray());
        $dbSubject = $this->subjectRepo->find($subject->id);
        $this->assertModelData($fakeSubject, $dbSubject->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSubject()
    {
        $subject = $this->makeSubject();
        $resp = $this->subjectRepo->delete($subject->id);
        $this->assertTrue($resp);
        $this->assertNull(Subject::find($subject->id), 'Subject should not exist in DB');
    }
}
