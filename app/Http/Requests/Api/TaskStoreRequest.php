<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            ],
            'name' => [
                'required',
                'max:64',
                'min:3',
                'string',
                Rule::unique('tasks')->where(function ($query) {
                    return $query->where('name', $this->name)
                        ->where('project_id', $this->project_id);
                }),
            ],
            // 'contractor_id' => [ // Создание задачи только для себя. это поле игнорируется
            //     'required',
            //     //'numeric',
            //     Rule::exists('users', 'id'),
            // ],
            'priority_id' => [
                'required',
                //'numeric',
                Rule::exists('priorities', 'id'),
            ],
            'description' => [
                'max:255',
                'min:3',
                'string',
            ],
            'deadline' => [
                'date'
            ],
            'stages' => [
                'array',
                'min:1',
            ],
            'stages.*' => [
                'string',
                'max:128',
                'min:3',
            ],
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
