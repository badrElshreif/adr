<?php

namespace App\Admin\Domain\Observers;

use App\Admin\Domain\Models\Admin;
use App\Company\Domain\Models\CompanyAdmin;

class AdminObserver
{
    /**
     * Handle the CompanyAdmin "created" event.
     *
     * @param  \App\Models\CompanyAdmin  $CompanyAdmin
     * @return void
     */
    public function created(Admin $CompanyAdmin)
    {

    }

    /**
     * Handle the CompanyAdmin "updated" event.
     *
     * @param  \App\Models\CompanyAdmin  $CompanyAdmin
     * @return void
     */
    public function updated(Admin $CompanyAdmin)
    {
//        if ($CompanyAdmin->user) {
//            $data = Arr::only($CompanyAdmin->toArray(), ['name', 'email', 'phone', 'avatar', 'is_active']);
//            $CompanyAdmin->user()->update($data);
//        }
    }

    /*
     * Handle the CompanyAdmin "deleted" event.
     *
     * @param  \App\Models\CompanyAdmin  $CompanyAdmin
     * @return void
     */
//    public function deleted(CompanyAdmin $CompanyAdmin)
//    {
//        //
//    }

    /*
     * Handle the CompanyAdmin "restored" event.
     *
     * @param  \App\Models\CompanyAdmin  $CompanyAdmin
     * @return void
     */
//    public function restored(CompanyAdmin $CompanyAdmin)
//    {
//        //
//    }

    /*
     * Handle the CompanyAdmin "force deleted" event.
     *
     * @param  \App\Models\CompanyAdmin  $CompanyAdmin
     * @return void
     */
//    public function forceDeleted(CompanyAdmin $CompanyAdmin)
//    {
//        //
//    }
}
