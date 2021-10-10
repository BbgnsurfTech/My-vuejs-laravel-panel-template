<?php

namespace App\Http\Requests;

use App\Models\TestAnswer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTestAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('test_answer_edit');
    }

    public function rules()
    {
        return [
            'test_result_id' => [
                'integer',
                'exists:test_results,id',
                'required',
            ],
            'question_id' => [
                'integer',
                'exists:questions,id',
                'required',
            ],
            'option_id' => [
                'integer',
                'exists:question_options,id',
                'required',
            ],
            'is_correct' => [
                'boolean',
            ],
        ];
    }
}
