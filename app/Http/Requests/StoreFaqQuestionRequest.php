<?php

namespace App\Http\Requests;

use App\Models\FaqQuestion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFaqQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faq_question_create');
    }

    public function rules()
    {
        return [
            'category_id' => [
                'integer',
                'exists:faq_categories,id',
                'required',
            ],
            'question' => [
                'string',
                'required',
            ],
            'answer' => [
                'string',
                'required',
            ],
        ];
    }
}
