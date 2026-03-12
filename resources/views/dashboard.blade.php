@extends('layouts.app')

@section('title', 'Dashboard - Smart Conversion Booster')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $totalReviews }}</div>
            <div class="stat-label">Total Reviews</div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $pendingReviews }}</div>
            <div class="stat-label">Pending Reviews</div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $totalPopups }}</div>
            <div class="stat-label">Total Popups</div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $popupViews }}</div>
            <div class="stat-label">Popup Views</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('reviews') }}" class="btn btn-outline-primary">
                        <i class="fas fa-star"></i> Manage Reviews
                        @if($pendingReviews > 0)
                            <span class="badge bg-warning">{{ $pendingReviews }}</span>
                        @endif
                    </a>
                    <a href="{{ route('popups') }}" class="btn btn-outline-primary">
                        <i class="fas fa-bell"></i> Configure Popups
                    </a>
                    <a href="{{ route('settings') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog"></i> App Settings
                    </a>
                    <a href="{{ route('import') }}" class="btn btn-outline-primary">
                        <i class="fas fa-upload"></i> Import Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Reviews -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Recent Reviews
            </div>
            <div class="card-body">
                @if($recentReviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReviews as $review)
                                <tr>
                                    <td>{{ $review->customer_name }}</td>
                                    <td>{{ Str::limit($review->product_title, 30) }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>
                                        @if($review->status == 'pending')
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($review->status == 'approved')
                                            <span class="badge badge-approved">Approved</span>
                                        @else
                                            <span class="badge badge-rejected">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No reviews yet. <a href="{{ route('import') }}">Import some reviews</a> to get started.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Widget Status -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-toggle-on"></i> Widget Status
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <i class="fas fa-bell fa-2x {{ $shop->settings->sales_popup_enabled ?? true ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <small>Sales Popups</small><br>
                        <span class="badge {{ $shop->settings->sales_popup_enabled ?? true ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->settings->sales_popup_enabled ?? true ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                    
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <i class="fas fa-star fa-2x {{ $shop->settings->reviews_enabled ?? true ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <small>Reviews</small><br>
                        <span class="badge {{ $shop->settings->reviews_enabled ?? true ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->settings->reviews_enabled ?? true ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                    
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <i class="fas fa-users fa-2x {{ $shop->settings->social_proof_enabled ?? true ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <small>Social Proof</small><br>
                        <span class="badge {{ $shop->settings->social_proof_enabled ?? true ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->settings->social_proof_enabled ?? true ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                    
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <i class="fas fa-shield-alt fa-2x {{ $shop->settings->trust_badges_enabled ?? true ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <small>Trust Badges</small><br>
                        <span class="badge {{ $shop->settings->trust_badges_enabled ?? true ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->settings->trust_badges_enabled ?? true ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                    
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <i class="fas fa-clock fa-2x {{ $shop->settings->urgency_enabled ?? true ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <small>Urgency</small><br>
                        <span class="badge {{ $shop->settings->urgency_enabled ?? true ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->settings->urgency_enabled ?? true ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
