<div wire:ignore class="modal fade" id="editcircularModal" tabindex="-1" aria-labelledby="editcircularModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog model-md">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editcircularModalLabel">Update Circular Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                <div class="form-group" wire:ignore> 
                    <label for="title">Title</label> 
                    <input wire:ignore type="text" class="form-control" id="title" placeholder="Enter title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    <label for="title">Details</label> 
                    <input id="details" type="hidden" wire:model='details'/>
                    @error('details') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group" wire:ignore>
                    <label for="group_ids">Selct Groups</label> 
                    <select wire:ignore.self class="form-control" id="group_ids" wire:model="group_ids" multiple>
                        @if($this->groups)
                          @foreach ($this->groups as $group)
                            <option value="{{ $group->id }}" @if(in_array($group->id,$group_ids)) selected @endif>{{ $group->title }}</option>
                          @endforeach
                        @endif
                    </select>
                    @error('group_ids') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    
                    <label for="need_confirmation">
                        <input type="checkbox" {{ $this->need_confirmation?'checked':'' }} id="need_confirmation" wire:model="need_confirmation" checked/>
                        Need Acknowledgement?
                    </label> 
                    @error('need_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Updated</button> 
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

            $('#details').summernote('code', "<?=$this->details?>");


            $('#group_ids').select2();
            $('#group_ids').on('change', function (e) {
                var data = $('#group_ids').select2("val");
                @this.set('group_ids', data);
            });
        });
    </script>
</div>