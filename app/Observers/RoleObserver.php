<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        session()->flash('success', "دسته بندی {$role->name} با موفقیت ایجاد انجام شد");
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        session()->flash('success', "دسته بندی {$role->name} با موفقیت ویرایش انجام شد");
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        session()->flash('success', "دسته بندی {$role->name} با موفقیت جذف انجام شد");
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
