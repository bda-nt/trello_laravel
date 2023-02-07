<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TaskIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        $this->validate([
            'projectsId' => [
                'required',
                'array'
            ],
            'projectsId.*' => [
                'required',
                'numeric',
            ],
            'isMyTasks' => [
                'boolean' // для параметра в url, это "1" или "0"
            ],
        ]);

        /**
         *  @var User $user
         * */
        $user = Auth::user();
        $this->user = $user; // изменение request
        $projects = $user->getAtctiveProject();

        $intProjects = array();
        foreach ($projects as $key => $project) {
            $intProjects[] = $project->id;
        }

        $queruProjects = $this->projectsId;
        foreach ($queruProjects as $key => $queryProject) {
            if (!in_array($queryProject, $intProjects)) {
                return false;
            }
        }
        $this->isMyTasks = $this->isMyTasks === "1" ? true : false; // изменение request
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
