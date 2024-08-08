<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    }
    public function view(): View
    {
        return view('admin.export.customer', [
            "datas" => $data = User::select(
                'users.id',
                'users.phone',
                DB::raw('case when user_infos.id is null then '.((App::currentLocale() === "en")?'"User info is not exist."':'"ไม่มีข้อมูลผู้ใช้งาน"').' else concat(user_infos.firstname," ",user_infos.lastname) end as name'),
                'users.created_at',
                DB::raw('(select max(created_at) from products where products.user_id = users.id) as last_date'),
                DB::raw('(select count(id) from products where products.user_id = users.id) as amount'),
            )
            ->where('type','user')
            ->leftJoin('user_infos','user_infos.user_id','users.id')
            ->get()
        ]);
    }
}
