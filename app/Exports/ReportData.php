<?php

namespace App\Exports;

use App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ReportData implements FromQuery, WithMapping,WithHeadings, WithChunkReading,ShouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $brand,$start,$end;
    public function __construct($brand,$start,$end)
    {
        $this->brand = $brand;
        $this->start = $start;
        $this->end = $end;
    }
    public function query()
    {
        $brand = $this->brand;
        $start = $this->start;
        $end = $this->end;
        ini_set('memory_limit', '4G');
        return Product::query()->with(
                    'User.UserInfo.Province',
                    'User.UserInfo.District',
                    'User.UserInfo.SubDistrict',
                    'User.UserInfo.ProvinceSend',
                    'User.UserInfo.DistrictSend',
                    'User.UserInfo.SubDistrictSend',
                    'BrandModel.Brand'
                )
            ->select(
                "products.*"
            )->where('status', 'approve')
            ->whereHas('User',function($q){
                return $q->where('users.type','user');
            })
            ->when($brand !=='*all*',function($q)use($brand){
                return $q->whereHas('BrandModel.Brand',function($q)use($brand){
                    return $q->where('brands.id','like','%'.$brand.'%');
                });
            })
            ->when($start !== '*all*' && $end !== '*all*', function($q)use($start,$end){
                return $q->whereBetween('products.buying_date',[$start,$end]);
            })
            ->groupBy('products.id');
    }
    public function map($data): array
    {
        $userInfo = $data->User->UserInfo;
        if($userInfo->SubDistrict){
            return [
                $data->user_id,
                $userInfo->firstname,
                $userInfo->lastname,
                $data->User->phone,
                App::currentLocale() === "en" ?$data->BrandModel->Brand->name_en:$data->BrandModel->Brand->name_th,
                $data->BrandModel->sku,
                App::currentLocale() === "en" ?$data->BrandModel->name_en:$data->BrandModel->name_th,
                $data->BrandModel->month,
                $data->BrandModel->day,
                date('d/m/Y',strtotime($data->created_at)),
                $userInfo->address1." ".(App::currentLocale() === "en"? $userInfo->SubDistrict->name_en." sub-district, ".$userInfo->District->name_en." district, ".$userInfo->Province->name_en.", ".$userInfo->SubDistrict->zip_code:" ตำบล ".$userInfo->SubDistrict->name_th." อำเภอ ".$userInfo->District->name_th." จังหวัด ".$userInfo->Province->name_th." ".$userInfo->SubDistrict->zip_code),
                $userInfo->address2." ".(App::currentLocale() === "en"? $userInfo->SubDistrictSend->name_en." sub-district, ".$userInfo->DistrictSend->name_en." district, ".$userInfo->ProvinceSend->name_en.", ".$userInfo->SubDistrictSend->zip_code:" ตำบล ".$userInfo->SubDistrictSend->name_th." อำเภอ ".$userInfo->DistrictSend->name_th." จังหวัด ".$userInfo->ProvinceSend->name_th." ".$userInfo->SubDistrictSend->zip_code),
            ];
        }else{
            return [
                $data->user_id,
                $userInfo->firstname,
                $userInfo->lastname,
                $data->User->phone,
                App::currentLocale() === "en" ?$data->BrandModel->Brand->name_en:$data->BrandModel->Brand->name_th,
                $data->BrandModel->sku,
                App::currentLocale() === "en" ?$data->BrandModel->name_en:$data->BrandModel->name_th,
                $data->BrandModel->month,
                $data->BrandModel->day,
                date('d/m/Y',strtotime($data->created_at)),
                "",
                "",
            ];
        }
    }
    public function headings(): array
    {
        if(App::currentLocale() == "en"){
            return [
                "Customer ID",
                'Name',
                'Lastname',
                'Phone number',	
                'Brand name',	
                'Product code',	
                'product name',	
                'Product warranty (month)',
                'Additional product warranty (day)',
                'Buying date',
                'address1',    
                'address2'
            ];
        }else{
            return[
                'รหัสลูกค้า',
                'ชื่อ',
                'นามสกุล',
                'เบอร์โทรศัพท์',
                'ยี่ห้อสินค้า',
                'รหัสสินค้า',	
                'ชื่อสินค้า',	
                'การรับประกันสินค้า (เดือน)',
                'การรับประกันสินค้าเพิ่มเติม (วัน)',
                'วันที่ซื้อสินค้า',
                'ที่อยู่1',
                'ที่อยู่2'
            ];
        }
    }
    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size according to your needs
    }
}

