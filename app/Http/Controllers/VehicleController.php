<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::select('id', 'category_id', 'name', 'price', 'slug', 'cover')
            ->get()
            ->map(fn(Vehicle $vehicle) => [
                'id' => $vehicle->id,
                'category_id' => $vehicle->category_id,
                'slug' => $vehicle->slug,
                'title' => $vehicle->name,
                'price' => $vehicle->getPriceFormat(),
                'cover' => $vehicle->getCoverLink()
            ]);

        return response()->json($vehicles);
    }

    public function show(string $slug)
    {
        $vehicle = Vehicle::firstWhere('slug', $slug);

        $vehicle_format = [];

        // Informacion basica
        $vehicle_format['id'] = $vehicle->id;
        $vehicle_format['name'] = $vehicle->name;
        $vehicle_format['year'] = $vehicle->year;
        $vehicle_format['price'] = $vehicle->getPriceFormat();
        $vehicle_format['banner'] = $vehicle->getCoverLink();

        $vehicle_format['customs'] = $vehicle->settings()->get()
            ->groupBy('section')
            ->map(fn ($el) => [
                'name' => $el->name,
                'text' => $el->text,
                'preview' => $el->getFullSrc*
            ])
            ->values();

        // atributos
        $vehicle_format['attributos'] = $vehicle
            ->attributes()
            ->select('id', 'title', 'description')
            ->orderBy('position')
            ->get()
            ->map(fn($attr) => [
                'id' => $attr->id,
                'title' => $attr->title,
                'text' => $attr->description
            ]);

        $vehicle_format['characteristics'] = $vehicle
            ->characteristics()
            ->with([
                'elements' => fn($q) => $q->orderBy('position'),
            ])
            ->orderBy('position')
            ->get()
            ->map(fn($el) => [
                'id' => $el->id,
                'title' => $el->title,
                'text' => $el->text,
                'elements' => $el->elements  // ya viene ordenado
                    ->map(fn($sub) => [
                        'id' => $sub->id,
                        'title' => $sub->title,
                        'text' => $sub->text,
                        'image' => $sub->getFullSrc(),
                    ])
                    ->values(),
            ])
            ->values();

        // Galeria
        $vehicle_format['gallery'] = $vehicle->pictures()->get()->map(fn($img, $vehicle) => [
            'id' => $img->id,
            'src' => $img->getFullSrc(),
            'alt' => $img->alt
        ]);

        if (!$vehicle) {
            return http_response_code(404);
        }

        return response()->json($vehicle_format);
    }
}
