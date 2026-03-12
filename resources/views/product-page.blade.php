@extends('layouts.app')

@section('title', 'Product Page - Smart Conversion Booster')
@section('page-title', 'Product Page Optimization')

@section('content')
<form action="{{ route('product-page.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-toggle-on"></i> Enable Features
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="feature_icons_enabled" class="form-check-input" id="featureIcons" {{ ($settings->feature_icons_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featureIcons">
                            <strong>Feature Icons</strong><br>
                            <small class="text-muted">Free Shipping, Secure Payment, etc. icons dikhayein</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="benefit_bullets_enabled" class="form-check-input" id="benefitBullets" {{ ($settings->benefit_bullets_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="benefitBullets">
                            <strong>Benefit Bullets</strong><br>
                            <small class="text-muted">Product benefits bullet points mein dikhayein</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="faq_enabled" class="form-check-input" id="faqEnabled" {{ ($settings->faq_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="faqEnabled">
                            <strong>FAQ Accordion</strong><br>
                            <small class="text-muted">Frequently asked questions accordion format mein</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="related_products_enabled" class="form-check-input" id="relatedProducts" {{ ($settings->related_products_enabled ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="relatedProducts">
                            <strong>Related Products</strong><br>
                            <small class="text-muted">"You May Also Like" section dikhayein</small>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list"></i> Feature Icons Example
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-around; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <div class="text-center">
                            <div style="font-size: 24px;">🚚</div>
                            <small>Free Shipping</small>
                        </div>
                        <div class="text-center">
                            <div style="font-size: 24px;">🔒</div>
                            <small>Secure Payment</small>
                        </div>
                        <div class="text-center">
                            <div style="font-size: 24px;">↩️</div>
                            <small>Easy Returns</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Benefits
                </div>
                <div class="card-body">
                    <p class="text-muted">Product page optimization se:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> More information customer ko milti hai</li>
                        <li><i class="fas fa-check text-success"></i> Objections handle hote hain</li>
                        <li><i class="fas fa-check text-success"></i> Average order value badhti hai</li>
                        <li><i class="fas fa-check text-success"></i> Customer confidence badhta hai</li>
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
