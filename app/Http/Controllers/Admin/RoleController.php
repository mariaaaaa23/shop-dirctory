<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public static function middleware(): array
    {
        return[
            new Middleware('permission:manage roles',only:['index','create','store','edit','update','destroy'] ),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // withCount('permissions') چون میخوام جلوی هر نقش بنویسم مثلا ادمین 5 تا دسترسی داره برای اینکه مثلا اگه برای یک نقش 10 تا دسترسی داشتیم لاراول 11بار نره به دیتابیس درخواست بفرسته و سرعت لود پایین نیاد از این کد استفاده میکنیم
        $roles = Role::withCount('permissions')->get();
        return view('admin.roles.index',
          compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',
             compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create([
            'name' => $request->name
        ]);

        // اختصاص پرمشن ها اگه تیکی زده باشه 
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // گرفتن همه دسترسی ها
        $permissions = Permission::all();

        // پرمشن هایی که این نقش در حال حاضر دارند (برای تیک زدن چک باکس ها)
        // $role->permissions لیست پرمشن هایی که این نقش خاص (مثلا نویسنده) در حال حاضر داره رو میگیره
    //  pluck('id')  چون اطلاعات پرمشن هارو نمیخواییم فقط آیدیشون میخواییم
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit',
           compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);

        // برای بروزرسانی دسترسی ها باید قبلی ها پاک بشه و تغییرات جدید ارسال بشه
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // جلوگیری از حذف نقش ادمین اصلی برای امنیت سایت
        if($role->name == 'admin'){
            return back()->with('error', 'نقش مدیر اصلی قابل حذف نیست');
        }

        $role->delete();
        return redirect()->route('admin.roles.index');
    }
}
