<?php

use Faker\Factory as Faker;
use App\Models\Tutorial;
use App\Repositories\TutorialRepository;

trait MakeTutorialTrait
{
    /**
     * Create fake instance of Tutorial and save it in database
     *
     * @param array $tutorialFields
     * @return Tutorial
     */
    public function makeTutorial($tutorialFields = [])
    {
        /** @var TutorialRepository $tutorialRepo */
        $tutorialRepo = App::make(TutorialRepository::class);
        $theme = $this->fakeTutorialData($tutorialFields);
        return $tutorialRepo->create($theme);
    }

    /**
     * Get fake instance of Tutorial
     *
     * @param array $tutorialFields
     * @return Tutorial
     */
    public function fakeTutorial($tutorialFields = [])
    {
        return new Tutorial($this->fakeTutorialData($tutorialFields));
    }

    /**
     * Get fake data of Tutorial
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTutorialData($tutorialFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'phone' => $fake->word,
            'email' => $fake->word,
            'requirement' => $fake->text,
            'period' => $fake->word,
            'frequency' => $fake->randomDigitNotNull,
            'salary' => $fake->randomDigitNotNull,
            'active' => $fake->randomDigitNotNull,
            'confirm' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'meta_title' => $fake->word,
            'meta_keywords' => $fake->word,
            'meta_description' => $fake->word,
            'address' => $fake->word,
            'district_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $tutorialFields);
    }
}
