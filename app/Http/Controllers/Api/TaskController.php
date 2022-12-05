<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\Stage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskShowRequest;
use App\Http\Requests\Api\TaskIndexRequest;
use App\Http\Requests\Api\TaskStoreRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
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
    public function store(TaskStoreRequest $request)
    {
        // $is_accepted = false;
        // if ($request->contractor_id === $request->user->id) {
        //     $is_accepted = true; // если автор создает задачу себе, то она автоматически принимается
        // }
        $is_accepted = true;
        $task = Task::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            // 'contractor_id' => $request->contractor_id,
            'contractor_id' => $request->user->id,
            'priority_id' => $request->priority_id,
            'status_id' => 1, // Новые
            'description' => $request->description,
            'deadline' => $request->deadline,

            'author_id' => $request->user->id,
            'is_accepted' => $is_accepted
        ]);
        $stages = array();
        $res = [];
        if ($request->stages !== null) {
            foreach ($request->stages as $key => $stage) {
                $stages[] = new Stage(['description' => $stage, 'is_ready' => false]);
            }
            $res = $task->stages()->saveMany($stages);
        }
        // можно объединить в один запрос
        // resource надо будет сделать
        return $res = ["task" => $task, "stages" => $res];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TaskShowRequest $request)
    {
        $task = Task::join('projects', function ($join) {
            $join->on("tasks.project_id", "=", "projects.id");
        })
            ->join('users', function ($join) {
                $join->on("tasks.contractor_id", "=", "users.id");
            })
            ->join('statuses', function ($join) {
                $join->on("tasks.status_id", "=", "statuses.id");
            })
            ->join('priorities', function ($join) {
                $join->on("tasks.priority_id", "=", "priorities.id");
            })
            ->where('tasks.project_id', '=', $request->projectId)
            ->select([
                'projects.name AS project_name', 'tasks.project_id',
                'tasks.id AS task_id', 'tasks.name AS task_name',
                'tasks.contractor_id', 'users.name AS contractor_name',
                'users.surname AS contractor_surname',
                'tasks.priority_id', 'priorities.name AS priority_name',
                'tasks.status_id', 'statuses.name AS status_name',
                'tasks.deadline', 'tasks.description', 'tasks.actual_time',
            ])
            ->find($request->taskId);
        $stages = Stage::where('task_id', '=', $request->taskId)
            ->get(['stages.id', 'stages.description', 'stages.is_ready']);
        // Можно объединить в один запрос $task и $stages
        // Сделаем это после первой работающей версией
        // ресурс тоже потом добавим
        // Можно запрос при валидации убрать. И валидировать после запроса $task. будет минус один запрос к бд
        $task->stages = $stages;
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request)
    {
        // Нужно либо правило валидации создать. Либо как-то переместить этот кусок
        $stages = $request->stages;
        if ($stages !== null) {
            foreach ($stages as $key => $stage) {
                // Если есть id то должно быть или is_ready или description или то и то
                // если id нет. то должно быть is ready и desk. При этом создается новый stage
                if (array_key_exists("id", $stage)) {
                    if ((!array_key_exists("is_ready", $stage)) && (!array_key_exists("description", $stage))) {
                        return response(["message" => 'Неправильный stages'], 422);
                    }
                } else {
                    if ((!array_key_exists("is_ready", $stage)) || (!array_key_exists("description", $stage))) {
                        return response(["message" => 'Неправильный stages'], 422);
                    }
                }
            }
        }
        $task = Task::where('project_id', '=', $request->projectId)
            ->find($request->taskId);
        if ($task === null) {
            return response(["message" => 'У этого проекта нет этой задачи'], 422);
        }
        if ($request->user->id !== $task->contractor_id && $request->user->id !== $task->author_id) {
            return response(["message" => 'Вы не автор и не исполнитель задачи'], 403); //
        }
        if ($task->status_id === 2) { // статус = Выполнено
            return response(["message" => 'Нельзя изменять задачи со статусом выполнено'], 403);
        }
        if ($request->status_id === 2) { // статус = Выполнено
            if ($request->actual_time === null && $task->actual_time === null) {
                return response(["message" => 'Укажите время выполнения'], 403);
            } else {
                if (($request->actual_time > 0) || ($task->actual_time !== null && $request->actual_time === null)) {
                    $stages_have_is_ready_true = [];
                    $request_is_have_stages = $request->stages !== null;
                    if ($request_is_have_stages) {
                        $requestStages = $request->stages;
                        foreach ($requestStages as $key => $requestStage) {
                            if (array_key_exists("is_ready", $requestStage)) {
                                if ($requestStage === false) {
                                    return response(["message" => 'Выполните все этапы задачи'], 403);
                                    // При смене статуса на "выполнено"
                                    // Создавали новые этапы невыполненными или изменяли этапы на невыполненные
                                }
                                $stages_have_is_ready_true[] = $requestStage;
                            }
                        }
                    }

                    $stages_no_ready = $task->stages()->where('is_ready', '=', false)->get(['id', 'description', 'is_ready']);
                    if ($stages_no_ready !== null) {
                        foreach ($stages_no_ready as $key => $stage) {
                            $is_change = false;
                            if ($request_is_have_stages) {
                                foreach ($stages_have_is_ready_true as $key => $requestStage) {
                                    if (array_key_exists("id", $requestStage)) {
                                        if ($stage->id === $requestStage["id"]) {
                                            $is_change = true;
                                            break;
                                        }
                                    }
                                }
                            }
                            if ($is_change === false) {
                                // Значит, что при смене статуса на "выполнено"
                                // Невыполненные этапы, не выполнили
                                return response(["message" => 'Выполните все этапы задачи'], 403);
                            }
                        }
                    }
                } else {
                    return response(["message" => 'Время выполнения должно быть больше нуля'], 403);
                }
            }
        }

        // Доделать само обновление
        return $task;
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
