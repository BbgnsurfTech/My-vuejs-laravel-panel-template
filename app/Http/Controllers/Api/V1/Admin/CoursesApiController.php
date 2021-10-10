<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\Admin\CourseResource;
use App\Models\Course;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CoursesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource(Course::with(['teacher', 'students'])->advancedFilter());
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());
        $course->students()->sync($request->input('students.*.id', []));
        if ($media = $request->input('thumbnail', [])) {
            Media::whereIn('id', data_get($media, '*.id'))
                ->where('model_id', 0)
                ->update(['model_id' => $course->id]);
        }

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'teacher'  => User::get(['id', 'name']),
                'students' => User::get(['id', 'name']),
            ],
        ]);
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource($course->load(['teacher', 'students']));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        $course->students()->sync($request->input('students.*.id', []));
        $course->updateMedia($request->input('thumbnail', []), 'course_thumbnail');

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new CourseResource($course->load(['teacher', 'students'])),
            'meta' => [
                'teacher'  => User::get(['id', 'name']),
                'students' => User::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['course_create', 'course_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model         = new Course();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        return response()->json($media, Response::HTTP_CREATED);
    }
}
