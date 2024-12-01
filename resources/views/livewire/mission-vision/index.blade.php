<div>
    <form wire:submit.prevent="save">
        <h2>Mission/Vision</h2>

        <!-- Mission Section -->
        <div class="form-group">
            <label for="mission">Mission</label>
            <textarea id="mission" name="mission" class="form-control" wire:model="mission"></textarea>
        </div>

        <!-- Vision Section -->
        <div class="form-group">
            <label for="vision">Vision</label>
            <textarea id="vision" name="vision" class="form-control" wire:model="vision"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
