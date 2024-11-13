<div class="inline-block">
    <div>
        <x-danger-button wire:click="$toggle('confirmingEventDeletion')" wire:loading.attr="disabled">
            {{ __('Delete Event') }}
        </x-danger-button>
    </div>


    <x-confirmation-modal wire:model.live="confirmingEventDeletion">
        <x-slot name="title">
            {{ __('Delete Event') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this event? Once a event is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingEventDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteEvent({{$event->id}})" wire:loading.attr="disabled">
                {{ __('Delete Event') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
