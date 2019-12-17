<?php

use Faker\Factory as Faker;
use App\Models\Grade;
use App\Repositories\GradeRepository;

trait MakeGradeTrait
{
    /**
     * Create fake instance of Grade and save it in database
     *
     * @param array $gradeFields
     * @return Grade
     */
    public function makeGrade($gradeFields = [])
    {
        /** @var GradeRepository $gradeRepo */
        $gradeRepo = App::make(GradeRepository::class);
        $theme = $this->fakeGradeData($gradeFields);
        return $gradeRepo->create($theme);
    }

    /**
     * Get fake instance of Grade
     *
     * @param array $gradeFields
     * @return Grade
     */
    public function fakeGrade($gradeFields = [])
    {
        return new Grade($this->fakeGradeData($gradeFields));
    }

    /**
     * Get fake data of Grade
     *
     * @param array $postFields
     * @return array
     */
    public function fakeGradeData($gradeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $gradeFields);
    }
}
