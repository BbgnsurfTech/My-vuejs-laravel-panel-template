<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\Admin\QuestionResource;
use App\Models\Question;
use App\Models\Test;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class QuestionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionResource(Question::with(['course'])->advancedFilter());
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->validated());

        if ($media = $request->input('question_image', [])) {
            Media::whereIn('id', data_get($media, '*.id'))
                ->where('model_id', 0)
                ->update(['model_id' => $question->id]);
        }

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'course' => Test::get(['id', 'title']),
            ],
        ]);
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionResource($question->load(['course']));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        $question->updateMedia($request->input('question_image', []), 'question_question_image');

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new QuestionResource($question->load(['course'])),
            'meta' => [
                'course' => Test::get(['id', 'title']),
            ],
        ]);
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['question_create', 'question_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model         = new Question();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        return response()->json($media, Response::HTTP_CREATED);
    }
}
