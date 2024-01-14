<div class="card offset-3 col-6">
    <div class="card-header">
        Login
    </div>
    <div class="card-body">
        <form wire:submit="loginUser">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input wire:model="email" type="email" class="form-control" id="email">
                <div>
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input wire:model="password" type="password" class="form-control" id="password">
                <div>
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <div class="mb-3">
            <button class="btn btn-success" wire:navigate href="/register">Register</button>
        </div>
    </div>
</div>