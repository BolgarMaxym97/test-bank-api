<?php

namespace App\Http\Controllers;

use App\Http\Requests\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CardsController extends Controller
{
    public function getByUser(User $user): JsonResponse
    {
        return response()->json([
            'cards' => $user->cards()->orderBy('created_at')->get()
        ]);
    }

    public function create(Card $request): Model
    {
        return \App\Models\Card::create($request->validated())->fresh();
    }

    public function update(Card $request, \App\Models\Card $card): bool
    {
        return $card->update($request->validated());
    }

    public function delete(\App\Models\Card $card): JsonResponse
    {
        try {
            return response()->json(['success' => $card->delete()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
    }
}
