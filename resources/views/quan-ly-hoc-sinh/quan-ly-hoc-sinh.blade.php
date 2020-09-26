@extends('layouts.main')
@section('title', "Quản lý học sinh")
@section('style')
<style>
    .m-table {
        font-size: 11px
    }

    .m-table th,
    .m-table td {
        padding: 0.22rem !important;
    }

    .search {
        padding: 0.35rem 0.8rem !important;
        height: 25px;
    }

    .style-button {
        padding: 0.45rem 1.15rem;
    }

    .m-table thead th {
        border: 1px solid #f4f5f8 !important;
    }

    th[rowspan='2'] {
        text-align: center;
        line-height: 50px;
    }

    .btn {
        font-family: Arial, Helvetica, sans-serif
    }

    .scoll-table {
        height: 440px;
        overflow: auto;
    }
    .bottom{
        position: fixed;
        bottom: 50px;
    }
    table.dataTable thead td {
    border-bottom: 1px solid #d1cccc;
}
#table-hoc-sinh_wrapper>.row:first-child{
    display: none;
}
.danh-sach-khoi-lop .m-accordion__item-title, .m-accordion__item-mode, .m-dropdown__content ul li span{
    color: black;
    font-size: 12px !important;
}
.danh-sach-khoi-lop .m-accordion__item{
    color: black;

    border-bottom: 1px solid #eee5e5 !important;
margin-bottom: 0rem !important
}
.m-accordion__item-head .la-plus{
    font-size: 20px;
    font-weight: bold;
    color: #19be19;
}

.m-accordion .m-accordion__item .m-accordion__item-head{
         padding: 0.5rem 1rem;
}
.collapsed{
    position: relative;
}
.la-ellipsis-v:hover .dropdown__wrapper{
    display: block !important;    
}
.m-nav .m-nav__item > .m-nav__link .m-nav__link-text{
    width: 96% !important;
}
.m-accordion .m-accordion__item{
    overflow: auto !important;
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="m-content">
    <div class="m-portlet">
        <div class="m-portlet__body row ">
            <div class="col-md-3 danh-sach-khoi-lop">
                <div class="m-portlet m-portlet--full-height">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                   Năm học: 2020-2021
                                </h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="m-portlet__body"> --}}

                        <!--begin::Section-->
                        <div class="m-accordion m-accordion--default m-accordion--solid m-accordion--section  m-accordion--toggle-arrow" id="m_accordion_7" role="tablist">

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_7_item_1_head" data-toggle="collapse" href="#m_accordion_7_item_1_body" aria-expanded="false">
                                    <span class="m-accordion__item-mode "></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="m-accordion__item-title">Khối cành (2 tuổi)</span>  
                                    <i class="la la-plus"></i>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_7_item_1_body" role="tabpanel" aria-labelledby="m_accordion_7_item_1_head" >
                                    <div class="m-accordion__item-content">
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item pl-4"  style="cursor: pointer">
                                                                <span href="" class="m-nav__link">
                                                                    <span class="m-nav__link-text">Lớp Hoa lý 1 (40)</span>
                                                                    <div class="dropdown">
                                                                    <i style="cursor: pointer;font-size: 25px;" class="la la-ellipsis-v" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                      </div>
                                                                    </div>
                
                                                                </span>
                                                            </li>
                                                            <li class="m-nav__item pl-4" style="cursor: pointer">
                                                                <span href="" class="m-nav__link">
                                                               
                                                                    <span class="m-nav__link-text">Lớp Hoa lý 1 (40)</span>
                                                                    <i style="cursor: pointer;font-size: 25px;" class="la la-ellipsis-v"></i>

                                                                </span>
                                                            </li>
                                                            <li class="m-nav__item pl-4" style="cursor: pointer">
                                                                <span href="" class="m-nav__link">                             
                                                                    <span class="m-nav__link-text">Lớp Hoa lý 1 (40)</span>
                                                                    <i style="cursor: pointer;font-size: 25px;" class="la la-ellipsis-v"></i>
                                                                </span>
                                                            </li>
                                                        </ul>

                                                        <!--end::Nav-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_7_item_2_head" data-toggle="collapse" href="#m_accordion_7_item_2_body" aria-expanded="    false">
                                    <span class="m-accordion__item-mode"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="m-accordion__item-title">Khối lá (3 tuổi)</span>
                                    <i class="la la-plus"></i>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_7_item_2_body" role="tabpanel" aria-labelledby="m_accordion_7_item_2_head" >
                                    <div class="m-accordion__item-content">
                                      
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_7_item_3_head" data-toggle="collapse" href="#m_accordion_7_item_3_body" aria-expanded="    false">
                                    <span class="m-accordion__item-mode"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="m-accordion__item-title">Khối hoa (4 tuổi)</span>
                                    <i class="la la-plus"></i>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_7_item_3_body" role="tabpanel" aria-labelledby="m_accordion_7_item_3_head" >
                                    <div class="m-accordion__item-content">
                                       
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->
                        </div>

                        <!--end::Section-->
                    {{-- </div> --}}
                </div>
            </div>
            <div class="col-md-9 table-responsive scoll-table">
                <table id="table-hoc-sinh" class="table table-striped table-bordered m-table">
                    <thead >
                        <tr>
                            <th style="width: 5%;"><input type="checkbox" id="" onclick="checkAll(this)"></th>
                            <th style="width: 10%;">Stt</th>
                            <th style="width: 15%;">Mã học sinh</th>
                            <th style="width: 20%;">Họ tên</th>
                            <th style="width: 15%;">Ngày sinh</th>
                            <th style="width: 15%;">Giới tính</th>
                            <th >Chức năng</th>
                        </tr>
                    </thead>
                    <thead class="filter">
                        <tr>
                            <td scope="row"><input class="form-control search m-input  " type="hidden"></td>
                            <td scope="row"><input class="form-control search m-input " type="hidden"></td>
                            <td scope="row"><input class="form-control search m-input search-mahs" type="text"></td>
                            <td scope="row"><input class="form-control search m-input search-ten" type="text"></td>
                            <td scope="row"><input class="form-control search m-input search-ngaysinh" type="text"></td>
                            <td scope="row">
                                <select class="form-control search m-input search-gioitinh m-input--square" id="exampleSelect1">
                                    <option value="">Chọn</option>
                                    <option>Nam</option>
                                    <option>Nữ</option>
                                </select>
                            </td>

                            <td scope="row"><input class="search8" style="width: 70px;" type="hidden"></td>
                            {{-- <td scope="row"><input class="search9" style="width: 70px;" type="text"></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($hocsinh)>0)
                        @php
                        $i = 1;
                        @endphp
                        @endif
                        @foreach ($hocsinh as $item)
                        <tr>
                            <th><input class="checkbox" type="checkbox" id=""></th>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$item->ma_hoc_sinh}}</td>
                            <td>{{$item->ten}}</td>
                            <td>{{$item->ngay_sinh}}</td>
                            <td>{{ config('common.gioi_tinh')[$item->gioi_tinh] }}</td>
                            <td><a class="btn btn-secondary style-button"
                                    href="{{route('quan-ly-hoc-sinh-edit',['id'=>1])}}">Cập nhật</a>
                                <a class="btn btn-secondary style-button"
                                    href="{{route('quan-ly-hoc-sinh-edit',['id'=>1])}}">Xóa</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready( function () {
        var dtable= $('#table-hoc-sinh').DataTable( {
        'paging': false,
        "aoColumnDefs": [
             { "bSortable": false, "aTargets": [ 0, 6 ] }, 
         ]
         }
    );
        $('.search-mahs').on('keyup change', function() {
        dtable
        .column(2).search(this.value)
        .draw();
        });
    
        $('.search-ten').on('keyup change', function() {
        dtable
        .column(3).search(this.value)
        .draw();
        });
        
        $('.search-gioitinh').on('change', function() {
        dtable
        .column(5).search(this.value)
        .draw();    
        });

        $('.search-ngaysinh').on('keyup change', function() {
        dtable
        .column(4).search(this.value)
        .draw();
        });
    });

    
</script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 

<script >
    const checkAll = (e) => {
    $(e).parents('table').find('.checkbox').not(e).prop('checked', e.checked);
};
</script>
@endsection