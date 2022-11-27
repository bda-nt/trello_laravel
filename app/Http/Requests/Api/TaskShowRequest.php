<?php

namespace App\Http\Requests\Api;

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
