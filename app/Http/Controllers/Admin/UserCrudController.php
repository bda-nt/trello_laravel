<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends \Backpack\PermissionManager\app\Http\Controllers\UserCrudController
{
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings('user', 'users');
    }

    public function setupCreateOperation()
    {
        parent::setupCreateOperation();

        $this->addUserField();
    }

    public function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->addColumn([
            'label' => 'Projects',
            'type' => 'select_multiple',
            'name' => 'projects',
            'entity' => 'projects',
            'attribute' => 'name',
            'model' => 'App\Models\Project'
        ]);

        $this->crud->addColumn([
            'label' => 'Surname',
            'type' => 'string',
            'name' => 'surname'
        ])->afterColumn('name');

        $this->crud->addColumn([
            'label' => 'Login',
            'type' => 'string',
            'name' => 'login'
        ])->afterColumn('surname');
    }

    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();

        $this->addUserField();
    }

    /**
     * @return void
     */
    private function addUserField(): void
    {
        $this->crud->addField([
            'label' => 'Projects',
            'type' => 'checklist',
            'name' => 'projects',
            'entity' => 'projects',
            'attribute' => 'name',
            'model' => 'App\Models\Project',
            'pivot' => true
        ]);

        $this->crud->addField([
            'label' => 'Surname',
            'type' => 'text',
            'name' => 'surname'
        ])->afterField('name');

        $this->crud->addField([
            'label' => 'Login',
            'type' => 'text',
            'name' => 'login'
        ])->afterField('surname');
    }
}
