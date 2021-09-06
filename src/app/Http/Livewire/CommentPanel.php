<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentPanel extends Component
{
    public $record;

    public $reference;
    public $reference_id;
    public $parent_id;
    public $has_file;
    public $comment_text;

    public $files;

    protected $listeners = ['triggerRefresh' => '$refresh'];

    public function mount($record)
    {
        $this->record = $record;
    }

    public function render()
    {
        $comments = $this->record->comments()->latest()->get();
        return view('livewire.comment-panel',['comments'=>$comments,'record'=>$this->record]);
    }
}
