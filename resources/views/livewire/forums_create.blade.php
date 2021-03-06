<div wire:ignore class="modal fade" id="createForumModal" tabindex="-1" aria-labelledby="createForumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createForumModalLabel">New Forum</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group"> 
                  <label for="campus">Campus Name</label> 
                    <input wire:ignore type="text" class="form-control" id="campus" placeholder="Enter campus" wire:model="campus"> 
                    @error('campus') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group"> 
                  <label for="school">School Name</label> 
                  <input wire:ignore type="text" class="form-control" id="school" placeholder="Enter school" wire:model="school"> 
                  @error('school') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>
              <div class="form-group"> 
                  <label for="program">Program Name</label> 
                  <input wire:ignore type="text" class="form-control" id="program" placeholder="Enter program" wire:model="program"> 
                  @error('program') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>

              <div class="form-group"> 
                  <label for="name">Forum Name</label> 
                  <input wire:ignore type="text" class="form-control" id="name" placeholder="Enter Name" wire:model="name"> 
                  @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>

              <div class="form-group"> 
                  <label for="details">Details</label> 
                  <textarea wire:ignore class="form-control" id="details" placeholder="Enter details" wire:model="details"></textarea>
                  @error('details') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>

              <div class="form-group"> 
                  <label for="is_public">Is Public Forum?</label> 
                  <select wire:ignore class="form-control" id="is_public" wire:model="is_public">
                      <option value="">Select a category</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                  </select>
                  @error('is_public') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>
              
              @if($this->is_public==0)
              <div class="form-group"> 
                  <label for="group_id">Selct Groups</label> 
                  <select wire:ignore class="form-control" id="group_id" wire:model="group_id">
                      <option value="">Select a category</option>
                      @if($this->groups)
                        @foreach ($this->groups as $group)
                          <option value="{{ $group->id }}">{{ $group->title }}</option>
                        @endforeach
                      @endif
                  </select>
                  @error('group_id') <span class="text-danger error">{{ $message }}</span>@enderror
              </div>
              @endif


              <div class="form-group"> 
                <label for="category_id">Category</label> 
                <select wire:ignore class="form-control" id="category_id" wire:model="category_id">
                    <option value="">Select a category</option>
                    @if($this->categories)
                      @foreach ($this->categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                    @endif
                </select>
                @error('category_id') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button> 
            </div>
        </form> 
      </div>
    </div>
    <script>
      $(document).ready(function () {
          $("#details").summernote({
              height: 200,
              callbacks: {
                  onChange: function(contents, $editable) {
                      @this.set('details', contents);
                  }
              }
          });

          // $(document).on("change","#is_public",function(){
          //     @this.set('is_public', $(this).val());
          // });
      });
    </script>
  </div>
