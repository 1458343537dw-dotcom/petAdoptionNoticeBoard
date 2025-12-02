@extends('layouts.app')

@section('title', $pet->title . ' - Pet Adoption Notice Board')

@section('content')
<div class="container">
    <div class="row">
        <!-- Back Button -->
        <div class="col-md-12 mb-3">
            <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                ← Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Pet Photo -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img 
                    src="{{ asset('storage/' . $pet->photo) }}" 
                    class="card-img-top" 
                    alt="{{ $pet->title }}"
                    style="width: 100%; height: auto; max-height: 500px; object-fit: cover;"
                    onerror="this.src='https://via.placeholder.com/500x500?text=No+Image'"
                >
            </div>
        </div>

        <!-- Pet Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Title -->
                    <h2 class="card-title mb-3">{{ $pet->title }}</h2>

                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h5 class="text-primary">Basic Information</h5>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Species:</strong></div>
                            <div class="col-8">{{ $pet->species }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Age:</strong></div>
                            <div class="col-8">{{ $pet->age }} months</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Posted by:</strong></div>
                            <div class="col-8">{{ $pet->user->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Posted on:</strong></div>
                            <div class="col-8">{{ $pet->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="text-primary">Description</h5>
                        <hr>
                        <p class="text-justify" style="white-space: pre-line;">{{ $pet->description }}</p>
                    </div>

                    <!-- Action Buttons (Owner Only) -->
                    @auth
                        @if(Auth::id() === $pet->user_id)
                            <div class="d-grid gap-2">
                                <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning">
                                    Edit Pet Information
                                </a>
                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pet information?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        Delete Pet Information
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <!-- Contact Info Notice -->
                    @guest
                        <div class="alert alert-info mt-3" role="alert">
                            <strong>Notice:</strong> If you are interested in this pet, please
                            <a href="{{ route('login') }}" class="alert-link">login</a> or
                            <a href="{{ route('register') }}" class="alert-link">register</a> to contact the poster.
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

