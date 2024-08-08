
<table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 mt-2">
  <thead>
      <tr>
          <th class="text-center" style="min-width:37px;width:3%"></th>
          <th class="text-center" style="width:15%">{{__('dashboard.brand')}}</th>
          <th class="text-center" style="width:15%">{{__('dashboard.sku')}}</th>
          <th class="text-center" style="width:52%">{{__('dashboard.name')}}</th>
          <th class="text-center" style="width:15%">{{__('dashboard.buying-date')}}</th>
      </tr>
  </thead>
  <tbody id="_show_tbody">
    @foreach($data as $item)
    <tr class="tr-parent">
      <td><input type="checkbox" class="input-product-id" onchange="checkProduct({{$item->id}})" value="{{$item->id}}"></td>
      <td>{{$item->brand_name}}</td>
      <td>{{$item->sku}}</td>
      <td>{{$item->name}}</td>
      <td>{{date('d/m/Y',strtotime($item->buying_date))}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="d-flex justify-content-end">
  {!!$data->links()!!}
</div>