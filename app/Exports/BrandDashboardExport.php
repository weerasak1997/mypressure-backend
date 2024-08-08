<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromView;

class BrandDashboardExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $type;
    public function __construct(string $type)
    {
        $this->type = $type;
    }
    public function view(): View
    {
        $showDetail = '';
        if($this->type === 'day'){
            $brand = Product::select(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th").' as name')
                            ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
                            ->leftJoin('brands','brands.id','brand_models.brand_id')
                            ->whereBetween('buying_date',[date('Y-m-d',strtotime('-31 days')),date('Y-m-d')])
                            ->groupBy('name')
                            ->get();
            $names = array_column($brand->toArray(),'name');
            $dataArray = null;
            $dateShow = [];
            foreach($names as $name){
                $data = null;
                $date = null;
                for($i=0;$i<31;$i++){
                    $d = date('d/m/Y',strtotime('-'.$i.' days'));
                    $item = Product::select(DB::raw('count(products.id) as amount'))
                    ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
                    ->leftJoin('brands','brands.id','brand_models.brand_id')
                    ->where(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th"),$name)
                    ->whereDate('buying_date',date('Y-m-d',strtotime('-'.$i.' days')))
                    ->first()->amount;
                    if($date == null){
                        $date = [$d];
                    }else{
                        array_push($date,$d);
                    }
                    if($data == null){
                        $data = [$item];
                    }else{
                        array_push($data,$item);
                    }
                }
                $dateShow = $date;
                if($dataArray == null){
                    $dataArray = [['name'=>$name,'data'=>$data]];
                }else{
                    array_push($dataArray,['name'=>$name,'data'=>$data]);
                }
            }
            $showDetail= ['y'=>$dateShow,'data'=>$dataArray];
        }else if($this->type === 'month'){
            $monthsMapping = array(
                'January' => 'มกราคม',
                'February' => 'กุมภาพันธ์',
                'March' => 'มีนาคม',
                'April' => 'เมษายน',
                'May' => 'พฤษภาคม',
                'June' => 'มิถุนายน',
                'July' => 'กรกฎาคม',
                'August' => 'สิงหาคม',
                'September' => 'กันยายน',
                'October' => 'ตุลาคม',
                'November' => 'พฤศจิกายน',
                'December' => 'ธันวาคม'
            );
            $brand = Product::select(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th").' as name')
            ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
            ->leftJoin('brands','brands.id','brand_models.brand_id')
            ->whereBetween('buying_date',[date('Y-m-d',strtotime('-12 months')),date('Y-m-d')])
            ->groupBy('name')
            ->get();
            $names = array_column($brand->toArray(),'name');
            $dataArray = null;
            $dateShow = [];
            foreach($names as $name){
            $data = null;
            $date = null;
            for($i=0;$i<12;$i++){
                $d = date('F',strtotime('-'.$i.' months'));
                $item = Product::select(DB::raw('count(products.id) as amount'))
                ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
                ->leftJoin('brands','brands.id','brand_models.brand_id')
                ->where(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th"),$name)
                ->whereMonth('buying_date',date('m',strtotime('-'.$i.' months')))
                ->whereYear('buying_date',date('Y',strtotime('-'.$i.' months')))
                ->first()->amount;
                if($date == null){
                    $date = [((App::currentLocale()=='en')?$d:$monthsMapping[$d]).' '.date('Y',strtotime('-'.$i.' months'))];
                }else{
                    array_push($date,((App::currentLocale()=='en')?$d:$monthsMapping[$d]).' '.date('Y',strtotime('-'.$i.' months')));
                }
                if($data == null){
                    $data = [$item];
                }else{
                    array_push($data,$item);
                }
            }
            $dateShow = $date;
            if($dataArray == null){
                $dataArray = [['name'=>$name,'data'=>$data]];
            }else{
                array_push($dataArray,['name'=>$name,'data'=>$data]);
            }
            }
            $showDetail= ['y'=>$dateShow,'data'=>$dataArray];
        }else{
            $brand = Product::select(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th").' as name')
            ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
            ->leftJoin('brands','brands.id','brand_models.brand_id')
            ->whereBetween('buying_date',[date('Y-m-d',strtotime('-6 years')),date('Y-m-d')])
            ->groupBy('name')
            ->get();
            $names = array_column($brand->toArray(),'name');
            $dataArray = null;
            $dateShow = [];
            foreach($names as $name){
            $data = null;
            $date = null;
            for($i=0;$i<6;$i++){
                $d = date('Y',strtotime('-'.$i.' years'));
                $item = Product::select(DB::raw('count(products.id) as amount'))
                ->leftJoin('brand_models','brand_models.id','products.brand_model_id')
                ->leftJoin('brands','brands.id','brand_models.brand_id')
                ->where(((App::currentLocale()=='en')?"brands.name_en":"brands.name_th"),$name)
                ->whereYear('buying_date',date('Y',strtotime('-'.$i.' years')))
                ->first()->amount;
                if($date == null){
                    $date = [$d];
                }else{
                    array_push($date,$d);
                }
                if($data == null){
                    $data = [$item];
                }else{
                    array_push($data,$item);
                }
            }
            $dateShow = $date;
            if($dataArray == null){
                $dataArray = [['name'=>$name,'data'=>$data]];
            }else{
                array_push($dataArray,['name'=>$name,'data'=>$data]);
            }
            }
            $showDetail= ['y'=>$dateShow,'data'=>$dataArray];
        }
        return view('admin.export.brand-dashboard', [
            "datas" => $showDetail
        ]);
    }
}
