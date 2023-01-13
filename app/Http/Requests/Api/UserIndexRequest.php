<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->validate([
            'project_id' => [
                'required',
                //'numeric',
                Rule::exists('projects', 'id'),
            ]
        ]);

        /**
         *  @var User $user
         * */

        $user = Auth::user();
        $this->user = $user; // изменение request
        $projects = $user->getAtctiveProject();
        $project_id = $this->project_id;
        $intProjects = array();
        foreach ($projects as $key => $project) {
            $intProjects[] = $project->id;
        }

        if (!in_array($project_id, $intProjects)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
