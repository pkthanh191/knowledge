<?php

use Faker\Factory as Faker;
use App\Models\SubjectTutorial;
use App\Repositories\SubjectTutorialRepository;

trait MakeSubjectTutorialTrait
{
    /**
     * Create fake instance of SubjectTutorial and save it in database
     *
     * @param array $subjectTutorialFields
     * @return SubjectTutorial
     */
    public function makeSubjectTutorial($subjectTutorialFields = [])
    {
        /** @var SubjectTutorialRepository $subjectTutorialRepo */
        $subjectTutorialRepo = App::make(SubjectTutorialRepository::class);
        $theme = $this->fakeSubjectTutorialData($subjectTutorialFields);
        return $subjectTutorialRepo->create($theme);
    }

    /**
     * Get fake instance of SubjectTutorial
     *
     * @param array $subjectTutorialFields
     * @return SubjectTutorial
     */
    public function fakeSubjectTutorial($subjectTutorialFields = [])
    {
        return new SubjectTutorial($this->fakeSubjectTutorialData($subjectTutorialFields));
    }

    /**
     * Get fake data of SubjectTutorial
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSubjectTutorialData($subjectTutorialFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'subject_id' => $fake->randomDigitNotNull,
            'tutorial_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $subjectTutorialFields);
    }
}
