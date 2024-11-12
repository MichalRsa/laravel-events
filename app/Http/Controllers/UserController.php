<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function show(User $id): View
    {
        // Retrieve the event by ID
        $user = User::findOrFail($id->id);

        // Pass the event to the view
        return view('users.show', ['user' => $user ]);
    }
}
