@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Orders</h2>
            <p class="text-muted mb-0">Manage and track all your orders</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold">Booking ID</th>
                            <th class="py-3 fw-semibold">Product</th>
                            <th class="py-3 fw-semibold">Total</th>
                            <th class="py-3 fw-semibold">Status</th>
                            <th class="py-3 fw-semibold">Date</th>
                            <th class="px-4 py-3 fw-semibold text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4">
                                <span class="badge bg-dark">{{ $order->booking_trx_id }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $order->shoe->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="text-primary fw-bold">Rp {{ number_format($order->grand_total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($order->is_paid)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Paid
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i>Unpaid
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-4 text-center">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No orders yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>
@endsection