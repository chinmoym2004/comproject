<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Onetoonechatuser;
use Livewire\Component;
use Auth;
class Onetooneadmin extends Component
{
    use WithPagination;

    public $sortField = 'onetoonechatusers.created_at'; // default sorting field
    public $sortAsc = false; // default sort direction
    public $search = '';

    public $name;
    public $email;
    public $selected_id;

    public $member_ids=[];
    public $members;
    public $updateMode = false;
    public $addMemberModal = false;
    public $perpage = 20;

    protected $listeners = ['remove1to1Member','triggerRefresh' => '$refresh','triggergroupEdit','fetchGroupmembers','selectedFromSearch'];

    protected $rules = [
        'title'=>'required',
    ];

    private function resetInput()
    {
       
        $this->member_ids = [];
        $this->addMemberModal = false;        
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
        $onetoone = Onetoonechatuser::select('name','email','onetoonechatusers.created_at')->leftJoin('users','users.id','=','onetoonechatusers.user_id');
        if(!empty($this->search))
        {
            $query = $this->search;
            $onetoone = $onetoone->where(function($q) use ($query) {
                $q->orWhere('name', 'LIKE', $query . '%');
                $q->orWhere('email', 'LIKE', $query . '%');
            });
        }
        $onetoone = $onetoone->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perpage);
        return view('livewire.onetooneadmin',['onetoone'=>$onetoone]);
    }

    public function addUsertochat()
    {
        $this->addMemberModal=true;
    }

    public function updateMember()
    {
        if(count($this->member_ids))
        {
            $user = Auth::user();
            try
            {
                foreach($this->member_ids as $key=>$member)
                {
                    Onetoonechatuser::create(['user_id'=>$key]);
                }
                session()->flash('success','New users added for 1-1 chat');
                $this->emit('triggerRefresh');
                $this->resetInput();

            }catch(\Exception $e){
                session()->flash('error','Something goes wrong while creating group!!');
                $this->resetInput();
            }
        }
    }

    public function cancel()
    {
        $this->addMemberModal = false;
        $this->resetInput();
    }


    public function selectedFromSearch($data)
    {
        $this->member_ids[$data['id']]=$data['text'];
    }

    public function unselectMember($id)
    {
        unset($this->member_ids[$id]);
    }

    public function remove1to1Member($id)
    {
        $record = Onetoonechatuser::where('user_id',decrypt($id))->first();
        if($id)
        {
            $record->delete();
            session()->flash('success','User Removed from 1-1 chat');
            $this->emit('triggerRefresh');
        }

    }
}
