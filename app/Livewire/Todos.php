<?php

namespace App\Livewire;

use Livewire\Component;

class Todos extends Component
{
    public $todo = '';

    public $todos = [];

    public function mount()
    {
        $this->todos = ['Take Out Cash', 'Do Dishes'];
    }
    public function updatedtodo($value)
    {
        $this->todo = strtoupper($value);
    }
    public function add()
    {
        $this->todos[] = $this->todo;
        $this->reset('todo');
    }
    public function render()
    {
        return view('livewire.todos');
    }
}
