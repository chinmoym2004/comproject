<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Comment;
use App\Models\Topic;

class TopicComments extends Component
{
    use WithFileUploads;

    public $topic;    
    public $reference;
    public $reference_id;
    public $parent_id;
    public $has_file;
    public $comment_text;
    public $enablereply;
    public $totalcomment;

    public $files;

    protected $listeners = ['triggerRefresh' => '$refresh'];


    private function resetInput()
    {
        $this->comment_text = null;
    }

    public function mount($topic)
    {
        $this->topic = $topic;
        $this->reference_id = $topic->id;
        //dd(Comment::where('commentable_type','App\Models\Topic')->latest()->paginate(10));
    }

    public function render()
    {
        $this->reference = encrypt(get_class($this->topic));
        $this->reference_id = encrypt($this->topic->id);
        $this->parent_id=null;

        $this->totalcomment = $this->topic->comments()->count();

        //$comments = Comment::where('commentable_type','App\Models\Topic')->where('comm')->whereNull('parent_id')->latest()->paginate(20);
        $comments =  $this->topic->comments()->whereNull('parent_id')->latest()->paginate(20);

        return view('livewire.topic-comments',['comments'=>$comments]);
    }

    public function updatedPhoto()
    {
        $this->validate([
            'files' => 'file|max:2048',
        ]);
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
            
            //$this->comments = $this->topic->comments;

            $this->dispatchBrowserEvent('comment-saved', ['action' => 'created']);
            $this->emit('refreshTopicPage');
            $this->emit('triggerRefresh');
            $this->resetInput();

        }
    }

    public function actionEnablereply()
    {
        $this->enablereply = !$this->enablereply;
    }

    public function saveTopicComment($parent_id=null)
    {
        $this->validate([
            'comment_text'=>'required',
        ]);

        $user = Auth::user();

        $this->topic->comments()->create([
            'comment_text'=>$this->comment_text,
            'user_id'=>$user->id,
            'parent_id'=>$parent_id,
        ]);

        $this->totalcomment+=1;

        $this->comment_text = null;
        $this->dispatchBrowserEvent('subcommented'); // add this
        $this->emit('triggerRefresh');

        
    }
}
