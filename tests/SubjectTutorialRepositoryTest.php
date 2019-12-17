<?php

use App\Models\SubjectTutorial;
use App\Repositories\SubjectTutorialRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectTutorialRepositoryTest extends TestCase
{
    use MakeSubjectTutorialTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubjectTutorialRepository
     */
    protected $subjectTutorialRepo;

    public function setUp()
    {
        parent::setUp();
        $this->subjectTutorialRepo = App::make(SubjectTutorialRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSubjectTutorial()
    {
        $subjectTutorial = $this->fakeSubjectTutorialData();
        $createdSubjectTutorial = $this->subjectTutorialRepo->create($subjectTutorial);
        $createdSubjectTutorial = $createdSubjectTutorial->toArray();
        $this->assertArrayHasKey('id', $createdSubjectTutorial);
        $this->assertNotNull($createdSubjectTutorial['id'], 'Created SubjectTutorial must have id specified');
        $this->assertNotNull(SubjectTutorial::find($createdSubjectTutorial['id']), 'SubjectTutorial with given id must be in DB');
        $this->assertModelData($subjectTutorial, $createdSubjectTutorial);
    }

    /**
     * @test read
     */
    public function testReadSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $dbSubjectTutorial = $this->subjectTutorialRepo->find($subjectTutorial->id);
        $dbSubjectTutorial = $dbSubjectTutorial->toArray();
        $this->assertModelData($subjectTutorial->toArray(), $dbSubjectTutorial);
    }

    /**
     * @test update
     */
    public function testUpdateSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $fakeSubjectTutorial = $this->fakeSubjectTutorialData();
        $updatedSubjectTutorial = $this->subjectTutorialRepo->update($fakeSubjectTutorial, $subjectTutorial->id);
        $this->assertModelData($fakeSubjectTutorial, $updatedSubjectTutorial->toArray());
        $dbSubjectTutorial = $this->subjectTutorialRepo->find($subjectTutorial->id);
        $this->assertModelData($fakeSubjectTutorial, $dbSubjectTutorial->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSubjectTutorial()
    {
        $subjectTutorial = $this->makeSubjectTutorial();
        $resp = $this->subjectTutorialRepo->delete($subjectTutorial->id);
        $this->assertTrue($resp);
        $this->assertNull(SubjectTutorial::find($subjectTutorial->id), 'SubjectTutorial should not exist in DB');
    }
}
