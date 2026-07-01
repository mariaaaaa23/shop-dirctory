@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">
            
            <div class="card-header">
                <h2 class="card.title">
                    مدیریت سفارشات 
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            
                            <th>شماره سفارش</th>
                            <th>مشتری</th>
                            <th>مبلغ کل</th>
                            <th>وضعیت فعلی </th>
                            <th>تغییر وضعیت </th>
                            <th>کد تخفیف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3 font-mono font-bold">#{{ $order->id }}</td>
                            <td class="p-3">
                                <span class="block font-medium text-slate-800">{{ $order->user->name }}</span>
                                <span class="block text-xs text-slate-400 font-mono">{{ $order->phone }}</span>
                            </td>
                            <td class="p-3 font-bold text-slate-900">{{ number_format($order->total_amount) }} تومان</td>
                            <td class="p-3">
                                @if($order->status == 'paid')
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">پرداخت شده (جدید)</span>
                                @elseif($order->status == 'shipped')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">ارسال شده پیتاژ</span>
                                @elseif($order->status == 'pending')
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">در انتظار پرداخت</span>
                                @else
                                    <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-medium">ناموفق / لغو شده</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    
                                    <select name="status" class="bg-white border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-700 focus:outline-none">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>پرداخت شده (جدید)</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>ارسال شده</option>
                                        <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>لغو شده</option>
                                    </select>
                            
                                    <input type="text" name="tracking_code" value="{{ $order->tracking_code }}" placeholder="کد پیگیری..." 
                                           class="bg-white border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-700 w-28 focus:outline-none focus:border-slate-400 text-center">
                            
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-dark px-3 py-2 rounded-xl text-xs font-bold transition-colors cursor-pointer">
                                        ثبت
                                    </button>
                                </form>
                            </td>
                            <td>
                                <p>مبلغ اولیه: <strong>{{ number_format($order->total_amount) }} تومان</strong></p>
                                
                                @if($order->coupon)
                                    <span class="badge bg-success">کد تخفیف: {{ $order->coupon->code }}</span>
                                    <small class="text-danger block">(تخفیف: {{ number_format($order->discount_amount) }} تومان)</small>
                                @else
                                    <span class="text-muted small">بدون استفاده از کد تخفیف</span>
                                @endif
                                
                                <div class="mt-2 text-success fw-bold">
                                    مبلغ پرداختی نهایی: {{ number_format($order->final_amount) }} تومان
                                </div>
                            </td>

                     @endforeach
                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
    
       </div>
   </div>

@endsection

@section('scripts')

   <!-- DataTables -->
<script src="/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

@endsection