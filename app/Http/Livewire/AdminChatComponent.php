<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use App\Models\Chat;
use App\Models\User;

class AdminChatComponent extends Component
{
    use WithPagination;

    public $sortField = 'title'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['delete', 'triggerRefresh' => '$refresh','triggerEdit','chatMembersSelected'];

    public $title;
    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;

    protected $rules = [
        'title'=>'required',
    ];

    private function resetInput()
    {
        $this->chat_id = null;
        $this->title = null;
        $this->member_ids = [];
        $this->members = null;
    }

    public function chatMembersSelected($chatMembers)
    {
        $this->member_ids = $chatMembers;
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
        $chats = Chat::search($this->search)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->simplePaginate(20);

        return view('livewire.chats.component',['chats'=>$chats]);
    }

    public function submit()
    {
        //dd($this->validate());

        $this->validate();
        $user = Auth::user();
        try
        {
            Chat::create([
                'title' => $this->title,
                'user_id' => $user->id
            ]);
            
            session()->flash('success','Category Created Successfully!!');

            $this->resetInput();
            $this->dispatchBrowserEvent('group-saved', ['action' => 'created', 'group_title' => $this->title]);
            $this->emit('triggerRefresh');
            
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating category!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    // public function edit($id)
    // {
    //     //$id = decrypt($id);

    //     $record = Chat::findOrFail($id);
    //     $this->member_ids = $record->members ?? null;
    //     $this->title = $record->title;
    //     $this->updateMode = true;
    //     $this->selected_id = $id;
    //     $this->members = User::take(50)->get();
    // }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInput();
    }

    public function update()
    {
        $this->validate();

        $selecetd_members = $this->member_ids ?? [];

        //dd($this);

        try
        {
            $record = Chat::find($this->selected_id);
            $record->update([
                'title' => $this->title
            ]);
            $record->members()->sync($selecetd_members);
            session()->flash('success','Category Updated Successfully!!');
            $this->cancel();
            //$this->dispatchBrowserEvent('group-saved', ['action' => 'created', 'group_title' => $this->title]);
            $this->emit('triggerRefresh');

            //dd($record);

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }

    }

    public function triggerEdit($id)
    {
        $record = Chat::find($id);

        $this->selected_id = $record->id;
        $this->title = $record->title;
        $this->member_ids = $record->members?$record->members()->pluck('user_id')->toArray():[];
        $this->updateMode = true;
        $this->members = User::take(50)->get();
        $this->emit('dataFetched', $record);
    }

    public function destroy($id)
    {
        //$id = decrypt($id);
        
        if ($id) {
            $record = Chat::where('id', $id);
            $record->delete();
            $this->dispatchBrowserEvent('chat-grpup-deleted', ['title' => $chat->title]); // add this
        }
    }

    public function start1to1chat($user_id)
    {
        if ($user_id) {
            $user_id = decrypt($user_id);
            $chat_with = User::where('id', $id);
            $me = Auth::user();

            $record = Chat::create([
                'title' => $chat_with->name.",",$me->name,
                'user_id' => $me->id
            ]);

            $selecetd_members = [$chat_with->id,$me->id];

            $record->members()->sync($selecetd_members);
            
            $this->dispatchBrowserEvent('chat-box-open', ['title' => $record->title]); // add this
        }
    }
}
