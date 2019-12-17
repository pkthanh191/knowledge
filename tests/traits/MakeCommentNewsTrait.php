<?php

use Faker\Factory as Faker;
use App\Models\CommentNews;
use App\Repositories\CommentNewsRepository;

trait MakeCommentNewsTrait
{
    /**
     * Create fake instance of CommentNews and save it in database
     *
     * @param array $commentNewsFields
     * @return CommentNews
     */
    public function makeCommentNews($commentNewsFields = [])
    {
        /** @var CommentNewsRepository $commentNewsRepo */
        $commentNewsRepo = App::make(CommentNewsRepository::class);
        $theme = $this->fakeCommentNewsData($commentNewsFields);
        return $commentNewsRepo->create($theme);
    }

    /**
     * Get fake instance of CommentNews
     *
     * @param array $commentNewsFields
     * @return CommentNews
     */
    public function fakeCommentNews($commentNewsFields = [])
    {
        return new CommentNews($this->fakeCommentNewsData($commentNewsFields));
    }

    /**
     * Get fake data of CommentNews
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCommentNewsData($commentNewsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'content' => $fake->text,
            'parent_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'news_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $commentNewsFields);
    }
}
