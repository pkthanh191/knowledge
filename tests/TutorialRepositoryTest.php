<?php

use App\Models\Tutorial;
use App\Repositories\TutorialRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TutorialRepositoryTest extends TestCase
{
    use MakeTutorialTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TutorialRepository
     */
    protected $tutorialRepo;

    public function setUp()
    {
        parent::setUp();
        $this->tutorialRepo = App::make(TutorialRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTutorial()
    {
        $tutorial = $this->fakeTutorialData();
        $createdTutorial = $this->tutorialRepo->create($tutorial);
        $createdTutorial = $createdTutorial->toArray();
        $this->assertArrayHasKey('id', $createdTutorial);
        $this->assertNotNull($createdTutorial['id'], 'Created Tutorial must have id specified');
        $this->assertNotNull(Tutorial::find($createdTutorial['id']), 'Tutorial with given id must be in DB');
        $this->assertModelData($tutorial, $createdTutorial);
    }

    /**
     * @test read
     */
    public function testReadTutorial()
    {
        $tutorial = $this->makeTutorial();
        $dbTutorial = $this->tutorialRepo->find($tutorial->id);
        $dbTutorial = $dbTutorial->toArray();
        $this->assertModelData($tutorial->toArray(), $dbTutorial);
    }

    /**
     * @test update
     */
    public function testUpdateTutorial()
    {
        $tutorial = $this->makeTutorial();
        $fakeTutorial = $this->fakeTutorialData();
        $updatedTutorial = $this->tutorialRepo->update($fakeTutorial, $tutorial->id);
        $this->assertModelData($fakeTutorial, $updatedTutorial->toArray());
        $dbTutorial = $this->tutorialRepo->find($tutorial->id);
        $this->assertModelData($fakeTutorial, $dbTutorial->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTutorial()
    {
        $tutorial = $this->makeTutorial();
        $resp = $this->tutorialRepo->delete($tutorial->id);
        $this->assertTrue($resp);
        $this->assertNull(Tutorial::find($tutorial->id), 'Tutorial should not exist in DB');
    }
}
