<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLessonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('lesson_edit');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'integer',
                'exists:courses,id',
                'required',
            ],
            'title' => [
                'string',
                'required',
            ],
            'thumbnail' => [
                'array',
                'nullable',
            ],
            'thumbnail.*.id' => [
                'integer',
                'exists:media,id',
            ],
            'short_text' => [
                'string',
                'nullable',
            ],
            'long_text' => [
                'string',
                'nullable',
            ],
            'video' => [
                'array',
                'nullable',
            ],
            'video.*.id' => [
                'integer',
                'exists:media,id',
            ],
            'position' => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'nullable',
            ],
            'is_published' => [
                'boolean',
            ],
            'is_free' => [
                'boolean',
            ],
        ];
    }
}
