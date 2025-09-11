<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;

class GalleryController extends Controller
{
    /**
     * Show the application Gallery Page.
     */
    public function index()
    {
        $page = 'gallery';
        // render gallery view
        return view('pages.gallery', compact('page'));
    }

    /**
     * Show details for a specific gallery item (render view).
     *
     * @param int|string $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(int|string $id, Request $request)
    {
        // Demo assets
        $imgBracelet = Vite::asset('resources/images/magdas_website_offer_bracelet_31_08_2025_demo.png');
        $imgNecklace = Vite::asset('resources/images/magdas_website_offer_necklace_31_08_2025_demo.png');
        $imgEarrings = Vite::asset('resources/images/magdas_website_offer_earrings_31_08_2025_demo.png');

        // A simple "catalog" by modulo 3
        $catalog = [
            0 => [
                'category' => 'Bransoletki',
                'name'     => 'Bransoletka „Różowa perła”',
                'images'   => [$imgBracelet, $imgNecklace, $imgEarrings],
                'price'    => '79,00 zł',
                'stock'    => 'Dostępny',
                'desc'     => 'Delikatna, ręcznie robiona bransoletka w odcieniach malinowych. Idealna na prezent.',
            ],
            1 => [
                'category' => 'Naszyjniki',
                'name'     => 'Naszyjnik „Subtelny urok”',
                'images'   => [$imgNecklace, $imgBracelet, $imgEarrings],
                'price'    => '119,00 zł',
                'stock'    => 'Niedostępny',
                'desc'     => 'Minimalistyczny naszyjnik z subtelnym połyskiem. Pasuje do codziennych stylizacji.',
            ],
            2 => [
                'category' => 'Kolczyki',
                'name'     => 'Kolczyki „Kropla rosy”',
                'images'   => [$imgEarrings, $imgBracelet, $imgNecklace],
                'price'    => '69,00 zł',
                'stock'    => 'Czasowo niedostępny',
                'desc'     => 'Lekkie i wygodne, ręcznie wykonane kolczyki. Dodają dziewczęcego wdzięku.',
            ],
        ];

        $id = (int)$id;
        $key = $id % 3;
        $base = $catalog[$key];

        $product = [
            'id'       => $id,
            'name'     => $base['name'] . ' #' . $id,
            'category' => $base['category'],
            'description' => $base['desc'],
            'price'    => $base['price'],
            'stock'    => $base['stock'],
            'images'   => $base['images'], // first image is the main one
        ];

        // Render the modal as HTML
        $html = view('modals.gallery_product_modal', compact('product'))->render();

        // Return the raw HTML (axios will receive it as text)
        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
