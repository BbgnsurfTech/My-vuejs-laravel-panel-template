<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Http\Resources\Admin\TestResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Test;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('test_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TestResource(Test::with(['course', 'lesson'])->advancedFilter());
    }

    public function store(StoreTestRequest $request)
    {
        $test = Test::create($request->validated());

        return (new TestResource($test))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('test_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'course' => Course::get(['id', 'title']),
                'lesson' => Lesson::get(['id', 'title']),
            ],
        ]);
    }

    public function show(Test $test)
    {
        abort_if(Gate::denies('test_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TestResource($test->load(['course', 'lesson']));
    }

    public function update(UpdateTestRequest $request, Test $test)
    {
        $test->update($request->validated());

        return (new TestResource($test))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Test $test)
    {
        abort_if(Gate::denies('test_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new TestResource($test->load(['course', 'lesson'])),
            'meta' => [
                'course' => Course::get(['id', 'title']),
                'lesson' => Lesson::get(['id', 'title']),
            ],
        ]);
    }

    public function destroy(Test $test)
    {
        abort_if(Gate::denies('test_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
