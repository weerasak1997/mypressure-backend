@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="/assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    #datatable tbody tr {
        cursor: pointer;
    }
    .is-invalid .select2-selection,
    .needs-validation~span>.select2-dropdown {
        border-color: red !important;
    }
    .not-show-li{
      filter: grayscale(100%);
    }
    .is-invalid .select2-selection,
    .needs-validation~span>.select2-dropdown {
        border-color: red !important;
    }
    #datatable tbody tr td:not(:last-child){
      cursor: pointer;
    }
    #_show_image{
      text-align:center;
    }
    #_show_image_edit{
      text-align:center;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f6f6f6;
      /* min-width: 230px; */
      width: 100%;
      overflow: auto;
      border: 1px solid #ddd;
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {
      background-color: #ddd;
    }

    .validate {
      border-color: #df4759 !important;
    }

    .dz-edit-preview{
      text-align: center;
      display: flex;
      flex-direction:column;
    }
    .not-active {
    color: #909090;
  }

  .not-active:hover {
    color: #2b3042;
  }

  .path-not-active {
    color: #909090;
  }

  .path-not-active:hover {
    color: #2b3042;
  }

  .show-path {
    font-size: 12px;
  }

  .select2-results{
    max-height:300px !important;
    overflow-y:auto;
  }
  .max-width-show{
    max-width: 100%;
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
      <div class="show-path">
        <a href="{{route('dashboard')}}" class="path-not-active">{{__('path.main')}}</a>/{{__('admin_extra.additional-product-warranty')}}
      </div>
        <div class="d-flex justify-content-between">
            <h3>{{__('admin_extra.create_extra_product_warranty')}}</h3>
        </div>
        <form id="_form_add" action="" method="post">
          @csrf
          <div id="basic-example">
              <!-- Seller Details -->
              <h3>{{__('create_extra.product-code')}}</h3>
              <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div>
                                <label class="form-label">{{__('create_extra.product-code')}}</label>
                                {{-- <input class="form-control" type="text" placeholder="กรอกรหัสลูกค้า"> --}}
                                <select class="form-control" id="_product_id">
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="productId" id="_product_data">
                        <div class="col-lg-12 mt-4" id="_show_data_product">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 mt-2">
                                <thead>
                                    <tr>
                                      <th style="min-width:37px;width:3%"></th>
                                      <th style="width:15%">{{__('dashboard.brand')}}</th>
                                      <th style="width:15%">{{__('dashboard.sku')}}</th>
                                      <th style="width:52%">{{__('dashboard.name')}}</th>
                                      <th style="width:15%">{{__('dashboard.buying-date')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="_show_tbody">
                                </tbody>
                            </table>
                        </div>
                        <div class="d-none text-danger mt-2" id="_is_checked">{{__('admin_extra.select-minimum')}}</div>
                    </div>
              </section>

              <!-- Company Document -->
              <h3>{{__('create_extra.choose-reason')}}</h3>
              <section>
                  <div class="row">
                      <div class="col-xl-6 col-sm-6">
                          <div class="mt-4">
                              <h5 class="font-size-14 mb-4">{{__('create_extra.incorrect-document')}}</h5>
                              <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="document" id="_document" value="1" onclick="showOther(false)">
                                  <label class="form-check-label" for="_document">
                                    {{__('create_extra.documentation')}}
                                  </label>
                              </div>
                              <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="document" id="_packaging" value="2" onclick="showOther(false)">
                                  <label class="form-check-label" for="_packaging">
                                    {{__('create_extra.packaging')}}
                                  </label>
                              </div>
                              <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="document" id="_advertise" value="3"  onclick="showOther(false)">
                                  <label class="form-check-label" for="_advertise">
                                    {{__('create_extra.advertiser')}}
                                  </label>
                              </div>
                              <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="document" id="_other" value="4" onclick="showOther(true)">
                                  <label class="form-check-label" for="_other">
                                    {{__('create_extra.other')}}
                                  </label>
                                  <input class="form-control mt-3 d-none" id="_other_input" name="other" type="text" placeholder="ระบุเหตุผลอื่นๆ" id="example-text-input">
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-6 col-sm-6">
                          <h5 class="font-size-14 mt-4 mb-4">{{__('create_extra.condition')}}</h5>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="refer" id="_refer" onclick="showRefer()">
                              <label class="form-check-label" for="_refer">
                                {{__('create_extra.refer-fill')}}
                              </label>
                              <input class="form-control mt-3 d-none" name="referCode" id="_refer_input" type="text" placeholder="{{__('create_extra.refer-fill')}}" id="example-text-input">
                          </div>
                      </div>
                  </div>
              </section>

              <!-- Company Document -->
              <h3>{{__('create_extra.evidence')}}</h3>
              <section>
                  <div>
                    <div action="#" class="dropzone" id="dropzone-img-cover">
                      <div class="fallback">
                        <input name="file" type="file" multiple="multiple">
                      </div>
                      <div class="dz-message needsclick">
                        <i class="fas fa-image" style="font-size:40px"></i>
                        <h4>{{__('admin_extra.drop-image')}}</h4>
                      </div>
                    </div>
                    <div id="_show_image">
                    </div>
                    <input type="hidden" id="_image" name="image">
                  </div>
                  {{-- <div class="text-center mt-4">
                      <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                  </div> --}}
              </section>
              <!-- รายการขออนุมัติ -->
              <h3>{{__('create_extra.additional-warranty-time')}}</h3>
              <section>
                  <div>
                      <div class="row">
                          <div class="col-xl-12">
                              <div class="mt-4 mt-xl-0">
                                  <h4 class="font-size-14 mb-3">{{__('create_extra.additional-warranty-list')}}</h4>
                              </div>
                          </div>
                          <div class="col-xl-10 offset-xl-1">
                              <div class="mb-3 row">
                                  <label for="example-tel-input" class="col-md-2 col-form-label">{{__('create_extra.amount')}}</label>
                                  <div class="col-md-8">
                                      <input class="form-control" name="month" id="_month" onkeypress="validateNumber(event)" type="text">
                                  </div>
                                  <label for="example-tel-input" class="col-md-2 col-form-label">{{__('create_extra.month')}}</label>
                              </div>
                              <div class="mb-3 row">
                                  <label for="example-tel-input" class="col-md-2 col-form-label">{{__('create_extra.amount')}}</label>
                                  <div class="col-md-8">
                                      <input class="form-control" name="day" id="_day" onkeypress="validateNumber(event)" type="text">
                                  </div>
                                  <label for="example-tel-input" class="col-md-2 col-form-label">{{__('create_extra.day')}}</label>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>

              <!-- Confirm Details -->
              <h3>{{__('create_extra.confirm')}}</h3>
              <section>
                  <div class="row justify-content-center">
                      <div class="col-lg-6">
                          <div class="text-center">
                              <div class="mb-4">
                                  <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                              </div>
                              <div>
                                  <h5>{{__('create_extra.confirm')}}</h5>
                                  <p class="text-muted">{{__('create_extra.confirm-detail')}}</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>

          </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<!-- jquery step -->
<script src="{{ URL::asset('/assets/libs/jquery-steps/jquery-steps.min.js') }}"></script>
<script src="/assets/libs/select2/select2.min.js"></script>
<script src="{{asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- form wizard init -->
<script>
  let startIndex = 0;
  let id = null;
  $("#basic-example").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    startIndex: startIndex,
    onStepChanging: function (event, currentIndex, newIndex) {
      if(currentIndex < newIndex){
        if(currentIndex === 0){
          let valid = true;
          if($('#_product_data').val()){
            $('#_is_checked').addClass('d-none');
            $('#_product_id').parent().find('span').removeClass('is-invalid');
          }else{
            valid = false;
            $('#_is_checked').removeClass('d-none');
            $('#_product_id').parent().find('span').addClass('is-invalid');
          }
          if (valid) {
              return true;
          } else {
              return false; 
          }
        }else if(currentIndex === 1){
          let valid = true;
          let checked = false;
          $('input[name="document"]').each((index,doc)=>{
            if(doc.checked){
              checked = true;
            }
          })
          
          if($('#_refer')[0].checked){
            $("#basic-example-p-2").addClass('d-none');
            checked = true;
          }else{
            $("#basic-example-p-2").removeClass('d-none');
          }
          
          if(!checked){
            Swal.fire({
              title: 'ต้องเลือก 1 รายการ',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: '{{__("ticket.confirm")}}',
            }).then(async (result) => {
            })
            valid = false;
          }
          if($('#_other')[0].checked){
            if($('#_other_input').val()){
              $('#_other_input').removeClass('is-invalid');
            }else{
              valid = false;
              $('#_other_input').addClass('is-invalid');
            }
          }
          if($('#_refer')[0].checked){
            if($('#_refer_input').val()){
              $('#_refer_input').removeClass('is-invalid');
            }else{
              valid = false;
              $('#_refer_input').addClass('is-invalid');
            }
          }
          if (valid) {
            return true;
          } else {
            return false; 
          }
        }else if(currentIndex === 2){
          if($('#_refer')[0].checked){
            return true;
          }else{
            let valid = true;
            if($('#_show_image')[0].innerHTML.trim() !==''){
                $('#dropzone-img-cover').removeClass('validate');
                $('#dropzone-img-cover div i').removeClass('text-danger');
                $('#dropzone-img-cover div i').addClass('text-muted');
                $('#dropzone-img-cover div h4').removeClass('text-danger');
            }else{
                $('#dropzone-img-cover').addClass('validate');
                $('#dropzone-img-cover div i').addClass('text-danger');
                $('#dropzone-img-cover div i').removeClass('text-muted');
                $('#dropzone-img-cover div h4').addClass('text-danger');
                valid=false;
            }
            if (valid) {
                return true;
            } else {
                return false; 
            }
          }
        }else if(currentIndex === 3){
          let valid = true;
          if($('#_month').val()){
            $('#_month').removeClass('is-invalid');
          }else{
            valid = false;
            $('#_month').addClass('is-invalid');
          }
          if($('#_day').val()){
            $('#_day').removeClass('is-invalid');
          }else{
            valid = false;
            $('#_day').addClass('is-invalid');
          }
          if (valid) {
              return true;
          } else {
              return false; 
          }
        }else{
          return true
        }
      }else{
        return true;
      }
    },
    onStepChanged: function (event, currentIndex, priorIndex) { 
      if(currentIndex > priorIndex){
        if(currentIndex === 2){
          if($('#_refer')[0].checked){
            $("#basic-example").find(".actions ul li:nth-child(2) a").click();
          }
        }
      }else{
        if(currentIndex === 2){
          if($('#_refer')[0].checked){
            $("#basic-example").find(".actions ul li:nth-child(1) a").click();
          }
        }
      }
    },
    onFinishing: function (event, currentIndex) { 
      if(currentIndex===1){
        let valid =true;
        if($('#_refer_input').val()){
          $('#_refer_input').removeClass('is-invalid');
        }else{
          valid = false;
          $('#_refer_input').addClass('is-invalid');
        }
        if(valid){
          Swal.fire({
            title: '{{__("dashboard.confirm-action")}}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{__("ticket.confirm")}}',
            cancelButtonText: '{{__("ticket.cancel")}}'
          }).then(async (result) => {
            if (result.isConfirmed) {
              $("#_form_add").attr('action','{{route("product.extra.request")}}');
              $("#_form_add").submit();
            }
          })
        }else{
          return false;
        }
      }else if(currentIndex===4){
        Swal.fire({
          title: '{{__("dashboard.confirm-action")}}',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '{{__("ticket.confirm")}}',
          cancelButtonText: '{{__("ticket.cancel")}}'
        }).then(async (result) => {
          if (result.isConfirmed) {
            $("#_form_add").attr('action','{{route("product.extra.request")}}');
            $("#_form_add").submit();
          }
        })
      }
    }, 

  });
  $('#basic-example .actions ul li:nth-child(1) a')[0].innerHTML = '{{__("create_extra.previous")}}';
  $('#basic-example .actions ul li:nth-child(2) a')[0].innerHTML = '{{__("create_extra.next")}}';
  $('#basic-example .actions ul li:nth-child(3) a')[0].innerHTML = '{{__("create_extra.finish")}}';
</script>

<!-- Plugins js -->
<script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $(document).on('click','.tr-parent td:not(:first-child)',function(e){
      $(e.target).parent().find('input').trigger('click');
    })
  })
  $('#_product_id').select2({
      tags: true,
      matcher: 1,
      theme: 'bootstrap',
      ajax: {
          url: '{{route("product.search")}}',
          dataType: 'json',
          delay: 250,
          data: function(params) {
              return {
                  search: params.term, // search term
                  page: params.page,
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
      placeholder: "{{__('admin_extra.select-product')}}",
      minimumInputLength: 1,
      templateResult: formatRepoBrandSku,
      templateSelection: formatRepoSelectionBrandSku,
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
  }).on('select2:selecting',async function(event){
    let data = event.params.args.data;
    let res = await $.ajax({url:'{{route("product.search.sku")}}',method:'post',data:{
      _token:'{{csrf_token()}}',
      sku:data.sku,
    }})
    sku = data.sku;
    $('#_show_data_product').empty().append(res)
  })
  function checkProduct(id){
    event.stopPropagation();
    $('.input-product-id').each((index,doc)=>{
      if(doc.value == id){
        if(doc.checked===true){
          $('#_product_data').val(id);
          doc.checked = true;
        }else{
          $('#_product_data').val(null);
          doc.checked = false;
        }
      }else{
        doc.checked = false;
      }
      
    })
  }
  $(document).on('click', '#_show_data_product .pagination a', function(event) {
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
          method:'post',
          data:{
            _token:'{{csrf_token()}}',
            sku:sku,
          }
      });
      $('#_show_data_product').empty().append(res);
  }
  function formatRepoBrandSku(repo) {
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

  function formatRepoSelectionBrandSku(repo) {
      return repo.sku  || repo.text;
  }
  function showOther(type){
    $('#basic-example .steps ul li:nth-child(3)').removeClass('not-show-li')
    $('input[name="refer"]').each((index,doc)=>{
      doc.checked = false;
    })
    $('#_refer_input').addClass('d-none');
    if(type){
      $('#_other_input').removeClass('d-none');
    }else{
      $('#_other_input').addClass('d-none');
    }
  }
  function showRefer(){
    $('#_refer_input').removeClass('d-none');
    $('#_other_input').addClass('d-none');
    // $('#basic-xample div>ul li:not(nth-child(1),nth-child(2))').addClass('d-none');
    $('#basic-example .steps ul li:nth-child(3)').addClass('not-show-li')
    $('input[name="document"]').each((index,doc)=>{
      doc.checked = false;
    })
  }
  Dropzone.autoDiscover = false;

  $("#dropzone-img-cover").dropzone({
    paramName: "file",
    maxFiles: 1,
    maxFilesize: 100,
    timeout: 12000,
    addRemoveLinks: true,
    acceptedFiles: ".jpeg, .jpg, .png, .gif .svg .webp .webp",
    thumbnailWidth: "400",
    thumbnailHeight: "400",
    thumbnailMethod: 'contain',
    removedfile: function(file) {
      $('#dropzone-img-cover').show();
      $('#_show_image').hide();
      $('#_image').val('');
      var fileRef;
      return (fileRef = file.previewElement) != null ?
        fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },
    success: function(file, response) {},
    error: function(file, response) {
      var fileRef;
      return (fileRef = file.previewElement) != null ?
        fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },
    accept: function(file, done) {
      // if (file.size < 250000) {
        $('#dropzone-img-cover').hide();
        $('#_show_image').show();
        var reader = new FileReader();
        reader.onload = async function(event) {
          $('#_image').val(event.target.result);
          $('#_image_preview').attr('src', event.target.result)
          if($(file.previewElement).find('img').attr('src') == undefined){
            $(file.previewElement).find('img').attr('src',event.target.result);
            $(file.previewElement).find('img').addClass('max-width-show');
          }
        };
        reader.readAsDataURL(file);
        for (let i = 0; i < 5; i++) {
          file.previewElement.removeChild(file.previewElement.children[1]);
        }
        $('#_body').find('.dropzone').css('border-color', 'rgba(0,0,0,0.3)');
        $('#_body').find('.bxs-cloud-upload').removeClass('invalid');
        $('#_body').find('.dz-message').find('h4').css('color', 'rgba(0,0,0,0.3)');
        // file.previewElement.children[0].children[0].classList.add("image-show");
        $('#_show_image')[0].append(file.previewElement);
        $('#_show_image').find('.dz-image img').on('click', () => {
          // $('#_image_modal').modal('show');
        })
      // } else {
      //   Swal.fire({
      //     title: '{{__("setting.so-big")}}',
      //     text: '{{__("setting.as-less")}}',
      //     icon: 'warning',
      //     // showCancelButton: true,
      //     // confirmButtonColor: '#d33',
      //     // cancelButtonColor: '#3085d6',
      //     confirmButtonText: 'OK'
      //   })
      //   $('#dropzone-img-cover .dz-remove')[0].click();
      // }
    }
  })

  function validateNumber(evt) {
    var theEvent = evt || window.event;
    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
  }
  $("#_success-alert").delay(4000).slideUp(200, function() {
      $(this).alert('close');
  });
  $("#_error_alert_validate").delay(4000).slideUp(200, function() {
      $(this).alert('close');
  });
</script>
@endsection