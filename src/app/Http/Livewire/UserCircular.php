<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use App\Models\Circular;

class UserCircular extends Component
{
    use WithPagination;

    public $perPage = 20;

    public $title,$details,$accepted=false,$enableview=false,$need_confirmation=true;
    public $selected_id;

    public function render()
    {
        $user = Auth::user();

        $circulars1 = Circular::where('to_all',1)->where('published',1);
        $circulars2 = Circular::with('members')->where('user_id',$user->id)->where('published',1);
        
        $circulars = $circulars1->union($circulars2)->orderBy('created_at','DESC')->get();
        
        return view('livewire.user-circular',['circulars'=>$circulars]);
    }

    public function viewCircular($id)
    {
        $me = Auth::user();

        $circular = Circular::find(decrypt($id));

        $this->selected_id = $circular->id;
        $this->title = $circular->title;
        $this->details = $circular->details;
        $this->accepted = $circular->myack();
        $this->need_confirmation = $circular->need_confirmation;

        $this->enableview = true;
        $this->dispatchBrowserEvent('circularDataFetched'); // add this
    }

    public function acknowldge()
    {
        $me = Auth::user();

        $circular = Circular::find($this->selected_id);

        // check if user exist 
        if($circular->members()->where('user_id',$me->id)->count())
        {
            $tmp_accepted = $circular->members()->updateExistingPivot($me->id,['has_confirmed'=>1]);
        }
        else
        {
            $tmp_accepted = $circular->members()->syncWithPivotValues($me->id,['has_confirmed'=>1]);
        }
        
        $this->accepted = $tmp_accepted?true:false;
        $this->enableview = false;
        $this->emit('triggerRefresh');
    }

    public function cancel()
    {
        $this->enableview = false;

        $this->selected_id = false;
        $this->title = null;
        $this->details = null;
        $this->accepted = false;
        $this->need_confirmation = false;
    }
}
