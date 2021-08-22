<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Circular;
use Auth;
class CircularDetails extends Component
{
    public $circular;
    public $has_ack;
    public $ack;
    protected $listeners = ['triggerRefresh' => '$refresh'];



    public function mount($circular)
    {
        $me = Auth::user();
        $this->circular = $circular;
        $this->ack = $circular->members()->where('user_id','=',$me->id)->where('has_confirmed','=',1)->first();
        $this->has_ack = $this->ack?true:false;
    }

    public function render()
    {
        return view('livewire.circular-details');
    }

    public function acknowldge($id)
    {
        $me = Auth::user();

        $circular = Circular::find(decrypt($id));

        $this->ack = $circular->members()->attach($me->id,['has_confirmed'=>1]);
        $this->has_ack = $this->ack?true:false;

        $this->emit('triggerRefresh');

    }
}
