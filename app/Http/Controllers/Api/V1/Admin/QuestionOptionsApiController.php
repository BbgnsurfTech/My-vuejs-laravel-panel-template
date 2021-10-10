<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionOptionRequest;
use App\Http\Requests\UpdateQuestionOptionRequest;
use App\Http\Resources\Admin\QuestionOptionResource;
use App\Models\Question;
use App\Models\QuestionOption;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionOptionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_option_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionOptionResource(QuestionOption::with(['question'])->advancedFilter());
    }

    public function store(StoreQuestionOptionRequest $request)
    {
        $questionOption = QuestionOption::create($request->validated());

        return (new QuestionOptionResource($questionOption))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('question_option_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'question' => Question::get(['id', 'question_text']),
            ],
        ]);
    }

    public function show(QuestionOption $questionOption)
    {
        abort_if(Gate::denies('question_option_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionOptionResource($questionOption->load(['question']));
    }

    public function update(UpdateQuestionOptionRequest $request, QuestionOption $questionOption)
    {
        $questionOption->update($request->validated());

        return (new QuestionOptionResource($questionOption))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(QuestionOption $questionOption)
    {
        abort_if(Gate::denies('question_option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new QuestionOptionResource($questionOption->load(['question'])),
            'meta' => [
                'question' => Question::get(['id', 'question_text']),
            ],
        ]);
    }

    public function destroy(QuestionOption $questionOption)
    {
        abort_if(Gate::denies('question_option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionOption->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
