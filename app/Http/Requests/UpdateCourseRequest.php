<?php

namespace App\Http\Requests;

use App\Models\Course;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_edit');
    }

    public function rules()
    {
        return [
            'teacher_id' => [
                'integer',
                'exists:users,id',
                'required',
            ],
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
            'price' => [
                'numeric',
                'nullable',
            ],
            'thumbnail' => [
                'array',
                'nullable',
            ],
            'thumbnail.*.id' => [
                'integer',
                'exists:media,id',
            ],
            'is_published' => [
                'boolean',
            ],
            'students' => [
                'array',
            ],
            'students.*.id' => [
                'integer',
                'exists:users,id',
            ],
        ];
    }
}
