<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Quote::all());
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([]);
        }

        $results = Quote::where('car_plate', 'LIKE', "%{$query}%")
            ->orWhere('client_name', 'LIKE', "%{$query}%")
            ->orWhere('insurer_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($results);
    }

    public function showByIdentifier($identifier): JsonResponse
    {
        $quote = Quote::where('client_name', $identifier)
            ->orWhere('car_plate', $identifier)
            ->first();

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        return response()->json($quote);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Za-şA-ŞĂăÂâÎîȚț\s]+$/'],

            'car_plate'   => ['required', 'string', 'min:6', 'max:8', 'regex:/^[A-Z0-9]+$/i', 'unique:quotes,car_plate'],

            'asigurator'  => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Za-şA-ŞĂăÂâÎîȚț\s\-]+$/'],

            'price'       => ['required', 'numeric', 'gt:0'],
        ], [
            'client_name.regex' => 'The client name must contain letters only.',
            'car_plate.regex'   => 'The car plate must contain only letters and numbers.',
            'car_plate.unique'  => 'A quote for this car plate already exists.',
            'asigurator.regex'  => 'The insurer name must contain letters only.',
            'price.gt'          => 'The price must be greater than 0 RON.',
        ]);

        // Format car plate to uppercase automatically before saving
        $quote = Quote::create([
            'client_name'  => trim($validated['client_name']),
            'car_plate'    => strtoupper(trim($validated['car_plate'])),
            'insurer_name' => trim($validated['asigurator']),
            'price'        => $validated['price'],
        ]);

        return response()->json($quote, 201);
    }

    public function updateByIdentifier(Request $request, string $identifier): JsonResponse
    {
        $quote = Quote::where('client_name', $identifier)
            ->orWhere('car_plate', $identifier)
            ->first();

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $validated = $request->validate([
            'client_name' => 'sometimes|string',
            'car_plate'   => 'sometimes|string',
            'asigurator'  => 'sometimes|string',
            'price'       => 'sometimes|numeric',
        ]);

        $updateData = [];
        if (isset($validated['client_name'])) $updateData['client_name'] = $validated['client_name'];
        if (isset($validated['car_plate'])) $updateData['car_plate'] = $validated['car_plate'];
        if (isset($validated['asigurator'])) $updateData['insurer_name'] = $validated['asigurator'];
        if (isset($validated['price'])) $updateData['price'] = $validated['price'];

        $quote->update($updateData);

        return response()->json([
            'message' => 'Quote updated',
            'data'    => $quote
        ], 200);
    }

    public function delete(int $id): JsonResponse
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $quote->delete();

        return response()->json(['message' => 'Quote deleted'], 200);
    }
}
