@extends('client.layout.master') @section('content')
<div class="container mt-5" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-2xl">
                <div class="card-header bg-dark text-white p-3 rounded-t-2xl">
                    <h5 class="card-title mb-0 fs-6 fw-bold">🏷️ ایجاد تخفیف برای محصول: {{ $product->name }}</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('author.products.discounts.store', $product) }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="value" class="form-label small fw-bold text-secondary mb-2">مقدار درصد تخفیف (بین ۱ تا ۱۰۰)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">%</span>
                                <input type="number" max="100" min="1" class="form-control text-center fw-bold" name="value" id="value" placeholder="مثلاً: 20" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <input type="submit" name="submit" id="submit" value="ثبت و اعمال تخفیف" class="btn btn-primary fw-bold p-2.5 rounded-xl">
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- نمایش خطاهای ولیدیشن در صورت وجود --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3 rounded-xl small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection