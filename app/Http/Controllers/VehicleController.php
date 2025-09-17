<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
                'price' => $vehicle->getBestPrice(),
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
        $vehicle_format['banner'] = $vehicle->getBannerLink();
        $vehicle_format['banner_attributes'] = $vehicle->getBannerAttrLink();


        // settings
        $sections = ['Exterior', 'Interior', 'Rines'];

        $grouped = $vehicle->settings->groupBy('section');
        $vehicle_format['settings'] = collect($sections)->map(function (string $type) use ($grouped) {
            $items = ($grouped->get($type) ?? collect())->map(fn($s) => [
                'name' => $s->name,
                'icon' => $s->getBgIcon(),
                'preview' => $s->getFullSrc()
            ])->values();

            return [
                'type' => $type,
                'settings' => $items
            ];
        })->values();

        // atributos
        $vehicle_format['attributes'] = $vehicle
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
                'elements' => $el->elements
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
        $vehicle_format['gallery'] = $vehicle->pictures()->get()->map(fn($img) => [
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
