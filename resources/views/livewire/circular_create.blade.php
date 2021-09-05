<div wire:ignore class="modal fade" id="createcircularModal" tabindex="-1" aria-labelledby="createcircularModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog model-md">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createcircularModalLabel">New Circular</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group" wire:ignore> 
                    <label for="title">Title</label> 
                    <input wire:ignore type="text" class="form-control" id="title" placeholder="Enter title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    <label for="title">Details</label> 
                    <input id="details" type="hidden" wire:model='details'/>

                    {{-- <div input="details" id="details_editor"></div> --}}
                    @error('details') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                {{-- <div class="form-group" wire:ignore> 
                    <label for="to_all">Send it to all?</label> 
                    <select class="form-control" id="to_all" wire:model="to_all">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    @error('to_all') <span class="text-danger error">{{ $message }}</span>@enderror
                </div> --}}
                
                <div class="form-group" wire:ignore>
                    <label for="group_ids">Selct Groups</label> 
                    <select wire:ignore.self class="form-control" id="group_ids" wire:model="group_ids" multiple>
                        @if($this->groups)
                          @foreach ($this->groups as $group)
                            <option value="{{ $group->id }}">{{ $group->title }}</option>
                          @endforeach
                        @endif
                    </select>
                    @error('group_ids') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    
                    <label for="need_confirmation">
                        <input type="checkbox" id="need_confirmation" wire:model="need_confirmation" checked/>
                        Need Acknowledgement?
                    </label> 
                    @error('need_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
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
        
        $("#details").summernote({
            height: 200,
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('details', contents);
                }
            }
        });

        $(document).ready(function () {
            $('#group_ids').select2();
            $('#group_ids').on('change', function (e) {
                var data = $('#group_ids').select2("val");
                @this.set('group_ids', data);
            });
        });
    </script>
</div>