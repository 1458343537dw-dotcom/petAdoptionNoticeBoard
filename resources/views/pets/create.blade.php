@extends('layouts.app')

@section('title', 'Post Pet for Adoption - Pet Adoption Notice Board')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Post Pet for Adoption</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Pet Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Pet Title <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                required
                                maxlength="100"
                                placeholder="e.g., Cute Orange Cat Looking for a Home"
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please enter an attractive title (max 100 characters)</div>
                        </div>

                        <!-- Pet Species -->
                        <div class="mb-3">
                            <label for="species" class="form-label">Pet Species <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('species') is-invalid @enderror" 
                                id="species" 
                                name="species" 
                                value="{{ old('species') }}"
                                required
                                maxlength="50"
                                placeholder="e.g., Cat, Dog, Rabbit, etc."
                            >
                            @error('species')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pet Age -->
                        <div class="mb-3">
                            <label for="age" class="form-label">Pet Age (months) <span class="text-danger">*</span></label>
                            <input 
                                type="number" 
                                class="form-control @error('age') is-invalid @enderror" 
                                id="age" 
                                name="age" 
                                value="{{ old('age') }}"
                                required
                                min="0"
                                max="300"
                                placeholder="e.g., 6"
                            >
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please enter the pet's age in months</div>
                        </div>

                        <!-- Pet Photo -->
                        <div class="mb-3">
                            <label for="photo" class="form-label">Pet Photo <span class="text-danger">*</span></label>
                            <input 
                                type="file" 
                                class="form-control @error('photo') is-invalid @enderror" 
                                id="photo" 
                                name="photo" 
                                required
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                            >
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please upload a pet photo (jpg, png, gif formats supported, max 5MB)</div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="6"
                                required
                                placeholder="Please describe the pet's personality, health condition, vaccination status, etc..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">A detailed description helps find a more suitable owner (at least 10 characters)</div>
                        </div>

                        <!-- Visibility -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    id="is_visible" 
                                    name="is_visible"
                                    value="1"
                                    checked
                                >
                                <label class="form-check-label" for="is_visible">
                                    Publish immediately (uncheck to save as draft)
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Post Pet for Adoption
                            </button>
                            <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

