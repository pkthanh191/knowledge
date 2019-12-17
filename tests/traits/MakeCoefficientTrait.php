<?php

use Faker\Factory as Faker;
use App\Models\Coefficient;
use App\Repositories\CoefficientRepository;

trait MakeCoefficientTrait
{
    /**
     * Create fake instance of Coefficient and save it in database
     *
     * @param array $coefficientFields
     * @return Coefficient
     */
    public function makeCoefficient($coefficientFields = [])
    {
        /** @var CoefficientRepository $coefficientRepo */
        $coefficientRepo = App::make(CoefficientRepository::class);
        $theme = $this->fakeCoefficientData($coefficientFields);
        return $coefficientRepo->create($theme);
    }

    /**
     * Get fake instance of Coefficient
     *
     * @param array $coefficientFields
     * @return Coefficient
     */
    public function fakeCoefficient($coefficientFields = [])
    {
        return new Coefficient($this->fakeCoefficientData($coefficientFields));
    }

    /**
     * Get fake data of Coefficient
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCoefficientData($coefficientFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'apply_form' => $fake->word,
            'apply_to' => $fake->word,
            'cost_form' => $fake->randomDigitNotNull,
            'cost_to' => $fake->randomDigitNotNull,
            'coefficient' => $fake->word,
            'description' => $fake->text
        ], $coefficientFields);
    }
}
