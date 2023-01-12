<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255|unique:App\Models\Task,name',
            'project_id' => 'required|integer',
            'author_id' => 'required|integer',
            'contractor_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'status_id' => 'required|integer',
            'deadline' => 'date',
            'actual_time' => 'required',
            'is_accept' => 'boolean',
            'completed_at' => 'date',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Название обязательно к заполнению',
            'name.min' => 'Название слишком короткое',
            'name.max' => 'Название слишком длинное',
            'name.unique' => 'Название должно быть уникально',
            'project_id.required' => 'Проект обязателен к заполнению',
            'project_id.integer' => 'Упс, что-то пошло не так',
            'author_id.required' => 'Автор обязателен к заполнению',
            'author_id.integer' => 'Упс, что-то пошло не так',
            'contractor_id.required' => 'Исролнитель обязателен к заполнению',
            'contractor_id.integer' => 'Упс, что-то пошло не так',
            'priority_id.required' => 'Приоритет обязателен к заполнению',
            'priority_id.integer' => 'Упс, что-то пошло не так',
            'status_id.required' => 'Статус обязателен к заполнению',
            'status_id.integer' => 'Упс, что-то пошло не так',
            'deadline.date' => 'Ожидалась дата, перепроверьте',
            'actual_time.required' => 'Трудозатраты обязателены к заполнению',
            'actual_time.decimal' => 'Введите дату',
            'is_accept.required' => 'Принятие обязательно к заполнению',
            'is_accept.boolean' => 'Упс, что-то пошло не так',
            'completed_at.date' => 'Ожидалась дата, перепроверьте'
        ];
    }
}
