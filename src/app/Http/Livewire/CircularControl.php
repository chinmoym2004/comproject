<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Circular;
use Auth;
use App\Models\Group;

class CircularControl extends Component
{
    use WithPagination;

    public $sortField = 'created_at'; // default sorting field
    public $sortAsc = false; // default sort direction
    public $search = '';

    protected $listeners = ['circular-delete', 'triggerRefresh' => '$refresh','triggercircularEdit','destroycircular','fetchGroupForCircular'];

    public $title,$details;
    public $selected_id;
    public $need_confirmation;
    public $updateMode = false;
    public $createMode = false;
    public $groups;
    public $to_all=0;
    public $group_ids=[];
    public $perPage = 20;

    protected $rules = [
        'title'=>'required',
        'details'=>'required'
    ];

    private function resetInput()
    {
        $this->selected_id = null;
        $this->title = null;
        $this->details = [];
        $this->need_confirmation = 1;
        $this->to_all=0;
        $this->group_ids=null;
        $this->updateMode = false;
    }

    public function render()
    {
        $circulars = Circular::search($this->search)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.circular-control',['circulars'=>$circulars]);
    }

    public function fetchGroupForCircular()
    {
        $this->createMode = true;
        $this->groups = Group::all();
        $this->emit('fetchedGroupForCircular');
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();
        try
        {
            $record = Circular::create([
                'title' => $this->title,
                'details' => $this->details,
                'need_confirmation' => $this->need_confirmation,
                'user_id' => $user->id,
                'group_ids'=>$this->group_ids?implode(',',$this->group_ids):null,
            ]);

            $circularmember = [];
            if($this->group_ids)
            {
                $grps = Group::whereIn('id',$this->group_ids)->get();
                foreach($grps as $grp)
                {
                    $result = $grp->members()->pluck('user_id')->toArray();
                    $circularmember = array_merge($circularmember,$result);
                }
                if(count($circularmember))
                    $record->members()->sync($circularmember);
            }
            
            $this->dispatchBrowserEvent('circular-saved', ['action' => 'created', 'title' => $this->title]);
            $this->emit('triggerRefresh');

            $this->cancel();

        }catch(\Exception $e){
            report($e);
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            $this->resetInput();
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->createMode = false;
        $this->resetInput();
    }

    public function update()
    {
        $this->validate();
        $user = Auth::user();
        try
        {
            $record = Circular::find($this->selected_id);

            $record->update([
                'title' => $this->title,
                'details' => $this->details,
                'need_confirmation' => $this->need_confirmation,
                'user_id' => $user->id,
                'group_ids'=>$this->group_ids?implode(',',$this->group_ids):null,
            ]);

            $circularmember = [];
            if($this->group_ids)
            {
                //print_r($this->group_ids);

                $grps = Group::whereIn('id',$this->group_ids)->get();

                foreach($grps as $grp)
                {
                    $result = $grp->members()->pluck('user_id')->toArray();
                    $circularmember = array_merge($circularmember,$result);
                }
                //dd($circularmember);exit;
                if(count($circularmember))
                    $record->members()->sync($circularmember);
            }
           
            $this->dispatchBrowserEvent('circular-updated', ['action' => 'updated', 'title' => $this->title]);
            $this->resetInput();
            $this->emit('triggerRefresh');

            $this->cancel();

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }

    }

    public function triggercircularEdit($id)
    {
        $record = Circular::find($id);

        $this->selected_id = $record->id;
        $this->title = $record->title;
        $this->details = $record->details;
        $this->need_confirmation = $record->need_confirmation;
        $this->group_ids = $record->group_ids?explode(",",$record->group_ids):[];
        $this->updateMode = true;
        $this->groups = Group::all();
        $this->emit('circularDataFetched', $record);
    }

    public function destroycircular($id)
    { 
        if ($id) {
            $record = Circular::find($id);
            $title = $record->title;

            $record->delete();
            $this->dispatchBrowserEvent('circular-deleted', ['title' => $title]); // add this
        }
    }

    public function approveCircle($id)
    {
        if ($id) 
        {
            $user = Auth::user();

            $record = Circular::find($id);
            $record->need_approval = 0;
            $record->approved_by = $user->id;
            $record->approved_at = date('Y-m-d H:i:s');
            $record->save();
        }
    }

    public function publishCircle($id)
    {
        if ($id) 
        {
            $user = Auth::user();

            $record = Circular::find($id);
            $record->published = 1;
            $record->published_by = $user->id;
            $record->published_at = date('Y-m-d H:i:s');
            $record->save();
            
        }
    }

    public function UnpublishCircle($id)
    {
        if ($id) 
        {
            $user = Auth::user();

            $record = Circular::find($id);
            $record->published = 0;
            $record->published_by = $user->id;
            $record->published_at = date('Y-m-d H:i:s');
            $record->save();
            
        }
    }
}
