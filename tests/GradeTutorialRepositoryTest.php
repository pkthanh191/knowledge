<?php

use App\Models\GradeTutorial;
use App\Repositories\GradeTutorialRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GradeTutorialRepositoryTest extends TestCase
{
    use MakeGradeTutorialTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var GradeTutorialRepository
     */
    protected $gradeTutorialRepo;

    public function setUp()
    {
        parent::setUp();
        $this->gradeTutorialRepo = App::make(GradeTutorialRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateGradeTutorial()
    {
        $gradeTutorial = $this->fakeGradeTutorialData();
        $createdGradeTutorial = $this->gradeTutorialRepo->create($gradeTutorial);
        $createdGradeTutorial = $createdGradeTutorial->toArray();
        $this->assertArrayHasKey('id', $createdGradeTutorial);
        $this->assertNotNull($createdGradeTutorial['id'], 'Created GradeTutorial must have id specified');
        $this->assertNotNull(GradeTutorial::find($createdGradeTutorial['id']), 'GradeTutorial with given id must be in DB');
        $this->assertModelData($gradeTutorial, $createdGradeTutorial);
    }

    /**
     * @test read
     */
    public function testReadGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $dbGradeTutorial = $this->gradeTutorialRepo->find($gradeTutorial->id);
        $dbGradeTutorial = $dbGradeTutorial->toArray();
        $this->assertModelData($gradeTutorial->toArray(), $dbGradeTutorial);
    }

    /**
     * @test update
     */
    public function testUpdateGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $fakeGradeTutorial = $this->fakeGradeTutorialData();
        $updatedGradeTutorial = $this->gradeTutorialRepo->update($fakeGradeTutorial, $gradeTutorial->id);
        $this->assertModelData($fakeGradeTutorial, $updatedGradeTutorial->toArray());
        $dbGradeTutorial = $this->gradeTutorialRepo->find($gradeTutorial->id);
        $this->assertModelData($fakeGradeTutorial, $dbGradeTutorial->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteGradeTutorial()
    {
        $gradeTutorial = $this->makeGradeTutorial();
        $resp = $this->gradeTutorialRepo->delete($gradeTutorial->id);
        $this->assertTrue($resp);
        $this->assertNull(GradeTutorial::find($gradeTutorial->id), 'GradeTutorial should not exist in DB');
    }
}
