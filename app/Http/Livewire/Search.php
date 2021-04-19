<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    public $searchTerm;
    public $users;

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->users = User::where('name', 'like', $searchTerm)->get();
        return view('livewire.search');
    }
}
