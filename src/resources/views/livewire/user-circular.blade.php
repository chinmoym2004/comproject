<div>
    <section class="content-header forum-content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-10">
                <p>Circular</p>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="col-sm-8">
        @foreach ($circulars as $circular)
            <div class="card">
                <div class="card-header view_circular" wire:click='viewCircular("{{ encrypt($circular->id) }}")'>
                    <h2 class="forum-title text-xl font-medium">
                        {{ $circular->title }}
                        @if($circular->need_confirmation && !$circular->myack())
                            <span class="badge badge-warning text-white float-right text-sm">Waiting for Acknowledgement</span>
                        @elseif($circular->need_confirmation && $circular->myack())
                            <span class="badge badge-success float-right text-sm">You Have Acknowledged</span>
                        @else
                            <span class="badge badge-info float-right text-sm">No Acknowledgement Required</span>
                        @endif
                    </h2>
                    <div class="forum-details mt-2 text-sm text-gray-500">
                        <?=$circular->created_at->diffForHumans();?>
                    </div>
                </div>
                @if($circular->need_approval)
                <div class="card-footer">
                    <p class="inline-block text-xs font-medium tracking-wider text-gray-500 uppercase">NEED APPROVAL</p>
                </div>
                @endif
            </div>
        @endforeach
    </div>
    @if($enableview)
        @include('livewire.circular_view')
    @endif
</div>
