<?php

use Faker\Factory as Faker;
use App\Models\CommentTest;
use App\Repositories\CommentTestRepository;

trait MakeCommentTestTrait
{
    /**
     * Create fake instance of CommentTest and save it in database
     *
     * @param array $commentTestFields
     * @return CommentTest
     */
    public function makeCommentTest($commentTestFields = [])
    {
        /** @var CommentTestRepository $commentTestRepo */
        $commentTestRepo = App::make(CommentTestRepository::class);
        $theme = $this->fakeCommentTestData($commentTestFields);
        return $commentTestRepo->create($theme);
    }

    /**
     * Get fake instance of CommentTest
     *
     * @param array $commentTestFields
     * @return CommentTest
     */
    public function fakeCommentTest($commentTestFields = [])
    {
        return new CommentTest($this->fakeCommentTestData($commentTestFields));
    }

    /**
     * Get fake data of CommentTest
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCommentTestData($commentTestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'content' => $fake->text,
            'parent_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'test_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $commentTestFields);
    }
}
