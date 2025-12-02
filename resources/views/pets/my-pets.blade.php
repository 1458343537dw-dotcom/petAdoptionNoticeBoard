@extends('layouts.app')

@section('title', 'My Pets - Pet Adoption Notice Board')

@section('content')
<div class="container">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-5 fw-bold">My Pets</h1>
            <p class="text-muted">Manage all pets you have posted</p>
        </div>
    </div>

    <!-- 宠物卡片网格 -->
    @if($pets->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach($pets as $pet)
                <div class="col">
                    <div class="card h-100 pet-card">
                        <!-- 宠物照片 -->
                        <img 
                            src="{{ asset('storage/' . $pet->photo) }}" 
                            class="card-img-top pet-image" 
                            alt="{{ $pet->title }}"
                            onerror="this.src='https://via.placeholder.com/300x250?text=暂无图片'"
                        >
                        
                        <!-- Visibility Status Badge -->
                        @if(!$pet->is_visible)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-secondary">Hidden</span>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <!-- Pet Title -->
                            <h5 class="card-title">{{ $pet->title }}</h5>
                            
                            <!-- Pet Info -->
                            <p class="card-text text-muted mb-2">
                                <small>
                                    <strong>Species:</strong> {{ $pet->species }} | 
                                    <strong>Age:</strong> {{ $pet->age }} months
                                </small>
                            </p>
                            
                            <!-- Description Summary -->
                            <p class="card-text">
                                {{ Str::limit($pet->description, 60) }}
                            </p>
                            
                            <!-- Posted Date -->
                            <p class="card-text">
                                <small class="text-muted">
                                    Posted: {{ $pet->created_at->format('Y-m-d') }}
                                </small>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('pets.show', $pet) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                                <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>
                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pet information?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 分页 -->
        <div class="row mt-4">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $pets->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info text-center" role="alert">
                    <h4 class="alert-heading">You haven't posted any pets yet</h4>
                    <p>Come and post your first pet for adoption!</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{ route('pets.create') }}" class="btn btn-primary">Post Pet for Adoption</a>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

