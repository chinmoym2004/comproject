<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UserPanel extends Component
{
    use WithPagination;

    public $sortField = 'created_at'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';
    public $selected_members=[];

    protected $listeners = ['Refresh' => '$refresh'];


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $users = User::search(trim($this->search))
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate(20);

        return view('livewire.user-panel',['users'=>$users]);
    }

    public function selectedMember($id,$text)
    {   
        if($id)
        {
            $selected_members[$id]=$text;
        }
    }
}
