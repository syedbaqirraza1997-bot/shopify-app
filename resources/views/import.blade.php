@extends('layouts.app')

@section('title', 'Import Reviews - Smart Conversion Booster')
@section('page-title', 'Import Reviews')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-csv"></i> CSV Import
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>CSV Format:</strong> CSV file mein yeh columns hone chahiye:<br>
                    <code>product_id, rating, title, content, name, email</code>
                </div>
                
                <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Select CSV File</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Import Reviews
                    </button>
                </form>
                
                <hr>
                
                <h6>Sample CSV Format:</h6>
                <pre class="bg-light p-3 rounded">product_id,rating,title,content,name,email
123456789,5,Great product!,I love this product,Ahmed,ahmed@example.com
123456789,4,Good quality,Nice quality for the price,Sarah,sarah@example.com</pre>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Import Options
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-secondary" disabled>
                        <i class="fab fa-alipay"></i> AliExpress Import
                        <span class="badge bg-secondary">Coming Soon</span>
                    </button>
                    <button class="btn btn-outline-secondary" disabled>
                        <i class="fab fa-amazon"></i> Amazon Import
                        <span class="badge bg-secondary">Coming Soon</span>
                    </button>
                </div>
                
                <hr>
                
                <h6>Tips:</h6>
                <ul class="small text-muted">
                    <li>Maximum 1000 reviews per import</li>
                    <li>Rating 1-5 honi chahiye</li>
                    <li>UTF-8 encoding use karein</li>
                    <li>Import kiay reviews auto-approved hongay</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
