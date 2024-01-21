<div class="card offset-3 col-6">
    <div class="card-header">
        Create Group
    </div>
    <div class="card-body">
        <form wire:submit="createGroup">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input wire:model="name" type="text" class="form-control" id="name">
                <div>
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>