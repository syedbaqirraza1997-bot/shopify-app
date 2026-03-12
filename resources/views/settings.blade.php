@extends('layouts.app')

@section('title', 'Settings - Smart Conversion Booster')
@section('page-title', 'Settings')

@section('content')
<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <!-- General Settings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-palette"></i> Appearance
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Primary Color</label>
                        <input type="color" name="primary_color" class="form-control" value="{{ $settings->primary_color ?? '#008060' }}">
                        <small class="text-muted">Widgets mein yeh color use hoga</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Custom CSS</label>
                        <textarea name="custom_css" class="form-control" rows="5" placeholder="/* Your custom CSS here */">{{ $settings->custom_css ?? '' }}</textarea>
                        <small class="text-muted">Advanced users ke liye custom styling</small>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="mobile_optimized" class="form-check-input" id="mobileOptimized" {{ ($settings->mobile_optimized ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mobileOptimized">Mobile Optimized</label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reviews Settings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-star"></i> Reviews Settings
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input type="checkbox" name="reviews_require_approval" class="form-check-input" id="requireApproval" {{ ($settings->reviews_require_approval ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="requireApproval">Require approval for new reviews</label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" name="reviews_allow_photos" class="form-check-input" id="allowPhotos" {{ ($settings->reviews_allow_photos ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allowPhotos">Allow photo reviews</label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" name="reviews_allow_videos" class="form-check-input" id="allowVideos" {{ ($settings->reviews_allow_videos ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allowVideos">Allow video reviews</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Reviews Per Page</label>
                        <select name="reviews_per_page" class="form-select">
                            <option value="5" {{ ($settings->reviews_per_page ?? 10) == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ ($settings->reviews_per_page ?? 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ ($settings->reviews_per_page ?? 10) == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ ($settings->reviews_per_page ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </div>
</form>
@endsection
