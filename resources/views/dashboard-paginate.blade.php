@foreach($products as $product)
@php 
  extract($product->getExtra());
  $status='';
  if($product->additional_request == 1){
    $status= $product->status2;
  }else{
    $status= $product->status;
  }
  $process = $product->getExtraProcess();
  $expired = (date('Y-m-d',strtotime('+'.($product->BrandModel->day+$day).' days +'.($product->BrandModel->month+$month).' months '.$product->buying_date))) < date("Y-m-d");
  $isExtra = $product->AdditionalWarrantyProduct?count($product->AdditionalWarrantyProduct)>0:false;
@endphp
<div class="card mt-2 ps-4">
  <div class="@if(($status == "approve"||$status == "process"||$status == "super-process") && !$isExtra && !$expired ) status-warranty @elseif($isExtra && !$expired) status-process @elseif($status == "reject" || $expired) status-expired @endif">
  </div>
  <div class="card-body">
    <h5 class="card-title">ID: {{$product->id}}</h5>
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-md-3">
            <p class="card-text">{{__('dashboard.brand')}}: {{(App::currentLocale() === "en" ?  $product->BrandModel->Brand->name_en:$product->BrandModel->Brand->name_th )}}</p>
          </div>
          <div class="col-md-3">
            <p class="card-text">{{__('dashboard.product-code')}} : {{$product->BrandModel->sku }}</p>
          </div>
          <div class="col-md-6">
            <p class="card-text">{{__('dashboard.product_name')}} : {{(App::currentLocale() === "en" ?  $product->BrandModel->name_en:$product->BrandModel->name_th )}}</p>
          </div>
          <div class="col-md-3">
            <p class="card-text">{{__('dashboard.warranty')}} : {{$product->BrandModel->month||$product->BrandModel->day?(($product->BrandModel->month?$product->BrandModel->month:0).' '.(App::currentLocale()=='en'?'months':'เดือน').' '.($product->BrandModel->day?$product->BrandModel->day:0).' '.(App::currentLocale()=='en'?'day':'วัน')):' ไม่มี'}}</p>
          </div>
          <div class="col-md-3">
            <p class="card-text">{{__('dashboard.start_date')}} : {{date('d/m/Y',strtotime($product->buying_date))}}</p>
          </div>
          <div class="col-md-6">
            <p class="card-text">{{__('dashboard.expired_date')}}: {{$endDate}}</p>
          </div>
          <div class="col-md-12">
            <p class="card-text">{{__('dashboard.extra_warranty')}}: {{$product->extra_month||$product->extra_day||$day||$month?((($product->extra_month?$product->extra_month:0)+($month?$month:0)).' '.(App::currentLocale()=='en'?'months':'เดือน').' '.(($product->extra_day?$product->extra_day:0)+($day?$day:0)).' '.(App::currentLocale()=='en'?'day':'วัน')):($process['day']>0||$process['month']>0?($process['month'].' '.(App::currentLocale()=='en'?'months':'เดือน').' '.$process['day'].' '.(App::currentLocale()=='en'?'day':'วัน')):'ไม่มี')}} </p>
          </div>
          <div class="col-md-12">
            <button class="btn btn-primary btn-sm" onclick="showFile('{{json_encode($product->AllImage())}}')">{{__('dashboard.file')}}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
<div class="d-flex justify-content-end">
{!!$products->links()!!}
</div>