<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskIndexRequest;
use App\Http\Resources\Api\TaskShortResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskIndexRequest $request)
    {
        $projectsId = $request->projectsId;
        /** @var User $user */
        $user = $request->user;
        $userId = $user->id;
        $isMyTasks = $request->isMyTasks;
        $response = [];
        // В каждой итерации цикла, происходит запрос в бд
        // Думаю можно в одном запросе сделать несколько select обращений
        // От идеи leftjoin отказался пока что
        // resource класс не стал делать. Чтобы не тратить время. Потом сделаю.
        // Как понял нам до 11 декабря надо уже все сделать
        foreach ($projectsId as $key => $id) {
            $sql = $user->projects()
                ->join('tasks', function ($join) use ($userId, $isMyTasks) {
                    $join->on("projects.id", "=", "tasks.project_id")
                        ->where('tasks.is_off', '=', false)
                        ->where('tasks.is_accepted', '=', true)
                        ->when($isMyTasks === true, function ($query) use ($userId, $isMyTasks) {
                            return $query->where('contractor_id', '=', $userId);
                        });
                })
                ->join('users', function ($join) {
                    $join->on("tasks.contractor_id", "=", "users.id");
                })
                ->where('projects.id', '=', $id)
                ->where('projects.is_off', '=', false)
                ->get([
                    'projects.id AS project_id', 'projects.name AS project_name',
                    'tasks.id AS task_id', 'tasks.name AS task_name',
                    'users.name AS contractor_name', 'users.surname AS contractor_surname',
                    'tasks.status_id', 'tasks.priority_id', 'tasks.deadline'
                ]);
            $sql->makeHidden(['pivot']);
            $response[] = [
                "idProject" => $id, "nameProjects" => $sql[0]->project_name,
                "tasks" => $sql
            ];
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
