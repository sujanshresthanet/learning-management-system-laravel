<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\Course\CreateRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use LMS\Modules\Courses\Repositories\Contracts\CourseRepositoryInterface;
use App\Traits\Authorizable;
use Illuminate\Support\Facades\Auth;
use LMS\Modules\Courses\Usecases\Contracts\{ListCourseUsecaseInterface,
    CreateCourseUsescaseInterface,
    ShowCourseUsecaseInterface,
    UpdateCourseUsecaseInterface,
    DeleteCourseUsecaseInterface,
    SubscribeCourseUsecaseInterface
};




class CourseController extends Controller
{

    use Authorizable;

    public function __construct()
    {
        return $this->middleware('auth');
    }


    public function index(ListCourseUsecaseInterface $listCourseUsecase)
    {
        $courses = $listCourseUsecase->handle();
        return view('courses.index', compact('courses'));
    }

    public function show($id, ShowCourseUsecaseInterface $showCourseUsecase)
    {
        $response = $showCourseUsecase->handle($id, Auth::user()->id);
        $course = $response['data']['course'];
        $lessons = $response['data']['lessons'];
        $subscribed = $response['data']['subscribed'];
        return view('courses.show', compact('lessons', 'course', 'subscribed'));
    }

    public function create(UserRepositoryInterface $userRepository)
    {
        $users = $userRepository->all(Roles::TEACHER)->pluck('name', 'id');
        return view('courses.create', compact('users'));
    }

    public function store(CreateRequest $request, CreateCourseUsescaseInterface $courseUsecase)
    {
        $result = $courseUsecase->handle($request->all());

        if($result['data']){
            flash('Curso creado correctamente');
        } else {
            flash(implode('-', $result['errors']), 'error');
        }

        return redirect()->route('courses.index');
    }

    public function edit($id, UserRepositoryInterface $userRepository, CourseRepositoryInterface $courseRepository)
    {
        $course = $courseRepository->findById($id);
        $users = $userRepository->all(Roles::TEACHER)->pluck('name', 'id');
        $lessons = $course->lessons->all();

        return view('courses.edit', compact('course', 'users', 'lessons'));
    }

    public function update($id, UpdateRequest $request, UpdateCourseUsecaseInterface $courseUsecase)
    {
        $courseUsecase->handle($id, $request->all());
        return redirect()->back();
    }

    public function destroy($id, DeleteCourseUsecaseInterface $courseUsecase)
    {
        $courseUsecase->handle($id);
        return redirect()->route('courses.index');
    }

    public function subscribe($id, SubscribeCourseUsecaseInterface $subscribeCourseUsecase){
        $response = $subscribeCourseUsecase->handle(Auth::user()->id, $id);

        return response()->json($response);
    }
}
