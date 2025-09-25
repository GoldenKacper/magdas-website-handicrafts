<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;

class GalleryController extends Controller
{
    /**
     * Show the application Gallery Page.
     */
    public function index()
    {
        // Download all categories with names (fallback) + products with translations and photos
        $categories = Category::query()
            ->with([
                'translationWithFallback',
                'products' => function ($q) {
                    // Product has $with, but we explicitly add it
                    // to be sure about the relationship:
                    $q->forFrontend(); // = translationWithFallback.availability, category.translationWithFallback, imagesForFrontend.translationWithFallback
                },
            ])
            ->get();

        $MIN = 8;

        $categories = $categories->map(function ($cat) use ($MIN) {
            $products = $cat->products->values();

            // if we have less than $MIN, we duplicate the existing ones (round-robin)
            $count = $products->count();
            if ($count > 0 && $count < $MIN) {
                // simple padding: we add references to the same models
                // (for the view this is OK; we don't save anything)
                for ($i = 0; $products->count() < $MIN; $i++) {
                    // NOTE: we don't use replicate(), because you will lose loaded relationships (photos/translations).
                    $clone = clone  $products[$i % $count]; // clone keeps relationships and appends
                    // optionally: assign a "virtual" identifier only for attributes in the view
                    $clone->setAttribute('virtual_uid', $clone->id . '-dup-' . $products->count());
                    $products->push($clone);
                }
            }

            // overwrite the already filtered/completed products relation
            $cat->setRelation('products', $products);

            return $cat;
        });

        $page = 'gallery';
        // render gallery view
        return view('pages.gallery', compact('page', 'categories'));
    }

    /**
     * Show details for a specific gallery item (render view).
     *
     * @param string $locale
     * @param string $slug
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(string $locale, string $slug, Request $request)
    {
        Validator::make(
            ['slug' => $slug],
            ['slug' => 'required|string|exists:products,slug']
        )->validate();

        $product = Product::query()
            ->where('slug', $slug)
            ->forFrontend() // = translationWithFallback.availability, category.translationWithFallback, images.translationWithFallback
            ->firstOrFail();

        // Render the modal as HTML
        $html = view('modals.gallery_product_modal', compact('product'))->render();

        // Return the raw HTML (axios will receive it as text)
        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
