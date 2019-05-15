<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class CardsController extends Controller
{
    public function getForUser(User $user): JsonResponse
    {
        return response()->json([
            'card' => $user->cards
        ]);
    }
}
