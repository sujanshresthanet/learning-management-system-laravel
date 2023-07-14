<?php


namespace LMS\Modules\Courses\Usecases;


use LMS\Modules\Courses\Repositories\Contracts\CourseRepositoryInterface;
use LMS\Modules\Courses\Usecases\Contracts\UpdateCourseUsecaseInterface;

class UpdateCourseUsecase implements UpdateCourseUsecaseInterface
{

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function handle(int $id, array $data)
    {
        return $this->courseRepository->update($id, $data);
    }
}
