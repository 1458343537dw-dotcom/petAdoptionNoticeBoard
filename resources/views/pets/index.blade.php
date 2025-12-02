@extends('layouts.app')

@section('title', 'Pet List - Pet Adoption Notice Board')

@section('content')
<!-- Hero 横幅区域 -->
<div class="hero-banner text-white py-5 mb-4 position-relative" style="background-image: url('{{ asset('storage/back/pexels-pixabay-57416.jpg') }}');">
    <!-- 背景图片遮罩层 -->
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3"><img src="{{ asset('storage/icon/晒萌宠.png') }}" alt="Pet" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">Give Them a Warm Home</h1>
                <p class="lead mb-4">
                    There are <strong>{{ $stats['total'] }}</strong> adorable little lives waiting for adoption.
                    Every little life deserves love. Let's help them find a warm home together!
                </p>
                @guest
                    <div class="d-flex gap-2">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            Login to Post
                        </a>
                    </div>
                @else
                    <a href="{{ route('pets.create') }}" class="btn btn-light btn-lg">
                        Post Pet for Adoption
                    </a>
                @endguest
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <img src="{{ asset('storage/icon/柴犬.png') }}" alt="Dog" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                    <img src="{{ asset('storage/icon/布偶猫.png') }}" alt="Cat" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                    <img src="{{ asset('storage/icon/仓鼠.png') }}" alt="Hamster" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                    <img src="{{ asset('storage/icon/羊.png') }}" alt="Sheep" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                    <img src="{{ asset('storage/icon/更多萌宠.png') }}" alt="More Pets" class="hero-icon" style="width: 60px; height: 60px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- 统计数据卡片 -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <div class="display-4 text-primary mb-2">{{ $stats['total'] }}</div>
                    <h5 class="card-title">Pets for Adoption</h5>
                    <p class="card-text text-muted">Looking for a new home</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <div class="display-4 text-success mb-2">{{ $stats['recent'] }}</div>
                    <h5 class="card-title">New This Week</h5>
                    <p class="card-text text-muted">Posted in last 7 days</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <div class="display-4 text-info mb-2">{{ $stats['species']->count() }}</div>
                    <h5 class="card-title">Pet Species</h5>
                    <p class="card-text text-muted">Diverse options</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 搜索和筛选 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pets.index') }}" class="row g-3">
                <!-- 搜索关键词 -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Keywords</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="search" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search title or description..."
                    >
                </div>

                <!-- 宠物种类 -->
                <div class="col-md-3">
                    <label for="species" class="form-label">Pet Species</label>
                    <select class="form-select" id="species" name="species">
                        <option value="">All Species</option>
                        @foreach($allSpecies as $sp)
                            <option value="{{ $sp }}" {{ request('species') == $sp ? 'selected' : '' }}>
                                {{ $sp }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 年龄范围 -->
                <div class="col-md-3">
                    <label for="age_range" class="form-label">Age Range</label>
                    <select class="form-select" id="age_range" name="age_range">
                        <option value="">All Ages</option>
                        <option value="baby" {{ request('age_range') == 'baby' ? 'selected' : '' }}>
                            Baby (0-6 months)
                        </option>
                        <option value="young" {{ request('age_range') == 'young' ? 'selected' : '' }}>
                            Young (7-24 months)
                        </option>
                        <option value="adult" {{ request('age_range') == 'adult' ? 'selected' : '' }}>
                            Adult (24+ months)
                        </option>
                    </select>
                </div>

                <!-- 操作按钮 -->
                <div class="col-md-2 d-flex align-items-end">
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary">
                            Search
                        </button>
                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 结果标题 -->
    <div class="row mb-3">
        <div class="col-md-12">
            <h3>
                @if(request()->hasAny(['search', 'species', 'age_range']))
                    Search Results
                    <span class="badge bg-secondary">{{ $pets->total() }} pets</span>
                @else
                    All Pets for Adoption
                @endif
            </h3>
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
                            onerror="this.src='https://via.placeholder.com/300x250?text=No+Image'"
                        >
                        
                        <div class="card-body">
                            <!-- 宠物标题 -->
                            <h5 class="card-title">{{ $pet->title }}</h5>
                            
                            <!-- 宠物信息 -->
                            <p class="card-text text-muted mb-2">
                                <small>
                                    <strong>Species:</strong> {{ $pet->species }} | 
                                    <strong>Age:</strong> {{ $pet->age }} months
                                </small>
                            </p>
                            
                            <!-- 描述摘要 -->
                            <p class="card-text">
                                {{ Str::limit($pet->description, 60) }}
                            </p>
                            
                            <!-- 发布者信息 -->
                            <p class="card-text">
                                <small class="text-muted">
                                    Posted by: {{ $pet->user->name }}
                                </small>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('pets.show', $pet) }}" class="btn btn-primary btn-sm w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 分页 -->
        @if ($pets->hasPages())
            <div class="row mt-4">
                <div class="col-md-12">
                    <nav class="pet-pagination-wrapper">
                        <ul class="pet-pagination-list">
                            {{-- 上一页 --}}
                            @if ($pets->onFirstPage())
                                <li class="pet-page-item pet-page-disabled">
                                    <span class="pet-page-link">Previous</span>
                                </li>
                            @else
                                <li class="pet-page-item">
                                    <a class="pet-page-link" href="{{ $pets->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- 页码 --}}
                            @php
                                $currentPage = $pets->currentPage();
                                $lastPage = $pets->lastPage();
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($lastPage, $currentPage + 2);
                            @endphp

                            @if ($startPage > 1)
                                <li class="pet-page-item">
                                    <a class="pet-page-link" href="{{ $pets->url(1) }}">1</a>
                                </li>
                                @if ($startPage > 2)
                                    <li class="pet-page-item pet-page-disabled">
                                        <span class="pet-page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page == $currentPage)
                                    <li class="pet-page-item pet-page-active">
                                        <span class="pet-page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="pet-page-item">
                                        <a class="pet-page-link" href="{{ $pets->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <li class="pet-page-item pet-page-disabled">
                                        <span class="pet-page-link">...</span>
                                    </li>
                                @endif
                                <li class="pet-page-item">
                                    <a class="pet-page-link" href="{{ $pets->url($lastPage) }}">{{ $lastPage }}</a>
                                </li>
                            @endif

                            {{-- Next Page --}}
                            @if ($pets->hasMorePages())
                                <li class="pet-page-item">
                                    <a class="pet-page-link" href="{{ $pets->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="pet-page-item pet-page-disabled">
                                    <span class="pet-page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info text-center" role="alert">
                    <h4 class="alert-heading">No pets available</h4>
                    <p>There are currently no pets available for adoption. Please check back later.</p>
                    @auth
                        <hr>
                        <p class="mb-0">
                            <a href="{{ route('pets.create') }}" class="btn btn-primary">Post First Pet for Adoption</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

