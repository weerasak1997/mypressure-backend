@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
@section('css')
<link href="{{asset('/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="/assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
<style>
  .can-click{
    cursor: pointer;
  }
  .btn-add-product{
    height: max-content;
  }
  .card {
    display:relative;
  }
  .status-warranty{
    position: absolute;
    left:0;
    width:2vw;
    height:100%;
    background-color:#5cb85c;
    border-radius: 0.25rem 0 0 0.25rem;
  }
  .status-process{
    position: absolute;
    left:0;
    width:2vw;
    height:100%;
    background-color:#ffc107;
    border-radius: 0.25rem 0 0 0.25rem;
  }
  .status-expired{
    position: absolute;
    left:0;
    width:2vw;
    height:100%;
    background-color:#d9534f;
    border-radius: 0.25rem 0 0 0.25rem;
  }
  .icon-btn{
    color: #000 !important;
  }
  .bxs-wrench{
    font-size:36px;
  }
  .select2-results__options{
      max-height:300px;
      overflow-y:auto;
  }
  .dropdown {
      position: relative;
      display: inline-block;
  }

  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #ffffff;
      width: 100%;
      max-height:300px;
      overflow: auto;
      border: 1px solid #ddd;
      z-index: 20;
  }

  .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
  }
  .show-dropdown{
    width:100%;
  }
  .dropdown a:hover {
      background-color: #ddd;
  }
  .is-invalid .select2-selection,
  .needs-validation~span>.select2-dropdown {
      border-color: red !important;
  }

  .custom-file-button input[type=file] {
    margin-left: -2px !important;
  }

  .custom-file-button input[type=file]::-webkit-file-upload-button {
    display: none;
  }

  .custom-file-button input[type=file]::file-selector-button {
    display: none;
  }

  .custom-file-button:hover label {
    background-color: #dde0e3;
    cursor: pointer;
  }
  .file-color {
    color: transparent !important;
  }
  .not-active{
    color:#909090;
  }
  .not-active:hover{
    color:#2b3042;
  }
  .input-search{
    min-width: 250px;
  }
  .image-show{
    max-width: 100%;
  }
  #_show_extra_pic{
    align-items:center;
  }
  .line-demo {
    width: 40px;
    height: 13px;
    margin-top:6px;
    display:inline-block !important;
    background-image: linear-gradient(90deg, #F4F4F4 0px, rgba(229, 229, 229, 0.8) 40px, #F4F4F4 80px);
    background-size: 600px;
    animation: shine-lines 2s infinite ease-out;
  }
  @keyframes shine-lines {
    0% {
      background-position: -100px;
    }
    40%, 100% {
      background-position: 140px;
    }
  }
</style>
@endsection
@section('content')
  @if (session('success'))
  <div class="alert alert-success" id="_success-alert">{{ session('success') }}</div>
  @elseif (session('error'))
  <div class="alert alert-danger" id="_error-alert">{{ session('error') }}</div>
  @endif
  <div class="card">
    <div class="card-body">
      <div class="my-list">
        <div>
          <h3>{{__('dashboard.my-productlist')}}</h3>
          <span><a href="javascript:void(0)" class="not-active" onclick="changeStatus('all')">{{__('dashboard.all')}}(<span class="line-demo" id="_all"></span>)</a>|<a href="javascript:void(0)" class="not-active" onclick="changeStatus('warranty')">{{__('dashboard.warranty')}}(<span class="line-demo" id="_intime"></span>)</a>|<a href="javascript:void(0)" class="not-active" onclick="changeStatus('expired')">{{__('dashboard.expired')}}(<span class="line-demo" id="_expire"></span>)</a></span>
        </div>
        <div class="d-flex">
          <div class="d-flex me-2">
            <div class="me-1">
              <input type="text" class="form-control input-search" id="_search" placeholder="{{__('dashboard.search')}}">
            </div>
            <div>
              <button class="btn btn-success" type="button" onclick="seachShow()"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <div class="d-flex">
            <a href="{{route('product.add.index')}}" class="btn btn-primary btn-add-product me-2" >{{__('dashboard.add')}}</a>
            <a href="{{route('product.extra')}}" class="btn btn-primary btn-add-product" >{{__('dashboard.extra-btn')}}</a>
          </div>
        </div>
      </div>
      <div class="my-list-phone ">
        <div>
          <h3>{{__('dashboard.my-productlist')}}</h3>
          <span><a href="javascript:void(0)" class="not-active" onclick="changeStatus('all')">{{__('dashboard.all')}}(<span class="line-demo" id="_all"></span>)</a>|<a href="javascript:void(0)" class="not-active" onclick="changeStatus('warranty')">{{__('dashboard.warranty')}}(<span class="line-demo" id="_intime"></span>)</a>|<a href="javascript:void(0)" class="not-active" onclick="changeStatus('expired')">{{__('dashboard.expired')}}(<span class="line-demo" id="_expire"></span>)</a></span>
        </div>
        <div class="show-de-flex">
          <div class="d-flex me-2">
            <div class="me-1">
              <input type="text" class="form-control input-search" id="_search" placeholder="{{__('dashboard.search')}}">
            </div>
            <div>
              <button class="btn btn-success" type="button" onclick="seachShow()"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <div class="d-flex button-margin">
            <a href="{{route('product.add.index')}}" class="btn btn-primary btn-add-product me-2" >{{__('dashboard.add')}}</a>
            <a href="{{route('product.extra')}}" class="btn btn-primary btn-add-product" >{{__('dashboard.extra-btn')}}</a>
          </div>
        </div>
      </div>
      <div id="_show_product">
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div
    id="_add_product"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('dashboard.add')}}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form id="_form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-3">
                <div class="d-flex flex-column">
                  <label for="_brand">{{__('dashboard.brand')}}</label>
                  <select id="_brand" name="brand" class="ajax-select form-control"></select>
                </div>
              </div>
              <div class="col-4">
                <div class="d-flex flex-column">
                  <label for="_sku">{{__('dashboard.sku')}}</label>
                  <select id="_sku" name="sku" class="ajax-select form-control"></select>
                </div>
              </div>
              <div class="col-5">
                <label for="_model">{{__('dashboard.model')}}</label>
                <input id="_model" type="text" class="form-control" disabled>
                <input id="_model_id" name="model" type="hidden" class="form-control">
              </div>
              <div class="col-6 mt-2">
                <label for="_branch">{{__('dashboard.branch')}}</label>
                <input id="_branch" name="branch" maxlength="255" type="text" class="form-control">
              </div>
              <div class="col-6 mt-2">
                <label for="_date">{{__('dashboard.date')}}</label>
                <input class="form-control" name="date" maxlength="255" type="date" value="" id="_date">
              </div>
              <div class="col-12 mt-2">
                <label for="_slip" >{{__('dashboard.slip')}}</label>
                <div class="input-group custom-file-button">
                  <label class="input-group-text" for="_slip">{{__('dashboard.choose_file')}}</label>
                  <input id="_slip" name="slip" class="form-control file-color" onchange="checkFileSize(this)" type="file" accept="image/png,image/jpeg,image/jpg"/>
                </div>
                <div class="d-none text-danger mt-1" id="_slip_max">{{__('dashboard.maximum')}}</div> 
              </div>
              <div class="col-12 mt-2">
                <label for="_add_extra">{{__('dashboard.add_extra')}}</label>
                <div class="input-group custom-file-button">
                  <label class="input-group-text" for="_add_extra">{{__('dashboard.choose_file')}}</label>
                  <input id="_add_extra" name="addExtra" class="form-control file-color" onchange="checkFileSize(this)" type="file" accept="image/png,image/jpeg,image/jpg"/>
                </div>
                <div class="d-none text-danger mt-1" id="_add_extra_max">{{__('dashboard.maximum')}}</div> 
                {{-- <input id="_add_extra" name="addExtra" class="form-control" id="formFileSm" type="file"/> --}}
              </div>
              <div class="d-flex justify-content-end mt-3">
                <button type="button" onclick="validation()" class="btn btn-primary">{{__('info.save')}}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div
    id="_show_file"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h5 class="modal-title">{{__('dashboard.add')}}</h5> --}}
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="text-center">{{__('dashboard.default-document')}}</div>
            <div class="col-12 d-flex justify-content-center">
              <img id="_show_main_pic" class="image-show" />
            </div>
            <div class="text-center mt-2" id="_show_extra_pic_image">{{__('dashboard.extra-document')}}</div>
            <div class="col-12 d-flex flex-column justify-content-center" id="_show_extra_pic">
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <form id="_form_repair" action="" method="post">
    @csrf
  </form>
@endsection
@section('script')
  <script src="/assets/libs/select2/select2.min.js"></script>
  <script src="{{asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      $.ajax('{{route("dashboard.show.load","all")}}').then((data)=>{
        $("#_all").removeClass('line-demo');
        $("#_all").empty().append(data);
      })
      $.ajax('{{route("dashboard.show.load","intime")}}').then((data)=>{
        $("#_intime").removeClass('line-demo');
        $("#_intime").empty().append(data);
      })
      $.ajax('{{route("dashboard.show.load","expire")}}').then((data)=>{
        $("#_expire").removeClass('line-demo');
        $("#_expire").empty().append(data);
      })
  });
    function showFile(image){
      image = JSON.parse(image);
      $('#_show_file').modal('show');
      $('#_show_main_pic').attr('src',image[0].replace('public','https://storage.googleapis.com/warranty-bill/public'))
      if(image.length>1){
        $('#_show_extra_pic_image').removeClass('d-none');
        let body= '';
        image.forEach((doc,key)=>{
          if(doc!=null && key>0){
            body +=`
              <div class="mt-2">
                <image class="image-show" src="${doc.replace('public','https://storage.googleapis.com/warranty-bill/public')}" />
              </div>
            `
          }
        })
        $('#_show_extra_pic').empty().append(body)
      }else{
        $('#_show_extra_pic_image').addClass('d-none');
        $('#_show_extra_pic').empty();
      }
    }
    async function confirmRepair(id){
      let data = await $.ajax('/ticket/check/status/end/'+id);
      if(data){
        window.location.href="/ticket/index/"+data.id;
      }else{
        Swal.fire({
          title: '{{__("dashboard.repair_title")}}',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '{{__("ticket.confirm")}}',
          cancelButtonText: '{{__("ticket.cancel")}}'
        }).then(async (result) => {
            if (result.isConfirmed) {
                $('#_form_repair').attr('action','/ticket/add/data/'+id);
                $('#_form_repair').submit();
            } else {
                $('#_modal_expose').modal('show');
            }
        })
      }
    }
    //file
    $('#_slip').on('change', function(file){
      $(file.target).removeClass('file-color');
      if($(file.target)[0].files.length ==0){
        $(file.target).addClass('file-color');
      }
    })
    $('#_add_extra').on('change', function(file){
      $(file.target).removeClass('file-color');
      if($(file.target)[0].files.length ==0){
        $(file.target).addClass('file-color');
      }
    })
    $("#_success-alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });
    $("#_error_alert_validate").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });
  </script>
  <script>
    let notClick = true;
    $(document).click(function() {
        $('#_show_sku').hide();
        if (!$('#_show_sku').val() && !notClick) {
            $('#_sku').val('');
            notClick = true;
        }
    })
    $('#_sku').select2({
        tags: true,
        matcher: 1,
        theme: 'bootstrap',
        ajax: {
            url: '{{route("brand.search.sku")}}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term, // search term
                    page: params.page,
                    brandId:$('#_brand').val(),
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: '{{__("product_dashboard.select-brand")}}',
        minimumInputLength: 1,
        templateResult: formatRepoSku,
        templateSelection: formatRepoSelectionSku,
        dropdownParent: $('#_add_product')
    }).on('select2:open', function(event) {
        // console.log(event);
        $('.select2-search__field').val(' ').trigger('input');
        $('.select2-search__field').val('');
        $('.select2-search__field')[0].onkeyup = (e) => {
            if (e.target.value === '') {
                $('.select2-search__field').val(' ').trigger('input');
                $('.select2-search__field').val('');
            }
        }
        // $('.select2-search__field').val(1);
        // prevselection = $(event.target).find(':selected');
        // $('select').val(null);
    }).on('select2:selecting', async function(e) {
        let data = e.params.args.data;
        if(!$('#_brand').val()){
          $('#_brand').empty();
          $('#_brand').append(`<option value="${data.brand.id}">${@if("{{App::currentLocale()}}" === "en") data.brand.name_en @else data.brand.name_th @endif}</option>`).val(data.brand.id);
          $('#_brand').trigger('change');
        }
        $('#_model_id').val(data.id);
        $('#_model').val(@if("{{App::currentLocale()}}" === "en") data.name_en @else data.name_th @endif);
    })
    function formatRepoSku(repo) {
        if (repo.loading) {
            return repo.text;
        }
        if (Object.keys(repo).length < 3) {
            return null;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta d-flex justify-content-between'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text( 
          repo.sku
        );
        return $container;
    }

    function formatRepoSelectionSku(repo) {
        return repo.sku || repo.text;
    }
    async function searchSKU(e){
      if ($(e).val()) {
          notClick = false;
          $('#_show_sku').val('');
          $('#_model').val('');
          $('#_model_id').val('');
          $('#_show_sku').show();
          let res = await $.ajax({
              url: '/brand/search/sku',
              data:{
                _token:'{{csrf_token()}}',
                sku:$(e).val(),
                brandId:$('#_brand').val(),
              },
              method: 'POST',
          })
          let data = '';
          res.forEach((doc) => {
              data += `<a data-value="${doc.sku}" href="javascript:void(0)" onclick='showProduct(${JSON.stringify(doc)})'>${doc.sku}</a>`;
          })
          data +='';
          $('#_show_sku').empty().append(data);
      } else {
          $('#_show_sku').hide();
      }
    }

    function showProduct(data) {
        $('#_model_id').val(data.id);
        $('#_model').val(data.name);
        @if("{{App::currentLocale()}}" === "en")
          $('#_model').val(data.name_en);
          if(!$('#_brand').val()){
            $('#_brand').append(`<option value="${data.brand.id}" selected>${data.brand.name_en}</option>`);
            $('#_brand').val(data.brand.id);
          }
        @else
          $('#_model').val(data.name_th);
          if(!$('#_brand').val()){
            $('#_brand').append(`<option value="${data.brand.id}" selected>${data.brand.name_th}</option>`);
            $('#_brand').val(data.brand.id);
          }
        @endif
        $('#_sku').val(data.sku);
        $('#_show_sku').hide();
        //codeFill(data);
        notClick = true;
    }
    function validation(){
      let valid = true;
      if($('#_brand').val()){
        $('#_brand').parent().find('span').removeClass('is-invalid');
      }else{
        valid = false;
        $('#_brand').parent().find('span').addClass('is-invalid');
      }
      if($('#_sku').val()){
        $('#_sku').removeClass('is-invalid');
      }else{
        valid = false;
        $('#_sku').addClass('is-invalid');
      }
      if($('#_branch').val()){
        $('#_branch').removeClass('is-invalid');
      }else{
        valid = false;
        $('#_branch').addClass('is-invalid');
      }
      if($('#_date').val()){
        $('#_date').removeClass('is-invalid');
      }else{
        valid = false;
        $('#_date').addClass('is-invalid');
      }
      $('#_slip_max').addClass('d-none');
      $('#_add_extra_max').addClass('d-none');
      if($('#_slip').val()){
        $('#_slip').removeClass('is-invalid');
      }else{
        valid = false;
        $('#_slip').addClass('is-invalid');
      }
      if(valid){
        $("#_form").attr('action','{{route("product.add.data")}}');
        $("#_form").submit();
      }
    }
    $('#_brand').select2({
        tags: true,
        matcher: 1,
        theme: 'bootstrap',
        ajax: {
            url: '/brand/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'เลือกยี่ห้อ...',
        minimumInputLength: 1,
        templateResult: formatRepoBrand,
        templateSelection: formatRepoSelectionBrand,
        dropdownParent: $('#_add_product')
    }).on('select2:open', function(event) {
        // console.log(event);
        $('.select2-search__field').val(' ').trigger('input');
        $('.select2-search__field').val('');
        $('.select2-search__field')[0].onkeyup = (e) => {
            if (e.target.value === '') {
                $('.select2-search__field').val(' ').trigger('input');
                $('.select2-search__field').val('');
            }
        }
        // $('.select2-search__field').val(1);
        // prevselection = $(event.target).find(':selected');
        // $('select').val(null);
    }).on('select2:selecting', async function(e) {
        $('#_sku').val(null);
    })
    function formatRepoBrand(repo) {
        if (repo.loading) {
            return repo.text;
        }
        if (Object.keys(repo).length < 3) {
            return null;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta d-flex justify-content-between'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text( 
          @if("{{App::currentLocale()}}" === "en")
            repo.name_en
          @else
            repo.name_th
          @endif
        );
        return $container;
    }

    function formatRepoSelectionBrand(repo) {
        return @if("{{App::currentLocale()}}" === "en") repo.name_en @else repo.name_th @endif  || repo.text;
    }
    async function generate(id){
        let data = await $.ajax({
          url:'/customer/generate',
          data:{
            'customer_id':id,
            '_token':"{{csrf_token()}}"
          },
          method:"POST"
        })
      $("#_link"+id).attr('type','text')
      $("#_link"+id).attr('value','http://127.0.0.1:8000/pdf/code?token='+data.token+'&ref='+data.ref);
    }
    let typeShow = '';
    async function changeStatus(type){
      let data = await $.ajax({
          url:'/dashboard/data/show/'+type,
      })
      typeShow = type;
      // let text = '';
      // var now = moment()
      // data.forEach((doc)=>{
      //   let expired = moment(doc.created_at).add('days', 1096+doc.extra_day) < now;
      //   text += `
      //     <div class="card mt-2 ps-4">
      //       <div class="${(doc.status == "approve"  && !expired )? 'status-warranty' :((doc.status == "process")? 'status-process' :((doc.status == "reject" || expired)? 'status-expired':''))}">
      //       </div>
      //       <div class="card-body">
      //         <h5 class="card-title">ID: ${doc.id}</h5>
      //         <div class="row">
      //           <div class="col-9">
      //             <div class="row">
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.brand')}}: @if(App::currentLocale() === "en")  ${doc.brand_model.brand.name_en} @else ${doc.brand_model.brand.name_th} @endif</p>
      //               </div>
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.model')}}: @if(App::currentLocale() === "en")  ${doc.brand_model.name_en} @else ${doc.brand_model.name_th} @endif</p>
      //               </div>
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.product_name')}} : @if(App::currentLocale() === "en")  ${doc.brand_model.brand.name_en+' '+doc.brand_model.name_en} @else ${doc.brand_model.brand.name_th+' '+doc.brand_model.name_en} @endif</p>
      //               </div>
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.warranty')}} : 36 months</p>
      //               </div>
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.start_date')}} : ${moment(doc.created_at).format("DD/MM/YYYY")}</p>
      //               </div>
      //               <div class="col-4">
      //                 <p class="card-text">{{__('dashboard.expired_date')}}: ${moment(doc.created_at).add('days', 1096+doc.extra_day).format("DD/MM/YYYY")}</p>
      //               </div>
      //               <div class="col-12">
      //                 <p class="card-text">{{__('dashboard.extra_warranty')}}: ${doc.extra_day?doc.extra_day+' days':' ไม่มี'} </p>
      //               </div>
      //             </div>
      //           </div>
      //           <div class="col-3">
      //             {{-- <div class="d-flex justify-content-end">
      //               <a href="javascript:void(0)" onclick="confirmRepair({{$product->id}})" class="icon-btn">
      //                 <i class="bx bxs-wrench">
      //                 </i>
      //               </a>
      //             </div> --}}
      //           </div>
      //         </div>
      //       </div>
      //     </div>
      //   `;
      // })
      $('#_show_product').empty().append(data);
    }
    changeStatus('all');
    $(document).on('click', '#_show_product .pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var href = $(this).attr('href').split('?page=')[0];
        var host = window.location.protocol + '//' + window.location.hostname;
        var url = href.split(host)[1];
        fetch_data(page, href);
    });
    async function fetch_data(page, href) {
        let res = await $.ajax({
            url: href + "?page=" + page,
        });
        $('#_show_product').empty().append(res);
    }
    function checkFileSize(e){
      if(e.files[0].size>2000000){
        $(e).val('');
        $(e).addClass('is-invalid');
        $('#'+$(e).attr('id')+'_max').removeClass('d-none');
      }else{
        $(e).removeClass('is-invalid');
        $('#'+$(e).attr('id')+'_max').addClass('d-none');
      }
    }
    async function seachShow(){
      let data = await $.ajax({
          url:'/dashboard/data/show/'+typeShow+'/'+$('#_search').val(),
      })
      $('#_show_product').empty().append(data);
    }
  </script>
@endsection
