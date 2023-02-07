<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TaskShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->merge([
            'taskId' => $this->route('taskId'),
            'projectId' => $this->route('projectId')
        ]); // изменение request

        $this->validate([
            'taskId' => [
                // Если задача есть у этого проекта
                Rule::exists('tasks', 'id')->where(function ($query) {
                    return $query->where('project_id', $this->projectId);
                }),
            ],
        ]);

        /**
         *  @var User $user
         * */

        $user = Auth::user();
        $projects = $user->getAtctiveProject();
        $projectId = $this->projectId;
        $intProjects = array();
        foreach ($projects as $key => $project) {
            $intProjects[] = $project->id;
        }

        if (!in_array($projectId, $intProjects)) {
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
