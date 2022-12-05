<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Mockery\Undefined;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->merge([
            'projectId' => $this->route('projectId'),
            'taskId' => $this->route('taskId')
        ]); // изменение request

        $this->validate([
            // Эта проверка выполняется в контроллере. Экономит один запрос в бд
            // 'taskId' => [
            //     Rule::exists('tasks', 'id')->where(function ($query) {
            //         return $query->where('project_id', $this->projectId);
            //     }),
            // ],
            'project_id' => [
                Rule::exists('projects', 'id'),
            ],
            'name' => [
                'max:64',
                'min:3',
                'string',
                Rule::unique('tasks')->where(function ($query) {
                    if ($this->project_id === null) {
                        return $query->where('name', $this->name)
                            ->where('project_id', $this->projectId);
                    }
                    return $query->where('name', $this->name)
                        ->where('project_id', $this->project_id);
                }),
            ],
            // 'contractor_id' => [ // Создание задачи только для себя. это поле игнорируется
            //     Rule::exists('users', 'id'),
            // ],
            'priority_id' => [
                Rule::exists('priorities', 'id'),
            ],
            'status_id' => [
                Rule::exists('statuses', 'id'),
            ],
            'description' => [
                'max:255',
                'min:3',
                'string',
            ],
            'deadline' => [
                'date'
            ],
            'actual_time' => [ // decimal(4,1)
                'numeric',
                'between:0,999.9'
                // 'regex:/^\d+(\.\d{1,2})?$/'
                // Можно добавить регулярку на проверку нецелых чисел
            ],
            'is_accepted' => [
                'boolean' // true, false, 1, 0, "1", and "0"
            ],
            'stages' => [
                'array',
                'min:1',
            ],
            'stages.*' => [
                'array',
                'min:1',
            ],
            'stages.*.description' => [
                'string',
                'max:128',
                'min:3',
            ],
            'stages.*.is_ready' => [
                'boolean' // true, false, 1, 0, "1", and "0"
            ],
            'stages.*.id' => [
                Rule::exists('stages', 'id')->where(function ($query) {
                    return $query->where('task_id', $this->taskId);
                }),
            ],
        ]);

        /**
         *  @var User $user
         * */

        $user = Auth::user();
        $this->user = $user; // изменение request
        $projects = $user->getAtctiveProject();
        $projectId = $this->projectId;
        $intProjects = array();
        foreach ($projects as $key => $project) {
            $intProjects[] = $project->id;
        }
        if (!in_array($projectId, $intProjects)) {
            return false;
        }

        if ($this->project_id !== null) {
            if (!in_array($this->project_id, $intProjects)) {
                return false;
            }
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
