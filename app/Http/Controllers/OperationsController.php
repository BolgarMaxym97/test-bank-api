<?php

namespace App\Http\Controllers;

use App\Http\Requests\Operation;
use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class OperationsController extends Controller
{
    public function getByUser(User $user): JsonResponse
    {
        return response()->json([
            'operations' => $user->operations
        ]);
    }

    public function getByCard(Card $card): JsonResponse
    {
        return response()->json([
            'operations' => $card->operations
        ]);
    }

    public function create(Operation $request): Model
    {
        return \App\Models\Operation::create($request->validated());
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
