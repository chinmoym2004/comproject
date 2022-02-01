<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Group;
use App\Models\Forum;
use App\Models\Circular;
use Auth;

class GroupPanel extends Component
{
    use WithPagination;

    public $sortField = 'created_at'; // default sorting field
    public $sortAsc = false; // default sort direction
    public $search = '';

    public $title;
    public $description;
    public $selected_id;

    public $member_ids=[];
    public $members;
    public $updateMode = false;
    public $memberupdateMode = false;
    public $perpage = 20;

    protected $listeners = ['destroygroup','triggerRefresh' => '$refresh','triggergroupEdit','fetchGroupmembers','selectedFromSearch'];

    protected $rules = [
        'title'=>'required',
    ];

    private function resetInput()
    {
        $this->selected_id = null;
        $this->title = null;
        $this->description = null;
        $this->member_ids = [];
        $this->members = null;

        $this->updateMode = false;

        $this->memberupdateMode = false;        
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
        $groups = Group::search(trim($this->search))
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perpage);

        return view('livewire.group-panel',['groups'=>$groups]);
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        try
        {
            Group::create([
                'title' => $this->title,
                'description'=>$this->description,
                'created_by' => $user->id
            ]);
            
            $this->dispatchBrowserEvent('group-saved', ['action' => 'created', 'title' => $this->title]);
            $this->emit('triggerRefresh');
            $this->resetInput();

        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while creating group!!');
            $this->resetInput();
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInput();
    }

    public function update()
    {
        $this->validate();

        try
        {
            $record = Group::find($this->selected_id);
            $record->update([
                'title' => $this->title,
                'description'=>$this->description,
            ]);
            
            $this->resetInput();

            $this->dispatchBrowserEvent('group-updated', ['action' => 'updated', 'title' => $this->title]);

            //dd($record);

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }

        $this->emit('triggerRefresh');
    }

    public function triggergroupEdit($id)
    {
        $record = Group::find($id);

        $this->selected_id = $record->id;
        $this->title = $record->title;
        $this->description = $record->description;
        $this->updateMode = true;

        $this->emit('groupDataFetched', $record);
    }

    public function fetchGroupmembers($id)
    {
        $record = Group::find($id);

        $this->selected_id = $record->id;
        $this->members = $record->members??null; //?$record->members()->pluck('user_id')->toArray():
        $this->memberupdateMode = true;

        $this->emit('groupMemberDataFetched');
    }

    public function destroygroup($id)
    { 
        if ($id) {
            $record = Group::find($id);
            $title = $record->title;

            // check if used 
            $block_delete = 0;

            $hasinforum = Forum::where('group_id',$id)->count();
            if(!$hasinforum)
            {
                $hasincircular = Circular::whereRaw("FIND_IN_SET('".$id."',group_ids)")->count();
                if($hasincircular)
                    $block_delete = 1;
            }
            else
                $block_delete = 1;
            
            if($block_delete)
            {
                session()->flash('error','This is in use. Can not delete');
                $this->emit('triggerRefresh');
            }
            else{
                $record->delete();
                $this->dispatchBrowserEvent('group-deleted', ['title' => $title]); // add this
            }
        }
    }

    public function selectedFromSearch($data)
    {
        $this->member_ids[$data['id']]=$data['text'];
    }

    public function unselectMember($id)
    {
        unset($this->member_ids[$id]);
    }

    public function removeMember($id)
    {
        $record = Group::find($this->selected_id);
        if($id)
        {
            $record->members()->detach($id);
            $this->dispatchBrowserEvent('memberRemoved',['id'=>$id]);
        }

    }

    public function updateMember()
    {
        $record = Group::find($this->selected_id);
        $member_id_keys = array_keys($this->member_ids);
        if(count($member_id_keys))
        {
            $record->members()->attach($member_id_keys);
        }

        $this->emit('triggerRefresh');
        $this->dispatchBrowserEvent('memberUpdated');
        $this->memberupdateMode = false;
        $this->resetInput();
    }
}
