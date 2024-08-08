<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        return view('admin.export.product', [
            "datas" => Product::select(
                'products.id as id',
                'brand_models.sku',
                'products.status',
                'products.extra_day',
                (App::currentLocale() === "en" ? 'brand_models.name_en' : 'brand_models.name_th') . ' as brand_model',
                'products.created_at',
                DB::raw('concat(user_infos.firstname," ",user_infos.lastname) as user_name'),
                DB::raw('users.phone as name'),
                DB::raw('(select ADDDATE(created_at,INTERVAL COALESCE(1096+pr.extra_day,0) DAY) from products as pr where pr.id = products.id) as expired_date'),
            )->where('status', 'approve')
            ->leftJoin('brand_models', 'brand_models.id', 'products.brand_model_id')
            ->leftJoin('brands', 'brand_models.brand_id', 'brands.id')
            ->leftJoin('users','users.id','=','products.user_id')
            ->leftJoin('user_infos','user_infos.user_id','=','users.id')
            ->where('brand_models.id',$this->id)
            ->groupBy('products.id')
            ->get()
        ]);
    }
}
