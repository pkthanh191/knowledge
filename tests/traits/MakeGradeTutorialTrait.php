<?php

use Faker\Factory as Faker;
use App\Models\GradeTutorial;
use App\Repositories\GradeTutorialRepository;

trait MakeGradeTutorialTrait
{
    /**
     * Create fake instance of GradeTutorial and save it in database
     *
     * @param array $gradeTutorialFields
     * @return GradeTutorial
     */
    public function makeGradeTutorial($gradeTutorialFields = [])
    {
        /** @var GradeTutorialRepository $gradeTutorialRepo */
        $gradeTutorialRepo = App::make(GradeTutorialRepository::class);
        $theme = $this->fakeGradeTutorialData($gradeTutorialFields);
        return $gradeTutorialRepo->create($theme);
    }

    /**
     * Get fake instance of GradeTutorial
     *
     * @param array $gradeTutorialFields
     * @return GradeTutorial
     */
    public function fakeGradeTutorial($gradeTutorialFields = [])
    {
        return new GradeTutorial($this->fakeGradeTutorialData($gradeTutorialFields));
    }

    /**
     * Get fake data of GradeTutorial
     *
     * @param array $postFields
     * @return array
     */
    public function fakeGradeTutorialData($gradeTutorialFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'grade_id' => $fake->randomDigitNotNull,
            'tutorial_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $gradeTutorialFields);
    }
}
