<div wire:ignore.self class="modal fade" id="editForumModal" tabindex="-1" aria-labelledby="editForumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editForumModalLabel">Update Forum</h5>
            <button type="button" wire:click='cancel' class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
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
                  <textarea id="details" wire:model="details" class="form-control"></textarea>
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
                    <option value="">Select a Groups</option>
                    @if($this->groups)
                        @foreach ($this->groups as $group)
                        <option value="{{ $group->id }}" {{ $this->group_id==$group->id?'selcted':'' }}>{{ $group->title }}</option>
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
                        <option value="{{ $cat->id }}" {{ $this->category_id==$cat->id?'selcted':'' }}>{{ $cat->name }}</option>
                      @endforeach
                    @endif
                </select>
                @error('category_id') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button> 
            </div>
        </form> 
      </div>
    </div>

    <script>
      // $(document).ready(function () {
      //   //console.log("<?=$this->details?>");
      //   $("#details").summernote({
      //     height: 200,
      //     callbacks: {
      //         onChange: function(contents, $editable) {
      //             @this.set('details', contents);
      //         }
      //     }
      //   });
      //   $('#details').summernote('code', '<?=addslashes($this->details)?>');
      //   //$('#details').summernote('editor.pasteHTML', '<?=$this->details?>');
        
      // });
    </script>
</div>
