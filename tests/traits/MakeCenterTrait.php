<?php

use Faker\Factory as Faker;
use App\Models\Center;
use App\Repositories\CenterRepository;

trait MakeCenterTrait
{
    /**
     * Create fake instance of Center and save it in database
     *
     * @param array $centerFields
     * @return Center
     */
    public function makeCenter($centerFields = [])
    {
        /** @var CenterRepository $centerRepo */
        $centerRepo = App::make(CenterRepository::class);
        $theme = $this->fakeCenterData($centerFields);
        return $centerRepo->create($theme);
    }

    /**
     * Get fake instance of Center
     *
     * @param array $centerFields
     * @return Center
     */
    public function fakeCenter($centerFields = [])
    {
        return new Center($this->fakeCenterData($centerFields));
    }

    /**
     * Get fake data of Center
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCenterData($centerFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'address' => $fake->word,
            'phone' => $fake->word,
            'email' => $fake->word,
            'slug' => $fake->word,
            'image' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $centerFields);
    }
}
