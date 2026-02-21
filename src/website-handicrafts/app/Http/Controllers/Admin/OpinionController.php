<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Opinion;
use App\Models\OpinionTranslation;


class OpinionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application review management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $opinions = Opinion::with('translations')->get();
        $page = 'opinion';
        return view('admin.pages.opinion', compact('opinions', 'page'));
    }

    /**
     * Store a newly created opinion with its translation.
     *
     * - Validates input data including image type and size
     * - Stores image in storage/app/public/images/opinions
     * - Generates slug based on image filename (without extension)
     * - Saves opinion and translation inside a database transaction
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Validate request data
        // Image size is validated in kilobytes (4096 KB = 4 MB)
        try {
            $validatedData = $request->validate([
                'first_name'   => 'required|string|min:2|max:255',
                'country_code' => 'nullable|string|size:2',
                'locale'       => 'required|string|in:pl,en',
                'content'      => 'required|string|max:4096',
                'rating'       => 'nullable|integer|min:1|max:5',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
                'label_meta'   => 'nullable|string|max:255',
                'image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }


        // Generate base filename (also used as slug)
        // Format: opinion_DD_MM_YYYY_<unique>
        $dateStr  = date('d_m_Y');
        $unique   = substr(uniqid(), -6);
        $baseName = "opinion_{$dateStr}_{$unique}";


        // Image storage configuration
        $directory    = 'images/opinions';
        $storedPath   = null;
        $finalName    = $baseName;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');

                // Always store as webp if possible, otherwise fallback to original extension
                $extension   = $file->getClientOriginalExtension() ?: $file->extension();
                $filename    = $baseName . '.' . $extension;
                $storedPath  = $file->storeAs($directory, $filename, 'public');
                $finalName   = pathinfo($filename, PATHINFO_FILENAME);
            } catch (\Throwable $e) {
                Log::error('Image upload failed: ' . $e->getMessage());

                return redirect()
                    ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                    ->with('error', 'Image upload failed: ' . $e->getMessage());
            }
        }

        // Store opinion and translation inside a transaction
        try {
            DB::beginTransaction();

            $opinion = Opinion::create([
                'image' => $storedPath, // e.g. images/opinions/opinion_01_09_2025_xxxxxx.webp
                'slug'  => $finalName,
            ]);

            $opinion->translations()->create([
                'first_name'   => $validatedData['first_name'],
                'country_code' => isset($validatedData['country_code'])
                    ? strtolower($validatedData['country_code'])
                    : null,
                'content'      => $validatedData['content'],
                'image_alt'    => $validatedData['image_alt'] ?? null,
                'label_meta'   => $validatedData['label_meta'] ?? null,
                'order'        => $validatedData['order'],
                'rating'       => $validatedData['rating'] ?? null,
                'visible'      => $request->boolean('visible'),
                'locale'       => $validatedData['locale'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.opinions_add_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error saving opinion: ' . $e->getMessage());

            // Remove uploaded file if DB transaction fails
            if ($storedPath) {
                Storage::disk('public')->delete($storedPath);
            }

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error', 'Failed to save opinion: ' . $e->getMessage());
        }
    }

    /**
     * Store a additional translation for a existed opinion.
     *
     * - Validates input data
     * - Checks if translation for the given locale already exists
     * - Saves translation inside a database transaction
     *
     * @param \Illuminate\Http\Request $request
     * @param string $locale
     * @param Opinion $opinion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTranslation(Request $request, string $locale, Opinion $opinion)
    {
        // Validate input
        try {
            $validatedData = $request->validate([
                'first_name'   => 'required|string|min:2|max:255',
                'country_code' => 'nullable|string|size:2',
                'locale'       => 'required|string|in:pl,en',
                'content'      => 'required|string|max:4096',
                'rating'       => 'nullable|integer|min:1|max:5',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
                'label_meta'   => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }

        if ($opinion->translations()->where('locale', $validatedData['locale'])->exists()) {
            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error', __('admin/messages.translation_exists'));
        }

        try {
            DB::beginTransaction();

            $opinion->translations()->create([
                'first_name'   => $validatedData['first_name'],
                'country_code' => isset($validatedData['country_code'])
                    ? strtolower($validatedData['country_code'])
                    : null,
                'content'      => $validatedData['content'],
                'image_alt'    => $validatedData['image_alt'] ?? null,
                'label_meta'   => $validatedData['label_meta'] ?? null,
                'order'        => $validatedData['order'],
                'rating'       => $validatedData['rating'] ?? null,
                'visible'      => $request->boolean('visible'),
                'locale'       => $validatedData['locale'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.opinions_add_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error adding opinion translation: ' . $e->getMessage());

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error', 'Failed to add translation: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a translation.
     *
     * - Check if the translation belongs to the opinion.
     * - Set the translation relation on the opinion model.
     * - Load existing translations for the opinion.
     * - Return the view for editing the translation.
     *
     * @param Request $request
     * @param string $locale
     * @param Opinion $opinion
     * @param OpinionTranslation $translation
     * @return \Illuminate\Contracts\View\View
     */
    public function editTranslation(Request $request, string $locale, Opinion $opinion, OpinionTranslation $translation)
    {
        // Ensure translation belongs to opinion (clean and laravel-ish)
        $translation = $opinion->translations()->whereKey($translation->id)->firstOrFail();
        $opinion->setRelation('translation', $translation);
        $existingTranslations = $opinion->translations->pluck('locale')->toArray();

        return view('admin.modals.edit_opinion_modal', compact('opinion', 'existingTranslations'));
    }

    /**
     * Update the specified translation in storage.
     *
     * - Check if the translation belongs to the opinion.
     * - Validate the request data.
     * - Save new image if provided and delete old ones and update opinion inside the transaction.
     * - Update the translation fields inside the transaction.
     *
     * @param Request $request
     * @param string $locale
     * @param Opinion $opinion
     * @param OpinionTranslation $translation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTranslation(Request $request, string $locale, Opinion $opinion, OpinionTranslation $translation)
    {
        // Ensure translation belongs to opinion (clean and laravel-ish)
        $translation = $opinion->translations()->whereKey($translation->id)->firstOrFail();
        $opinion->setRelation('translation', $translation);

        // Validate input
        try {
            $validatedData = $request->validate([
                'first_name'   => 'required|string|min:2|max:255',
                'country_code' => 'nullable|string|size:2',
                'content'      => 'required|string|max:4096',
                'rating'       => 'nullable|integer|min:1|max:5',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
                'label_meta'   => 'nullable|string|max:255',
                'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }

        // generate base name: opinion_DD_MM_YYYY_<uniq>
        $dateStr = date('d_m_Y');
        $unique = substr(uniqid(), -6);
        $baseName = "opinion_{$dateStr}_{$unique}";

        // prepare file vars
        $directory = 'images/opinions';
        $newStoredPath = null;
        $newFilenameBase = null;

        // handle image upload (if provided)
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');

                // try convert to webp if possible (fallback to original ext)
                $extension = $file->getClientOriginalExtension() ?: $file->extension();
                $targetName = $baseName . '.' . $extension;
                $tmpStored = $file->storeAs($directory, $targetName, 'public');
                $newStoredPath = $tmpStored;
                $newFilenameBase = pathinfo($targetName, PATHINFO_FILENAME);
            } catch (\Throwable $e) {
                Log::error("Image processing failed: " . $e->getMessage());

                return redirect()->back()->with('error', 'Image upload failed: ' . $e->getMessage());
            }
        }

        // save changes inside transaction
        try {
            DB::beginTransaction();

            // if new image uploaded -> delete old image and update Opinion.image & slug
            if ($newStoredPath) {
                // remove old image file (if any)
                if ($opinion->image) {
                    Storage::disk('public')->delete($opinion->image);
                }

                $opinion->image = $newStoredPath;
                $opinion->slug = $newFilenameBase; // slug = filename without ext
                $opinion->save();
            }

            // update translation fields
            $translation->update([
                'first_name'   => $validatedData['first_name'],
                'country_code' => isset($validatedData['country_code'])
                    ? strtolower($validatedData['country_code'])
                    : null,
                'content'      => $validatedData['content'],
                'image_alt'    => $validatedData['image_alt'] ?? null,
                'label_meta'   => $validatedData['label_meta'] ?? null,
                'order'        => $validatedData['order'],
                'rating'       => $validatedData['rating'] ?? null,
                'visible'      => $request->boolean('visible'),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.opinions_update_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            // remove newly stored file if transaction failed
            if (!empty($newStoredPath)) {
                Storage::disk('public')->delete($newStoredPath);
            }

            Log::error('Error updating opinion translation: ' . $e->getMessage());

            return redirect()
                ->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error',  'Failed to update opinion: ' . $e->getMessage());
        }
    }

    /**
     * Handle the deletion of an opinion translation.
     *
     * - Validates the request
     * - Checks if translation belongs to the opinion
     * - Deletes the translation and the opinion if no translations remain
     *
     * @param Request $request
     * @param string $locale
     * @param Opinion $opinion
     * @param OpinionTranslation $translation
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyTranslation(Request $request, string $locale, Opinion $opinion, OpinionTranslation $translation)
    {
        // Validate that translation belongs to opinion
        if ($translation->opinion_id !== $opinion->id) {
            // If AJAX -> JSON error, otherwise redirect with error
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Translation does not belong to this opinion.'], 400);
            }
            return redirect()->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error', __('admin/messages.error_relation_mismatch') ?? 'Bad request.');
        }

        try {
            DB::beginTransaction();

            // Delete the translation
            $translation->delete();

            // Check remaining translations count
            $remaining = $opinion->translations()->count();

            $deletedOpinion = false;

            if ($remaining === 0) {
                // delete image file if exists
                if ($opinion->image) {
                    try {
                        Storage::disk('public')->delete($opinion->image);
                    } catch (\Throwable $e) {
                        // log but don't fail entire transaction for file-delete errors
                        Log::warning('Failed to delete opinion image: ' . $e->getMessage());
                    }
                }

                // delete the opinion record
                $opinion->delete();
                $deletedOpinion = true;
            }

            DB::commit();

            session()->flash('success', __('admin/messages.delete_success') ?? 'Deleted successfully');

            // If request expects JSON (axios), return JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'deleted_opinion' => $deletedOpinion,
                    'message' => __('admin/messages.delete_success') ?? 'Deleted successfully',
                ]);
            }

            // fallback redirect
            return redirect()->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.delete_success') ?? 'Deleted successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            // log error
            Log::error('Error deleting opinion translation: ' . $e->getMessage());

            session()->flash('error', __('admin/messages.delete_failed'));

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('admin/messages.delete_failed') ?? 'Failed to delete',
                ], 500);
            }

            return redirect()->route('admin.opinion.index', ['locale' => app()->getLocale()])
                ->with('error', __('admin/messages.delete_failed') ?? 'Failed to delete');
        }
    }
}
