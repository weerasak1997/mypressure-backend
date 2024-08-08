<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromView;

class BrandModelExport implements FromView
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
        return view('admin.export.brand-model', [
            "datas" => Product::select(
                'brand_models.id as id',
                'brand_models.sku',
                DB::raw('count(products.id) as count'),
                (App::currentLocale() === "en" ? 'brand_models.name_en' : 'brand_models.name_th') . ' as brand_model',
                'products.created_at',
            )->where('status', 'approve')
                ->leftJoin('brand_models', 'brand_models.id', 'products.brand_model_id')
                ->leftJoin('brands', 'brand_models.brand_id', 'brands.id')
                ->where('brands.id',$this->id)
                ->groupBy('brand_models.id')
                ->get()
        ]);
    }
}
