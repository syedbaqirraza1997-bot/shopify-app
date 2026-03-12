@extends('layouts.app')

@section('title', 'Urgency - Smart Conversion Booster')
@section('page-title', 'Urgency & Scarcity')

@section('content')
<form action="{{ route('urgency.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clock"></i> Countdown Timer
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="timer_enabled" class="form-check-input" id="timerEnabled" {{ ($settings->timer_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="timerEnabled">Enable Countdown Timer</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Timer Message</label>
                        <input type="text" name="timer_message" class="form-control" value="{{ $settings->timer_message ?? 'Offer ends in:' }}">
                    </div>
                    
                    <div class="alert alert-danger">
                        <strong>Preview:</strong><br>
                        <div style="background: #ff4444; color: white; padding: 12px; border-radius: 4px; text-align: center; margin-top: 10px;">
                            <div style="font-size: 14px; margin-bottom: 8px;">{{ $settings->timer_message ?? 'Offer ends in:' }}</div>
                            <div style="font-size: 24px; font-weight: 700; font-family: monospace;">02:15:30:45</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-box"></i> Stock Urgency
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="stock_urgency_enabled" class="form-check-input" id="stockUrgencyEnabled" {{ ($settings->stock_urgency_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="stockUrgencyEnabled">Enable Stock Urgency</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Stock Message</label>
                        <input type="text" name="stock_urgency_message" class="form-control" value="{{ $settings->stock_urgency_message ?? 'Only {quantity} left in stock - order soon!' }}">
                        <small class="text-muted">Use <code>{quantity}</code> for stock number</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Low Stock Threshold</label>
                        <input type="number" name="stock_urgency_threshold" class="form-control" value="{{ $settings->stock_urgency_threshold ?? 10 }}">
                        <small class="text-muted">Jab stock is number se kam ho toh warning dikhayein</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <strong>Preview:</strong><br>
                        <div style="color: #ff4444; font-size: 14px; margin-top: 10px;">
                            <div>⚠️ {{ str_replace('{quantity}', $settings->stock_urgency_threshold ?? 10, $settings->stock_urgency_message ?? 'Only {quantity} left in stock - order soon!') }}</div>
                            <div style="height: 6px; background: #e5e5e5; border-radius: 3px; margin-top: 8px; overflow: hidden;">
                                <div style="height: 100%; width: 50%; background: #ff4444; border-radius: 3px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Why Urgency?
                </div>
                <div class="card-body">
                    <p class="text-muted">Urgency aur scarcity se:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Customer jaldi decide karta hai</li>
                        <li><i class="fas fa-check text-success"></i> Cart abandonment kam hota hai</li>
                        <li><i class="fas fa-check text-success"></i> Conversions increase hote hain</li>
                        <li><i class="fas fa-check text-success"></i> FOMO (Fear of Missing Out) create hota hai</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="text-muted small">Tip: Zyada use nahi karein, warna customer annoyed ho sakta hai.</p>
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
@endsection
