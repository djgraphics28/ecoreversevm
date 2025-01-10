<div>
    @section('title', 'Manage Email Recievers')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage Email Receiver') }}</h1>

        <button wire:click="openModal" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Email Reciever
        </button>
    </div>

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Search email...">
    </div>

    <!-- Faculty Table -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Email Receiver List') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th width="25%">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receivers as $receiver)
                            <tr wire:key="{{ $receiver->id }}">
                                <td>{{ $receiver->id }}</td>
                                <td>{{ $receiver->email }}</td>
                                <td>
                                    <button wire:click="openModal({{ $receiver->id }})" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button wire:click="delete({{ $receiver->id }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">{{ __('No Receivers found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $receivers->links() }}
            </div>
        </div>
    </div>

    @if ($modalOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $receiverId ? __('Edit Receiver') : __('Create Receiver') }}</h5>
                        <button type="button" class="close" wire:click="$set('modalOpen', false)">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" wire:model.defer="email"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('modalOpen', false)">
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveReceiver">
                            {{ $receiverId ? __('Update') : __('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
@endpush
