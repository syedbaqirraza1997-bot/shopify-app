@extends('layouts.app')

@section('title', 'Social Proof - Smart Conversion Booster')
@section('page-title', 'Social Proof Widgets')

@section('content')
<form action="{{ route('social-proof.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users"></i> Viewers Count
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="viewers_enabled" class="form-check-input" id="viewersEnabled" {{ ($settings->viewers_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="viewersEnabled">Enable Viewers Count</label>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Minimum Viewers</label>
                                <input type="number" name="viewers_min" class="form-control" value="{{ $settings->viewers_min ?? 5 }}">
                                <small class="text-muted">Kam se kam kitne viewers dikhayein</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Maximum Viewers</label>
                                <input type="number" name="viewers_max" class="form-control" value="{{ $settings->viewers_max ?? 50 }}">
                                <small class="text-muted">Zyada se zyada kitne viewers dikhayein</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Preview:</strong> "<span id="viewerPreview">25</span> people are viewing this product right now"
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-box"></i> Stock Indicator
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="stock_enabled" class="form-check-input" id="stockEnabled" {{ ($settings->stock_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="stockEnabled">Enable Stock Indicator</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Stock Threshold</label>
                        <input type="number" name="stock_threshold" class="form-control" value="{{ $settings->stock_threshold ?? 10 }}">
                        <small class="text-muted">Jab stock is number se kam ho toh indicator dikhayein</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <strong>Preview:</strong> "Only <span id="stockPreview">10</span> items left in stock - order soon!"
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-fire"></i> Trending Badge
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="trending_enabled" class="form-check-input" id="trendingEnabled" {{ ($settings->trending_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="trendingEnabled">Enable Trending Badge</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Minimum Orders</label>
                        <input type="number" name="trending_min_orders" class="form-control" value="{{ $settings->trending_min_orders ?? 10 }}">
                        <small class="text-muted">24 ghante mein kitne orders hone chahiye</small>
                    </div>
                    
                    <div class="alert alert-danger">
                        <strong>Preview:</strong> "🔥 Trending - <span id="trendingPreview">10</span>+ sold in 24 hours"
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> About Social Proof
                </div>
                <div class="card-body">
                    <p class="text-muted">Social proof widgets customer ko encourage karte hain purchase karne ke liye.</p>
                    
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Trust build hota hai</li>
                        <li><i class="fas fa-check text-success"></i> Urgency create hoti hai</li>
                        <li><i class="fas fa-check text-success"></i> Conversions badhte hain</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-end">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </div>
</form>

<script>
    // Preview updates
    document.querySelector('input[name="viewers_min"]').addEventListener('input', function() {
        document.getElementById('viewerPreview').textContent = this.value;
    });
    document.querySelector('input[name="stock_threshold"]').addEventListener('input', function() {
        document.getElementById('stockPreview').textContent = this.value;
    });
    document.querySelector('input[name="trending_min_orders"]').addEventListener('input', function() {
        document.getElementById('trendingPreview').textContent = this.value;
    });
</script>
@endsection
