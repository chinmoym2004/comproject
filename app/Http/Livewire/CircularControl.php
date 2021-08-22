<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Circular;
use Auth;
class CircularControl extends Component
{
    use WithPagination;

    public $sortField = 'title'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['circular-delete', 'triggerRefresh' => '$refresh','triggercircularEdit','destroycircular'];

    public $title;
    public $details;
    public $selected_id;
    public $need_confirmation;

    public $updateMode = false;

    protected $rules = [
        'title'=>'required',
        'details'=>'required'
    ];

    private function resetInput()
    {
        $this->selected_id = null;
        $this->title = null;
        $this->details = null;
        $this->need_confirmation = 1;
        $this->updateMode = false;
    }


    public function render()
    {
        $circulars = Circular::search($this->search)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->simplePaginate(20);

        return view('livewire.circular-control',['circulars'=>$circulars]);
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        try
        {
            Circular::create([
                'title' => $this->title,
                'details' => $this->details,
                'need_confirmation' => $this->need_confirmation,
                'user_id' => $user->id
            ]);
            
            //session()->flash('success','Forum Created Successfully!!');
            $this->dispatchBrowserEvent('circular-saved', ['action' => 'created', 'title' => $this->name]);
            
            $this->emit('triggerRefresh');

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
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
                'user_id' => $user->id
            ]);
            //dd($record);
            //session()->flash('success','Category Updated Successfully!!');
            
            $this->dispatchBrowserEvent('circular-updated', ['action' => 'updated', 'title' => $this->title]);
            $this->resetInput();
            $this->emit('triggerRefresh');

            //dd($record);

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
        
        $this->updateMode = true;
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
}
