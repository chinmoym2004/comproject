<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use Livewire\WithPagination;

class TopicComments extends Component
{
    public $topic;
    public $comments;

    public $reference;
    public $reference_id;
    public $parent_id;
    public $has_file;
    public $comment_text;

    protected $listeners = ['triggerRefresh' => '$refresh'];


    private function resetInput()
    {
        $this->comment_text = null;
    }

    public function mount($topic)
    {
        $this->topic = $topic;
        $this->comments = $topic->comments;
    }

    public function render()
    {
        $this->reference = encrypt(get_class($this->topic));
        $this->reference_id = encrypt($this->topic->id);
        $this->parent_id=0;

        return view('livewire.topic-comments');
    }

    public function submit()
    {
        //dd($this);
        
        $user = Auth::user();

        $reference = decrypt($this->reference);
        $reference_id = decrypt($this->reference_id);
        $obj = $reference::find($reference_id);

        if($obj)
        {
            $comment = $obj->comments()->create([
                'comment_text'=>$this->comment_text,
                'user_id'=>$user->id,
                'parent_id'=>$this->parent_id ?? null,
            ]);

            // if($request->hasFile('file'))
            // {
            //     $files = $request->file('file');
            //     foreach($files as $file)
            //     {
            //         $filename = $file->getClientOriginalName();
            //         $extension = $file->getClientOriginalExtension();
            //         $unique_id = uniqid();
                    
            //         $uploadfile = new Upload;
            //         $filedata = $uploadfile->saveFile($file,$reference);
            //         $filedata['uploaded_by']=$me->id;
            //         $filedata['is_thumbnail']=0;
            //         $filedata['is_default']=0;
            //         $filedata['note']='A file was uploaded for '. $reference .' form IP : '.$request->ip();
            //         $comment->upload()->create($filedata);

            //         $msg = $filedata['file_type'].' type file was uploaded for '.$reference.' by <b>'.$me->name.'</b>';

            //         parent::logMe(['type' => 'Comment','type_id'=>$comment->id,'note' => 'comment_file', 'action_details' => $msg,'user_id'=>$me->id],$me);
            //     }

            //     $comment->has_file=1;
            //     $comment->save();
            // }
            if($this->topic->forum)
            {
                if(isset($this->topic->forum->post_count))
                    $this->topic->forum->post_count+=1;
                else
                    $this->topic->forum->post_count=1;
                $this->topic->forum->save();
            }            

            $this->dispatchBrowserEvent('comment-saved', ['action' => 'created']);
            $this->emit('triggerRefresh');
            $this->resetInput();

        }
    }
}
