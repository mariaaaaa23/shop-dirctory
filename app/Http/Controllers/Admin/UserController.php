<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public static function middleware(): array
    {
        return [
            // اعمال پرمیشن‌ها به متدهای خاص
            new Middleware('permission:manage users', only:['index','destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // دریافت کاربران به همراه نقش هایشان و صفحه بندی 10تایی

        // with('roles') اگه اینو بنویسیم لاراول با 2بار که یک بار میره همه کاربرارو. میگیره و بار دوم نقششون رو میگیره که برای سرعت لود صفحه این کد مناسبه
    //    latest() برای اینکه جدیدترین کاربر که عضو شدن بیان اول لیست
    // paginate(10) فقط 10نفر اول رو نشون میده و پایین صفحه شماره 1 و 2و 3و و...نشون میده که سایت همیشه سبک و سریع باقی بمونه
        $users = User::with('roles')->latest()->paginate(10);

        return view('admin.users.index', 
        compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // گرفتن تما نقش ها برای دراپ دان
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();
        return view('admin.users.edit',
    compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRoleRequest $request, User $user)
    {
           
    if ($request->role && $request->role !== 'none') {
        $user->syncRoles($request->role);

        //  اگر ادمین نقش را روی author یا admin گذاشت، وضعیت دیتابیس همapproved می‌شود
        $user->update([
            'status' => 'approved' 
        ]);
    } else {
        // اگر روی کاربر عادی (بدون نقش) گذاشت
        $user->syncRoles([]);

        //  وضعیت دیتابیس به کاربر معمولی برمی‌گردد
        $user->update([
            'status' => 'user'
        ]);
    }

    return redirect()->route('admin.users.index')->with('success', "نقش و وضعیت کاربر {$user->name} با موفقیت به‌روزرسانی شد.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
       // جلوگیری از اینکه ادمین نتونه خودش رو حذف کنه
       if(Auth::id() === $user->id){
        return back()->with('error',"شما نمی توانید حساب کاربری خودتان را حذف کنید");
    }


    $user->delete();
    return redirect()->route('admin.users.index')->with('success', "کاربر مورد نظر با موفقیت از سیستم حذف شد");
    }


    public function requestAuthor()
    {
        $user = auth()->user();

        //اگه کاربر قبلا درخواست نداده وضعیتش را به در انتظار تایید تغییر بده
        if($user->status == 'user' || $user->status == null){
            $user->update([
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'درخواست شما با موفقیت ارسال شد در انتظار تایید ادمین است');
        }

        return redirect()->back()->with('info', 'درخواست شما قبلا ارسال شده است');
    }
}
