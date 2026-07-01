@extends('admin.layout.master')

@section('content')

<div class="row"></div>

{{-- فرم آپلود تصویر --}}
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.products.pictures.store', $product) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="path">آپلود</label>
                        <input type="file" name="path" class="form-control">  
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-primary" value="آپلود">
                    </div>

                </form> 
            </div>
        </div>
    </div>
</div>

{{-- نمایش گالری محصولات افقی --}}
<div class="row mt-3">
    <div class="d-flex flex-row flex-nowrap overflow-auto" style="gap:15px; padding-bottom:10px;">
        @foreach ($product->pictures as $picture)
        <div style="
            min-width:260px;
            background:#ffffff;
            border-radius:16px;
            box-shadow:0 10px 25px rgba(0,0,0,0.12);
            overflow:hidden;
            font-family:Tahoma, sans-serif;
            direction:rtl;
        ">
            <img src="{{ asset('storage/' . $picture->path) }}" alt="product"
                 style="width:100%; height:180px; object-fit:cover;">

            <div style="padding:15px;">

                {{-- $product چون تصویر متعلق به یک محصول خاص هست لاراول باید بدونه این تصویر مربوط به کدوم محصوله.
                    $picture چون قراره کدوم تصویر حذف بشه مشخص باشه.
                       پس ما داریم می‌گیم:«تصویر فلان ($picture) از محصول فلان ($product) حذف شود»  --}}
               <form action="{{ route('admin.products.pictures.destroy', ['product'=> $product , 'picture' => $picture]) }}" method="post">
                   @csrf
                   @method('DELETE')
                   <input type="submit" class="btn btn-sm btn-danger" value="حذف">
               </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
