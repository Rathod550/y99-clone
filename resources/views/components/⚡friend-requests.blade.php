<?php

use Livewire\Component;
use App\Models\FriendRequest;

class FriendRequests extends Component
{
    public $requests = [];

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $this->requests = FriendRequest::with('sender')
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function accept($id)
    {
        $req = FriendRequest::findOrFail($id);
        $req->update(['status' => 'accepted']);

        $this->loadRequests();
    }

    public function reject($id)
    {
        $req = FriendRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        $this->loadRequests();
    }

    public function render()
    {
        return view('livewire.friend-requests');
    }
}