@extends('layouts.app')

@section('title', 'Reviews - Smart Conversion Booster')
@section('page-title', 'Product Reviews')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <!-- Stats -->
        <div class="d-flex gap-3 mb-3">
            <span class="badge bg-secondary">Total: {{ $stats['total'] }}</span>
            <span class="badge badge-pending">Pending: {{ $stats['pending'] }}</span>
            <span class="badge badge-approved">Approved: {{ $stats['approved'] }}</span>
            <span class="badge badge-rejected">Rejected: {{ $stats['rejected'] }}</span>
        </div>
        
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $status == 'all' ? 'active' : '' }}" href="{{ route('reviews', ['status' => 'all']) }}">All Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="{{ route('reviews', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'approved' ? 'active' : '' }}" href="{{ route('reviews', ['status' => 'approved']) }}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'rejected' ? 'active' : '' }}" href="{{ route('reviews', ['status' => 'rejected']) }}">Rejected</a>
            </li>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($reviews->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>
                                <strong>{{ $review->customer_name }}</strong>
                                @if($review->is_verified_purchase)
                                    <br><small class="text-success"><i class="fas fa-check-circle"></i> Verified</small>
                                @endif
                            </td>
                            <td>{{ Str::limit($review->product_title, 25) }}</td>
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
                                @if($review->title)
                                    <strong>{{ Str::limit($review->title, 30) }}</strong><br>
                                @endif
                                <small>{{ Str::limit($review->content, 50) }}</small>
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
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($review->status == 'pending')
                                        <form action="{{ route('reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#replyModal{{ $review->id }}" title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    
                                    <form action="{{ route('reviews.delete', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Reply Modal -->
                                <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reply to Review</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Your Reply</label>
                                                        <textarea name="reply" class="form-control" rows="4" required>{{ $review->reply_content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Send Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                <h5>No reviews found</h5>
                <p class="text-muted">Start collecting reviews or <a href="{{ route('import') }}">import existing ones</a>.</p>
            </div>
        @endif
    </div>
</div>
@endsection
