<div wire:poll.750ms>
    @forelse($messages as $message)
        {{ $message->content }}
    @empty
        No messages yet
    @endforelse
</div>

<form wire:submit.prevent="sendMessage">
    <input wire:model.defer="messageText">
    <button type="submit">send</button>
</form>