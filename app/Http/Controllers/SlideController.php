<?php

namespace App\Http\Controllers;

use App\Models\Web;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->appkey) {
            return abort(403, 'Acceso denegado');
        }

        $web = Web::firstWhere('app_key', $request->appkey);

        if (!$web) {
            return abort(404, 'Slides encontrados');
        }

        $slides = $web
            ->slides()
            ->orderBy('position')
            ->available()
            ->get()
            ->map(fn($slide) => [
                'id' => $slide->id,
                'src' => config('app.storage') . $slide->src,
                'alt' => $slide->alt,
                'link' => $slide->url
            ]);

        return response()->json($slides);

    }
}
