<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\ProjectComment;

class ProjectCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request= Request();
        return ProjectComment::getProjectCommentValidationRulesArray( $request->get('project_id'), $request->get('id'), ['project_id', 'user_id'] );
    }


    public function messages()
    {
        return [
            'comment.required' => 'Please enter comment',
        ];
    }
}
