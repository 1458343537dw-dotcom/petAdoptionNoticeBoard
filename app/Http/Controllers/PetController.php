<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Pet Controller
 * Handles CRUD operations for pet information
 */
class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     * Show all visible pets list (public access)
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Build query
        $query = Pet::where('is_visible', true)->with('user');

        // Search keywords
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by species
        if ($species = $request->get('species')) {
            $query->where('species', $species);
        }

        // Filter by age range
        if ($ageRange = $request->get('age_range')) {
            switch ($ageRange) {
                case 'baby':
                    $query->where('age', '<=', 6);
                    break;
                case 'young':
                    $query->whereBetween('age', [7, 24]);
                    break;
                case 'adult':
                    $query->where('age', '>', 24);
                    break;
            }
        }

        // Get pets list
        $pets = $query->latest()->paginate(12)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Pet::where('is_visible', true)->count(),
            'species' => Pet::where('is_visible', true)
                ->select('species', DB::raw('count(*) as count'))
                ->groupBy('species')
                ->get(),
            'recent' => Pet::where('is_visible', true)
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
        ];

        // Get all species (for filter dropdown)
        $allSpecies = Pet::where('is_visible', true)
            ->distinct()
            ->pluck('species')
            ->sort();

        return view('pets.index', compact('pets', 'stats', 'allSpecies'));
    }

    /**
     * Show the form for creating a new resource.
     * Show form for creating pet information (requires authentication)
     * 
     * @return View
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     * Store newly created pet information (requires authentication)
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Use validation rules defined in model
        $validated = $request->validate(
            Pet::validationRules(),
            Pet::validationMessages()
        );

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('pets', 'public'); // Store to storage/app/public/pets
            $validated['photo'] = $photoPath;
        }

        // Add current user ID
        $validated['user_id'] = Auth::id();

        // Create pet information
        $pet = Pet::create($validated);

        return redirect()->route('pets.show', $pet)
            ->with('success', 'Pet information posted successfully!');
    }

    /**
     * Display the specified resource.
     * Show detailed information of specified pet (public access)
     * 
     * @param Pet $pet
     * @return View
     */
    public function show(Pet $pet): View
    {
        // If pet is not visible and current user is not the owner, return 404
        if (!$pet->is_visible && (!Auth::check() || Auth::id() !== $pet->user_id)) {
            abort(404);
        }

        // Load user relationship
        $pet->load('user');

        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     * Show form for editing pet information (requires authentication and ownership)
     * 
     * @param Pet $pet
     * @return View|RedirectResponse
     */
    public function edit(Pet $pet): View|RedirectResponse
    {
        // Authorization check: only the pet owner can edit
        if (Auth::id() !== $pet->user_id) {
            return redirect()->route('pets.index')
                ->with('error', 'You do not have permission to edit this pet information.');
        }

        return view('pets.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     * Update specified pet information (requires authentication and ownership)
     * 
     * @param Request $request
     * @param Pet $pet
     * @return RedirectResponse
     */
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        // Authorization check: only the pet owner can update
        if (Auth::id() !== $pet->user_id) {
            return redirect()->route('pets.index')
                ->with('error', 'You do not have permission to modify this pet information.');
        }

        // Use validation rules defined in model (photo is optional when updating)
        $validated = $request->validate(
            Pet::validationRules($pet->id),
            Pet::validationMessages()
        );

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                Storage::disk('public')->delete($pet->photo);
            }

            // Store new photo
            $photo = $request->file('photo');
            $photoPath = $photo->store('pets', 'public');
            $validated['photo'] = $photoPath;
        }

        // Update pet information
        $pet->update($validated);

        return redirect()->route('pets.show', $pet)
            ->with('success', 'Pet information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * Delete specified pet information (requires authentication and ownership)
     * 
     * @param Pet $pet
     * @return RedirectResponse
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        // Authorization check: only the pet owner can delete
        if (Auth::id() !== $pet->user_id) {
            return redirect()->route('pets.index')
                ->with('error', 'You do not have permission to delete this pet information.');
        }

        // Delete photo file
        if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
            Storage::disk('public')->delete($pet->photo);
        }

        // Delete pet information
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet information has been deleted.');
    }

    /**
     * Display the user's own pets.
     * Show all pets posted by current user
     * 
     * @return View
     */
    public function myPets(): View
    {
        $pets = Pet::where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('pets.my-pets', compact('pets'));
    }
}
