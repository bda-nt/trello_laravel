<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('задача', 'задачи');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Название задаче');
        CRUD::column('project_id')->label('Проект');
        CRUD::column('author_id')->label('Автор');
        CRUD::column('contractor_id')->label('Исполнитель');
        CRUD::column('priority_id')->label('Приоритет');
        CRUD::column('status_id')->label('Статус');
        CRUD::column('deadline')->label('Крайний срок');
        CRUD::column('description')->label('Описание');
        CRUD::column('actual_time')->label('Трудозатраты');
        CRUD::column('is_accepted')->label('Принята');
        CRUD::column('completed_at')->label('Дата завершения');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('name')->label('Название');
        $this->crud->addField([
            'label' => 'Проект',
            'type' => 'select',
            'name' => 'project_id',
            'entity' => 'project',
            'model' => 'App\Models\Project',
            'attribute' => 'name',
        ]);
        $this->crud->addField([
            'label' => 'Автор',
            'type' => 'select',
            'name' => 'author_id',
            'entity' => 'author',
            'model' => 'App\Models\User',
            'attribute' => 'login',
        ]);
        $this->crud->addField([
            'label' => 'Исполнитель',
            'type' => 'select',
            'name' => 'contractor_id',
            'entity' => 'contractor',
            'model' => 'App\Models\User',
            'attribute' => 'login',
        ]);
        $this->crud->addField([
            'label' => 'Приоритет',
            'type' => 'select',
            'name' => 'priority_id',
            'entity' => 'priority',
            'model' => 'App\Models\Priority',
            'attribute' => 'name'
        ]);
        $this->crud->addField([
            'label' => 'Статус',
            'type' => 'select',
            'name' => 'status_id',
            'entity' => 'status',
            'model' => 'App\Models\Status',
            'attribute' => 'name'
        ]);
        CRUD::field('deadline')->label('Крайний срок');
        CRUD::field('description')->label('Описание');
        CRUD::field('actual_time')->label('Трудозатраты');
        CRUD::field('is_accepted')->label('Принята');
        CRUD::field('completed_at')->label('Дата завершения');

        CRUD::setValidation(TaskRequest::class);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
