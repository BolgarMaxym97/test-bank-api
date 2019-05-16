<?php

namespace App\Http\Controllers;

use App\Http\Requests\Operation;
use App\Models\Card;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class OperationsController extends Controller
{
    public function getByUser(User $user): JsonResponse
    {
        return response()->json([
            'operations' => $user->operations()->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function getByCard(Card $card): JsonResponse
    {
        return response()->json([
            'operations' => $card->operations()->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create(Operation $request): JsonResponse
    {
        $card = Card::find($request->card_id);
        if (!$card) {
            return response()->json(['message' => 'Card not found.'], 404);
        }
        if (\Hash::check($request->pin, $card->pin)) {
            $saved = $card->doOperation($request);
            (new \App\Models\Operation())->saveOperation($request, $saved);
            return response()->json([
                'success' => $saved
            ], 200);
        }
        return response()->json(['message' => 'Wrong pin code'], 400);
    }

    public function update(Operation $request, \App\Models\Operation $card): bool
    {
        return $card->update($request->validated());
    }

    public function delete(\App\Models\Operation $card): JsonResponse
    {
        try {
            return response()->json(['success' => $card->delete()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
    }
}
