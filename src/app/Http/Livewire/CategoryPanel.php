<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Auth;
class CategoryPanel extends Component
{
    use WithPagination;

    public $sortField = 'name'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['triggerRefresh' => '$refresh','triggerCategoryEdit','destroyCategory'];
    public $updateMode = false;
    public $name,$details,$selected_id;

    protected $rules = [
        'name'=>'required',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function cancel()
    {
        $this->sortField='name';
        $this->updateMode=false;
        $this->name = null;
        $this->details = null;
        $this->selected_id = null;
    }

    public function render()
    {
        $categories = Category::search(trim($this->search))
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate(20);

        return view('livewire.category-panel',compact('categories'));
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        try
        {
            Category::create([
                'name' => $this->name,
                'details' => $this->details,
                'created_by' => $user->id
            ]);
            
            $this->dispatchBrowserEvent('category-saved', ['action' => 'created', 'title' => $this->name]);
            $this->emit('triggerRefresh');

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    public function triggerCategoryEdit($id)
    {
        $record = Category::find($id);

        $this->selected_id = $record->id;

        $this->name = $record->name;
        $this->details = $record->details;
        
        $this->updateMode = true;
        $this->emit('catDataFetched', $record);
    }

    public function update(){
        $this->validate();

        $user = Auth::user();

        try
        {
            $record = Category::find($this->selected_id);

            $record->name = $this->name;
            $record->details = $this->details;
            $record->save();
            
            $this->updateMode = false;
            
            $this->dispatchBrowserEvent('category-updated', ['action' => 'created', 'title' => $this->name]);
            $this->emit('triggerRefresh');

            $this->cancel();

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    public function destroyCategory($id)
    {
        if ($id) {
            $record = Category::find($id);
            $name = $record->name;
            $record->delete();

            $this->emit('triggerRefresh');
            $this->cancel();

            $this->dispatchBrowserEvent('category-deleted', ['title' => $name]); // add this
        }
    }
    
}
