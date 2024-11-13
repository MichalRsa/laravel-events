<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class DeleteEventForm extends Component
{
    use AuthorizesRequests;
    use RedirectsActions;

    public Event $event;

    public $confirmingEventDeletion = false;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function deleteEvent(Event $event): Redirector
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect('/events/');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.delete-event-form');
    }
}
