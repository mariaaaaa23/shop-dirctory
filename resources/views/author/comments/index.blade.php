@extends('client.layout.master')

@section('content')
<div class="container mt-5" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>💬 نظرات و کامنت‌های آگهی‌های شما</h2>
    </div>

    {{-- نمایش پیام موفقیت حذف --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 text-center vertical-align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">نویسنده نظر</th>
                            <th scope="col" style="width: 200px;">مربوط به آگهی</th>
                            <th scope="col">متن نظر</th>
                            <th scope="col">تاریخ ثبت</th>
                            <th scope="col" style="width: 150px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                
                                <td class="fw-bold text-secondary">
                                    {{ $comment->user->name ?? 'کاربر مهمان' }}
                                </td>

                                <td>
                                    <span class="text-primary fw-bold">
                                        {{ $comment->product->name ?? 'آگهی حذف شده' }}
                                    </span>
                                </td>

                                <td class="text-end px-3 small text-wrap" style="max-width: 350px;">
                                    {{ $comment->text ?? $comment->body }}
                                </td>

                                <td class="small text-muted">
                                    {{ json_decode(collect($comment->created_at))->date ?? $comment->created_at->format('Y-m-d') }}
                                </td>

                                <td>
                                    {{-- فرم حذف کامنت --}}
                                    <form action="{{ route('author.comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این نظر مطمئن هستید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i> حذف نظر
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <p class="mb-0 fs-5">هنوز هیچ نظری برای آگهی‌های شما ثبت نشده است.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- بخش صفحه بندی --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $comments->links() }}
    </div>
</div>
@endsection