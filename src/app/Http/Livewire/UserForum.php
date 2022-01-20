<?php

namespace App\Http\Livewire;

use App\Models\Forum;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;

class UserForum extends Component
{
    use WithPagination;
    public $perPage = 20;

    // public function loadMore()
    // {
    //     $this->perPage = $this->perPage + 10;
    // }

    public function render()
    {
        $user = Auth::user();
        $group_ids = \DB::table('group_user')->where('user_id',$user->id)->pluck('group_id')->toArray();

        $forums = Forum::where(function($q) use ($group_ids){

            $q->whereIn('group_id',$group_ids);
            $q->orWhere('is_public',1);

        })->where('published',1)->paginate($this->perPage);

        return view('livewire.user-forum',['forums'=>$forums]);
    }
}
