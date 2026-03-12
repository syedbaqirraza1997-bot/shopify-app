@extends('layouts.app')

@section('title', 'Trust Badges - Smart Conversion Booster')
@section('page-title', 'Trust Badges')

@section('content')
@php
$badges = json_decode($settings->trust_badges ?? '[]', true);
if (empty($badges)) {
    $badges = [
        ['id' => 1, 'type' => 'secure-checkout', 'label' => 'Secure Checkout', 'enabled' => true, 'icon' => 'secure'],
        ['id' => 2, 'type' => 'fast-delivery', 'label' => 'Fast Delivery', 'enabled' => true, 'icon' => 'delivery'],
        ['id' => 3, 'type' => 'money-back', 'label' => 'Money Back Guarantee', 'enabled' => true, 'icon' => 'money'],
    ];
}
@endphp

<form action="{{ route('trust-badges.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cog"></i> Badge Settings
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Badge Position</label>
                        <select name="trust_badges_position" class="form-select">
                            <option value="below-add-to-cart" {{ ($settings->trust_badges_position ?? 'below-add-to-cart') == 'below-add-to-cart' ? 'selected' : '' }}>Below Add to Cart</option>
                            <option value="below-price" {{ ($settings->trust_badges_position ?? 'below-add-to-cart') == 'below-price' ? 'selected' : '' }}>Below Price</option>
                            <option value="footer" {{ ($settings->trust_badges_position ?? 'below-add-to-cart') == 'footer' ? 'selected' : '' }}>Footer</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-shield-alt"></i> Badges
                </div>
                <div class="card-body">
                    @foreach($badges as $index => $badge)
                    <div class="border rounded p-3 mb-3">
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" name="badge_{{ $badge['type'] }}_enabled" class="form-check-input" id="badge{{ $index }}" {{ $badge['enabled'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="badge{{ $index }}">
                                <strong>{{ ucfirst(str_replace('-', ' ', $badge['type'])) }}</strong>
                            </label>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label">Badge Text</label>
                            <input type="text" name="badge_{{ $badge['type'] }}" class="form-control" value="{{ $badge['label'] }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-eye"></i> Preview
                </div>
                <div class="card-body text-center">
                    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        @foreach($badges as $badge)
                            @if($badge['enabled'])
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                @if($badge['icon'] == 'secure')
                                    🔒
                                @elseif($badge['icon'] == 'delivery')
                                    🚚
                                @elseif($badge['icon'] == 'money')
                                    💰
                                @endif
                                <span>{{ $badge['label'] }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Why Trust Badges?
                </div>
                <div class="card-body">
                    <p class="text-muted">Trust badges customer ko confidence dete hain:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Security feel hoti hai</li>
                        <li><i class="fas fa-check text-success"></i> Cart abandonment kam hota hai</li>
                        <li><i class="fas fa-check text-success"></i> Brand trust build hota hai</li>
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
@endsection
