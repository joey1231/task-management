<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TaskForm extends Form
{
    #[Validate('required')]
    public $name;

    public $id;

    public $priority;
    public function submit()
    {
        $this->validate();
        $fields = $this->all();

        if ($this->id != null) {
            return Task::where('id', $this->id)->update($fields);
        } else {
            $fields['priority'] = ($task = Task::orderBy('priority', 'DESC')->first()) ? $task->priority + 1 : 1;
            return Task::create($fields);
        }

    }

    public function set()
    {}
}
