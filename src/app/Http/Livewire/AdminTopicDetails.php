<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminTopicDetails extends Component
{
    public $topic;

    

    protected $listeners = ['triggerRefresh' => '$refresh','refreshTopicPage'=>'$refresh'];

    public function mount($topic)
    {
        $this->topic = $topic;
    }

    public function render()
    {
        return view('livewire.admin-topic-details');
    }
}
