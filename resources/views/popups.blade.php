@extends('layouts.app')

@section('title', 'Sales Popups - Smart Conversion Booster')
@section('page-title', 'Sales Notification Popups')

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('popups.settings') }}" method="POST">
            @csrf
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cog"></i> Popup Settings
                </div>
                <div class="card-body">
                    <!-- Enable/Disable -->
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" name="sales_popup_enabled" class="form-check-input" id="popupEnabled" {{ ($settings->sales_popup_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="popupEnabled"><strong>Enable Sales Popups</strong></label>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Popup Position</label>
                                <select name="sales_popup_position" class="form-select">
                                    <option value="bottom-left" {{ ($settings->sales_popup_position ?? 'bottom-left') == 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                                    <option value="bottom-right" {{ ($settings->sales_popup_position ?? 'bottom-left') == 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                                    <option value="top-left" {{ ($settings->sales_popup_position ?? 'bottom-left') == 'top-left' ? 'selected' : '' }}>Top Left</option>
                                    <option value="top-right" {{ ($settings->sales_popup_position ?? 'bottom-left') == 'top-right' ? 'selected' : '' }}>Top Right</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Animation</label>
                                <select name="sales_popup_animation" class="form-select">
                                    <option value="slide" {{ ($settings->sales_popup_animation ?? 'slide') == 'slide' ? 'selected' : '' }}>Slide</option>
                                    <option value="fade" {{ ($settings->sales_popup_animation ?? 'slide') == 'fade' ? 'selected' : '' }}>Fade</option>
                                    <option value="bounce" {{ ($settings->sales_popup_animation ?? 'slide') == 'bounce' ? 'selected' : '' }}>Bounce</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Display Duration (ms)</label>
                                <input type="number" name="sales_popup_duration" class="form-control" value="{{ $settings->sales_popup_duration ?? 5000 }}">
                                <small class="text-muted">Kitni der tak dikhayen</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Delay Between (ms)</label>
                                <input type="number" name="sales_popup_delay" class="form-control" value="{{ $settings->sales_popup_delay ?? 10000 }}">
                                <small class="text-muted">Do popups ke darmiyan waqt</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Max Per Session</label>
                                <input type="number" name="sales_popup_max" class="form-control" value="{{ $settings->sales_popup_max ?? 5 }}">
                                <small class="text-muted">Ek session mein kitne popups</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Data Source</label>
                        <select name="sales_popup_data_source" class="form-select">
                            <option value="real" {{ ($settings->sales_popup_data_source ?? 'real') == 'real' ? 'selected' : '' }}>Real Orders Only</option>
                            <option value="simulated" {{ ($settings->sales_popup_data_source ?? 'real') == 'simulated' ? 'selected' : '' }}>Simulated Data</option>
                            <option value="mixed" {{ ($settings->sales_popup_data_source ?? 'real') == 'mixed' ? 'selected' : '' }}>Mixed (Real + Simulated)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message Template</label>
                        <input type="text" name="sales_popup_template" class="form-control" value="{{ $settings->sales_popup_template ?? '{{name}} from {{location}} purchased {{product}}' }}">
                        <small class="text-muted">Variables: {{ '{name}' }}, {{ '{location}' }}, {{ '{product}' }}, {{ '{time}' }}</small>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="sales_popup_mobile" class="form-check-input" id="showMobile" {{ ($settings->sales_popup_mobile ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showMobile">Show on mobile devices</label>
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
    
    <div class="col-md-4">
        <!-- Test Popup -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-vial"></i> Test Popup
            </div>
            <div class="card-body">
                <p class="text-muted">Test popup generate karke dekhain</p>
                <form action="{{ route('popups.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-plus"></i> Generate Test Popup
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Recent Popups -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Recent Popups
            </div>
            <div class="card-body">
                @if($popups->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($popups->take(5) as $popup)
                        <li class="list-group-item">
                            <small><strong>{{ $popup->customer_name }}</strong> from {{ $popup->customer_location }}</small><br>
                            <small class="text-muted">{{ Str::limit($popup->product_name, 20) }}</small>
                            @if($popup->is_simulated)
                                <span class="badge bg-warning float-end">Simulated</span>
                            @else
                                <span class="badge bg-success float-end">Real</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center">No popups yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
