<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserSearch extends Component
{
    public $term;

    public function render()
    {
        if($this->term)
            $users = User::search($this->term)->take(50)->get();
        else 
            $users=null;

        return view('livewire.user-search',['users'=>$users]);
    }

    public function selectedMember($id,$text)
    {
        $this->emit('selectedFromSearch',['id'=>$id,'text'=>$text]);
        $this->term=null;
    }
}
