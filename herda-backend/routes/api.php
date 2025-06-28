<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DeveloperController;
use App\Models\Property;
use App\Models\Agent;
use App\Models\Page;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('agents', AgentController::class);
// Route::apiResource('properties', PropertyController::class);

Route::get('/mapbox/suggest', [\App\Http\Controllers\Api\MapboxController::class, 'suggest']);

Route::get('/properties', fn() => Property::with('agent')->get());
Route::get('/properties/{id}', fn($id) => Property::with('agent')->findOrFail($id));
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/similar', [PropertyController::class, 'similar']);

Route::get('/developers', [DeveloperController::class, 'index']);

Route::get('/agents', fn() => Agent::with('properties')->get());
Route::get('/agents/{id}', fn($id) => Agent::with('properties')->findOrFail($id));

Route::get('/pages/{slug}', fn($slug) => Page::where('slug', $slug)->firstOrFail());
