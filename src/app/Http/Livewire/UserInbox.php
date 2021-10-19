<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inbox;
use Livewire\WithPagination;
use Auth;

class UserInbox extends Component
{
    use WithPagination;
    public $perPage = 20;

    public $sortField = 'show_text'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['triggerRefresh' => '$refresh'];


    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

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
        $user = Auth::user();

        $inmessages = Inbox::search($this->search)
        ->where('user_id',$user->id)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate(20);

        return view('livewire.user-inbox',['inmessages'=>$inmessages]);
    }

}
