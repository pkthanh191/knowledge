<?php

use Faker\Factory as Faker;
use App\Models\Subject;
use App\Repositories\SubjectRepository;

trait MakeSubjectTrait
{
    /**
     * Create fake instance of Subject and save it in database
     *
     * @param array $subjectFields
     * @return Subject
     */
    public function makeSubject($subjectFields = [])
    {
        /** @var SubjectRepository $subjectRepo */
        $subjectRepo = App::make(SubjectRepository::class);
        $theme = $this->fakeSubjectData($subjectFields);
        return $subjectRepo->create($theme);
    }

    /**
     * Get fake instance of Subject
     *
     * @param array $subjectFields
     * @return Subject
     */
    public function fakeSubject($subjectFields = [])
    {
        return new Subject($this->fakeSubjectData($subjectFields));
    }

    /**
     * Get fake data of Subject
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSubjectData($subjectFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $subjectFields);
    }
}
