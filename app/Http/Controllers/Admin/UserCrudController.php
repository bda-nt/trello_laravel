<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
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

        $this->crud->addField([
            'label' => 'Projects',
            'type' => 'checklist',
            'name' => 'projects',
            'entity' => 'projects',
            'attribute' => 'id',
            'model' => 'App\Models\Project',
            'pivot' => true
        ]);
    }

    public function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->addColumn([

        ]);
    }
}
