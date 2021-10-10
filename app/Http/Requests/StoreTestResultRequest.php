<?php

namespace App\Http\Requests;

use App\Models\TestResult;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTestResultRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('test_result_create');
    }

    public function rules()
    {
        return [
            'test_id' => [
                'integer',
                'exists:tests,id',
                'nullable',
            ],
            'student_id' => [
                'integer',
                'exists:users,id',
                'required',
            ],
            'score' => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'nullable',
            ],
        ];
    }
}
