<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Quotes API",
    description: "API documentation for managing insurance quotes"
)]
#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local API Server"
)]
#[OA\Tag(
    name: "Quotes",
    description: "Endpoints for managing insurance quotes"
)]
class QuoteControllerDocs
{
    #[OA\Get(
        path: "/api/quote",
        summary: "Get all quotes",
        tags: ["Quotes"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of quotes retrieved successfully"
            )
        ]
    )]
    public function index() {}

    #[OA\Get(
        path: "/api/quote/search",
        summary: "Search quotes by query parameter",
        tags: ["Quotes"],
        parameters: [
            new OA\Parameter(
                name: "query",
                in: "query",
                required: true,
                description: "Search term (client name, plate, or insurer)",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Search results returned successfully"
            )
        ]
    )]
    public function search() {}

    #[OA\Get(
        path: "/api/quote/{identifier}",
        summary: "Get a single quote by client name or car plate",
        tags: ["Quotes"],
        parameters: [
            new OA\Parameter(
                name: "identifier",
                in: "path",
                required: true,
                description: "Client name or car plate number",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Quote found"),
            new OA\Response(response: 404, description: "Quote not found")
        ]
    )]
    public function showByIdentifier() {}

    #[OA\Post(
        path: "/api/quote",
        summary: "Create a new quote",
        tags: ["Quotes"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["client_name", "car_plate", "asigurator", "price"],
                properties: [
                    new OA\Property(property: "client_name", type: "string", example: "Ion Popescu"),
                    new OA\Property(property: "car_plate", type: "string", example: "CJ99ABC"),
                    new OA\Property(property: "asigurator", type: "string", example: "Groupama"),
                    new OA\Property(property: "price", type: "number", format: "float", example: 1250.50)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Quote created successfully"),
            new OA\Response(response: 422, description: "Validation Error")
        ]
    )]
    public function store() {}

    #[OA\Put(
        path: "/api/quote/{identifier}",
        summary: "Update a quote by identifier",
        tags: ["Quotes"],
        parameters: [
            new OA\Parameter(
                name: "identifier",
                in: "path",
                required: true,
                description: "Client name or car plate number",
                schema: new OA\Schema(type: "string")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "client_name", type: "string", example: "Ion Popescu"),
                    new OA\Property(property: "car_plate", type: "string", example: "CJ99ABC"),
                    new OA\Property(property: "asigurator", type: "string", example: "Allianz"),
                    new OA\Property(property: "price", type: "number", format: "float", example: 1300.00)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Quote updated successfully")
        ]
    )]
    public function updateByIdentifier() {}

    #[OA\Delete(
        path: "/api/quote/{id}",
        summary: "Delete a quote by ID",
        tags: ["Quotes"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "Database primary ID of the quote",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Quote deleted successfully")
        ]
    )]
    public function delete() {}
}
