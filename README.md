# Laravel Insurance Quote API

A Laravel-based microservice for managing and retrieving insurance quote offers from a local database. This project follows the internship exercise described in the project brief: a backend service that receives a quote identifier and returns saved quote information, while also supporting full CRUD operations for quote management.

## Project purpose

The application simulates a quote service used inside a larger insurance platform for RCA/CASCO offers. A client can:

- create a new insurance quote,
- list all quotes,
- search quotes by client name, car plate, or insurer,
- retrieve a single quote by identifier,
- update an existing quote,
- delete a quote from the database.

This is a practical example of a backend API built with PHP and Laravel, using Eloquent ORM, validation, routing, and modern tooling for API documentation and frontend interaction.

## Tech stack

- PHP 8.3
- Laravel 13
- MySQL / SQLite-compatible database layer
- Eloquent ORM
- Vue 3 + Vite for the frontend UI
- Swagger/OpenAPI integration through l5-swagger
- PHPUnit for automated testing

## Core features

- REST API for quote management
- Search endpoint for filtering quote records
- Strong validation for client, plate, insurer, and price fields
- Quote records stored in a dedicated `quotes` table
- Swagger API documentation generated for the project
- Lightweight frontend views for quotations management

## API overview

Main endpoints:

- `GET /api/quote` — get all quotes
- `GET /api/quote/search?query=...` — search quotes by criteria
- `GET /api/quote/{identifier}` — fetch a quote by client name or car plate
- `POST /api/quote` — create a quote
- `PUT /api/quote/{identifier}` — update an existing quote
- `DELETE /api/quote/{id}` — delete a quote

Example request:

```bash
curl http://localhost:8000/api/quote/1
```

Example response:

```json
{
  "id": 1,
  "client_name": "Ion Popescu",
  "car_plate": "B123XYZ",
  "insurer_name": "AsiguratorX",
  "price": "545.50",
  "created_at": "...",
  "updated_at": "..."
}
```

## Project structure

```text
laravel-api-offers/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Swagger/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── js/
├── routes/
├── storage/
├── tests/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
├── README.md
└── vite.config.js
```


## Database model

The project uses a `quotes` table with the following structure:

- `id`
- `client_name`
- `car_plate`
- `insurer_name`
- `price`
- `created_at`
- `updated_at`

The data model is represented in the `Quote` Eloquent model and is populated through migrations and seeders.

## Validation and business logic

The backend validates input before saving or updating records, including:

- required fields,
- string formatting constraints,
- unique car plate values,
- positive numeric price values,
- proper insurer and client name formatting.

This helps keep the quote service realistic and reduces invalid data entering the system.


## Skills used for this project

This repository demonstrates:

- Laravel backend architecture and REST API design,
- Eloquent database modeling and migrations,
- validation rules and business logic,
- API documentation best practices,
- Vue frontend integration,
- practical development workflow for a real-world quote service.


