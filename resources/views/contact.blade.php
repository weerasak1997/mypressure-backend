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
      <div class="d-flex justify-content-between">
        <div>
          <h3>{{__('sidebar.contact')}}</h3>
        </div>
      </div>
      <div class="col-sm-12">
        <div>{{__('sidebar.contact-address')}}</div>
        <div>{{__('sidebar.contact-phone')}}</div>
        <div>{{__('sidebar.contact-line')}}</div>
        <div>{{__('sidebar.contact-time')}}</div>
      </div>
      <div class="d-flex justify-content-center">
        <img src="/images/contact/qr.jpg">
      </div>
    </div>
  </div>
  <!-- Modal -->
@endsection
@section('script')
  
  <script src="/assets/libs/select2/select2.min.js"></script>
  <script src="{{asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection
