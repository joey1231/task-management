<?php

namespace App\Livewire;

use App\Livewire\Forms\TaskForm;
use App\Models\Task as TaskModel;
use Livewire\Component;

class Task extends Component
{
    public TaskForm $taskForm;
    public $tasks;
    public function mount($task = null)
    {
        $this->taskForm->set();
    }
    public function render()
    {

        $this->tasks = TaskModel::orderBy('priority', 'ASC')->get();
        return view('livewire.task');
    }

    public function sorts($taskIds)
    {
        foreach ($taskIds as $key => $id) {
            $task = TaskModel::find($id);
            $task->priority = $key + 1;
            $task->save();
        }

        $this->tasks = TaskModel::orderBy('priority', 'ASC')->get();
    }

    public function delete($id)
    {
        TaskModel::find($id)->delete();
        $this->tasks = TaskModel::orderBy('priority', 'ASC')->get();
        $this->dispatch('render-event');
    }

    public function edit($id)
    {
        $task = TaskModel::find($id);
        $this->taskForm->name = $task->name;
        $this->taskForm->id = $task->id;
        $this->taskForm->priority = $task->priority;

    }
    public function store()
    {

        $this->taskForm->submit();
        $this->dispatch('notify', [
            'text' => 'Saved',
            'color' => "green",
        ]);

        return redirect(url()->previous());
    }
}
