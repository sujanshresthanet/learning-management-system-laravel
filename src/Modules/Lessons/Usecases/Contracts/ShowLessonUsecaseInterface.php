<?php


namespace LMS\Modules\Lessons\Usecases\Contracts;

use App\Entities\User;

interface ShowLessonUsecaseInterface
{
    public function handle(int $lesson_id, int $user_id);
}
