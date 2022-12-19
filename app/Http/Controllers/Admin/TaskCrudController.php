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
        CRUD::setEntityNameStrings('task', 'tasks');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('project_id');
        CRUD::column('author_id');
        CRUD::column('contractor_id');
        CRUD::column('priority_id');
        CRUD::column('status_id');
        CRUD::column('deadline');
        CRUD::column('description');
        CRUD::column('actual_time');
        CRUD::column('is_accepted');
        CRUD::column('completed_at');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::setValidation(TaskRequest::class);

        CRUD::field('name');
        $this->crud->addField([
            'label' => 'Project',
            'type' => 'select',
            'name' => 'project_id',
            'entity' => 'project',
            'model' => 'App\Models\Project',
            'attribute' => 'name',
        ]);
        $this->crud->addField([
            'label' => 'Author',
            'type' => 'select',
            'name' => 'author_id',
            'entity' => 'author',
            'model' => 'App\Models\User',
            'attribute' => 'login',
        ]);
        $this->crud->addField([
            'label' => 'Contractor',
            'type' => 'select',
            'name' => 'contractor_id',
            'entity' => 'contractor',
            'model' => 'App\Models\User',
            'attribute' => 'login',
        ]);
        $this->crud->addField([
            'label' => 'Priority',
            'type' => 'select',
            'name' => 'priority_id',
            'entity' => 'priority',
            'model' => 'App\Models\Priority',
            'attribute' => 'name'
        ]);
        $this->crud->addField([
            'label' => 'Status',
            'type' => 'select',
            'name' => 'status_id',
            'entity' => 'status',
            'model' => 'App\Models\Status',
            'attribute' => 'name'
        ]);
        CRUD::field('deadline');
        CRUD::field('description');
        CRUD::field('actual_time');
        CRUD::field('is_accepted');
        CRUD::field('completed_at');
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
