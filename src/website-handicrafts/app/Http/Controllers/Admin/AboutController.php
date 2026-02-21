<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\AboutMe;
use App\Models\AboutMeTranslation;

class AboutController extends Controller
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
        $abouts = AboutMe::with('translations')->get();
        $page = 'about';
        $aboutsCount = $abouts->count();

        return view('admin.pages.about', compact('abouts', 'page', 'aboutsCount'));
    }

    /**
     * Store a newly created about me entry with its translation.
     *
     * - Validates input data including image type and size
     * - Stores image in storage/app/public/images/about
     * - Generates slug based on image filename (without extension)
     * - Saves about me entry and translation inside a database transaction
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
                'main_page'    => 'nullable|boolean',
                'locale'       => 'required|string|in:pl,en',
                'content'      => 'nullable|string|max:4096',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
                'image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }

        // Check if an about me entry already exists
        $abouts = AboutMe::all();
        if ($abouts->count() >= 1) {
            Log::error('Cannot add more than 1 about me entry.');

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', 'Cannot add more than 1 about me entry.');
        }

        // Generate base filename
        // Format: about_DD_MM_YYYY_<unique>
        $dateStr  = date('d_m_Y');
        $unique   = substr(uniqid(), -6);
        $baseName = "about_{$dateStr}_{$unique}";


        // Image storage configuration
        $directory    = 'images/about';
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
                    ->route('admin.about.index', ['locale' => app()->getLocale()])
                    ->with('error', 'Image upload failed: ' . $e->getMessage());
            }
        }

        // Store about me entry and translation inside a transaction
        try {
            DB::beginTransaction();

            $about = AboutMe::create([
                'about_author_image' => $storedPath, // e.g. images/about/about_01_09_2025_xxxxxx.webp
            ]);

            $about->translations()->create([
                'about_author_image_alt'     => $validatedData['image_alt'] ?? null,
                'content'                    => $validatedData['content'],
                'main_page'                  => $request->boolean('main_page'),
                'order'                      => $validatedData['order'],
                'visible'                    => $request->boolean('visible'),
                'locale'                     => $validatedData['locale'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.about_add_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error saving about me entry: ' . $e->getMessage());

            // Remove uploaded file if DB transaction fails
            if ($storedPath) {
                Storage::disk('public')->delete($storedPath);
            }

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', 'Failed to save about me entry: ' . $e->getMessage());
        }
    }

    /**
     * Store a additional translation for a existed about me entry.
     *
     * - Validates input data
     * - Checks if translation for the given locale already exists
     * - Saves translation inside a database transaction
     *
     * @param \Illuminate\Http\Request $request
     * @param string $locale
     * @param AboutMe $about
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTranslation(Request $request, string $locale, AboutMe $about)
    {
        // Validate incoming request data
        try {
            $validatedData = $request->validate([
                'main_page'    => 'nullable|boolean',
                'locale'       => 'required|string|in:pl,en',
                'content'      => 'nullable|string|max:4096',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }

        try {
            DB::beginTransaction();

            // If this new translation should be main page -> unset any other main_page for same locale (global)
            if ($request->boolean('main_page')) {
                // Using model to perform bulk update
                AboutMeTranslation::where('locale', $validatedData['locale'])
                    ->where('main_page', true)
                    ->update(['main_page' => false]);
            }

            $about->translations()->create([
                'about_author_image_alt'     => $validatedData['image_alt'] ?? null,
                'content'                    => $validatedData['content'],
                'main_page'                  => $request->boolean('main_page'),
                'order'                      => $validatedData['order'],
                'visible'                    => $request->boolean('visible'),
                'locale'                     => $validatedData['locale'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.about_add_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error saving about me entry: ' . $e->getMessage());

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', 'Failed to save about me entry translation: ' . $e->getMessage());
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
     * @param AboutMe $about
     * @param AboutMeTranslation $translation
     * @return \Illuminate\Contracts\View\View
     */
    public function editTranslation(Request $request, string $locale, AboutMe $about, AboutMeTranslation $translation)
    {
        // Ensure translation belongs to about me entry (clean and laravel-ish)
        $translation = $about->translations()->whereKey($translation->id)->firstOrFail();
        $about->setRelation('translation', $translation);

        return view('admin.modals.edit_about_modal', compact('about'));
    }

    /**
     * Update the specified translation in storage.
     *
     * - Check if the translation belongs to the about me entry.
     * - Validate the request data.
     * - Save new image if provided and delete old ones and update about me entry inside the transaction.
     * - Update the translation fields inside the transaction.
     *
     * @param Request $request
     * @param string $locale
     * @param AboutMe $about
     * @param AboutMeTranslation $translation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTranslation(Request $request, string $locale, AboutMe $about, AboutMeTranslation $translation)
    {
        try {
            $validatedData = $request->validate([
                'main_page'    => 'nullable|boolean',
                'content'      => 'nullable|string|max:4096',
                'order'        => 'required|integer|min:1|max:99',
                'visible'      => 'nullable|boolean',
                'image_alt'    => 'nullable|string|max:255',
                'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('admin/messages.validation_failed') . $e->getMessage() ?? 'Błąd walidacji danych');
        }

        // Generate base filename
        // Format: about_DD_MM_YYYY_<unique>
        $dateStr  = date('d_m_Y');
        $unique   = substr(uniqid(), -6);
        $baseName = "about_{$dateStr}_{$unique}";

        // Image storage configuration
        $directory    = 'images/about';
        $newStoredPath   = null;
        $newFilenameBase    = $baseName;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');

                // Always store as webp if possible, otherwise fallback to original extension
                $extension   = $file->getClientOriginalExtension() ?: $file->extension();
                $targetName    = $baseName . '.' . $extension;
                $tmpStored  = $file->storeAs($directory, $targetName, 'public');
                $newStoredPath = $tmpStored;
                $newFilenameBase   = pathinfo($targetName, PATHINFO_FILENAME);
            } catch (\Throwable $e) {
                Log::error('Image upload failed: ' . $e->getMessage());

                return redirect()
                    ->route('admin.about.index', ['locale' => app()->getLocale()])
                    ->with('error', 'Image upload failed: ' . $e->getMessage());
            }
        }

        try {
            DB::beginTransaction();

            // if new image uploaded -> delete old image and update Opinion.image & slug
            if ($newStoredPath) {
                // remove old image file (if any)
                if ($about->about_author_image) {
                    Storage::disk('public')->delete($about->about_author_image);
                }

                $about->about_author_image = $newStoredPath;
                $about->save();
            }

            // If this new translation should be main page -> unset any other main_page for same locale (global)
            if ($request->boolean('main_page')) {
                // Using model to perform bulk update
                AboutMeTranslation::where('locale', $translation->locale)
                    ->where('main_page', true)
                    ->update(['main_page' => false]);
            }

            $translation->update([
                'about_author_image_alt'     => $validatedData['image_alt'] ?? null,
                'content'                    => $validatedData['content'],
                'main_page'                  => $request->boolean('main_page'),
                'order'                      => $validatedData['order'],
                'visible'                    => $request->boolean('visible'),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.about_update_success'));
        } catch (\Throwable $e) {
            DB::rollBack();

            // Remove newly stored file if transaction failed
            if (!empty($newStoredPath)) {
                Storage::disk('public')->delete($newStoredPath);
            }

            Log::error('Error updating about me entry: ' . $e->getMessage());

            return redirect()
                ->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', 'Failed to update about me entry: ' . $e->getMessage());
        }
    }

    /**
     * Handle the deletion of an about translation.
     *
     * - Validates the request
     * - Checks if translation belongs to the about
     * - Deletes the translation and the about if no translations remain
     *
     * @param Request $request
     * @param string $locale
     * @param AboutMe $about
     * @param AboutMeTranslation $translation
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyTranslation(Request $request, string $locale, AboutMe $about, AboutMeTranslation $translation)
    {
        // Validate that translation belongs to about
        if ($translation->about_me_id !== $about->id) {
            // If AJAX -> JSON error, otherwise redirect with error
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Translation does not belong to this about.'], 400);
            }
            return redirect()->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', __('admin/messages.error_relation_mismatch') ?? 'Bad request.');
        }

        try {
            DB::beginTransaction();

            // Delete the translation
            $translation->delete();

            // Check remaining translations count
            $remaining = $about->translations()->count();

            $deletedAbout = false;

            if ($remaining === 0) {
                // delete image file if exists
                if ($about->about_author_image) {
                    try {
                        Storage::disk('public')->delete($about->about_author_image);
                    } catch (\Throwable $e) {
                        // log but don't fail entire transaction for file-delete errors
                        Log::warning('Failed to delete about image: ' . $e->getMessage());
                    }
                }

                // delete the about record
                $about->delete();
                $deletedAbout = true;
            }

            DB::commit();

            session()->flash('success', __('admin/messages.delete_success') ?? 'Deleted successfully');

            // If request expects JSON (axios), return JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'deleted_about' => $deletedAbout,
                    'message' => __('admin/messages.delete_success') ?? 'Deleted successfully',
                ]);
            }

            // fallback redirect
            return redirect()->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('success', __('admin/messages.delete_success') ?? 'Deleted successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            // log error
            Log::error('Error deleting about translation: ' . $e->getMessage());

            session()->flash('error', __('admin/messages.delete_failed'));

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('admin/messages.delete_failed') ?? 'Failed to delete',
                ], 500);
            }

            return redirect()->route('admin.about.index', ['locale' => app()->getLocale()])
                ->with('error', __('admin/messages.delete_failed') ?? 'Failed to delete');
        }
    }
}
