@extends('layouts.main') @section('title', "Quản lý khoản thu")
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    .m-widget4__item {
        cursor: pointer;
    }

    .title_lap_dot_thu {
        background-color: #38a738;
        padding: 10px 80px;
        cursor: pointer;
    }

    .title_lap_dot_thu>h3 {
        color: white !important
    }

    .bat_buoc {
        color: red
    }

    .danh_sach_khoan_thu {
        height: 400px !important;
        overflow: auto;
    }

    .ten_khoi {
        color: rgb(25, 0, 255);
        font-weight: bold !important
    }

    thead th {
        font-weight: bold !important
    }
</style>
@endsection
@section('content')
<div class="m-content">
    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-12">

            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Quản lý khoản thu
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="row">
                            <div class="col-xl-3">

                                <!--begin:: Widgets/Download Files-->
                                <div class="m-portlet m-portlet--full-height ">
                                    <div class="m-portlet__head justify-content-center">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title title_lap_dot_thu" data-toggle="modal"
                                                data-target="#modal_tao_dot_thu">
                                                <h3 class="m-portlet__head-text">
                                                    Lập đợt thu
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">

                                        <!--begin::m-widget4-->
                                        <div class="m-widget4">
                                            @foreach ($dot_thu as $key => $item)
                                            <a href="{{route('quan-ly-dot-thu-index',['id'=>$item->id])}}">
                                                <div class="m-widget4__item p-2"
                                                 @if ($key==0)
                                                    style="background-color: #d9edda" @endif>

                                                    <div class="m-widget4__img m-widget4__img--icon">
                                                        <i class="flaticon-event-calendar-symbol"></i>
                                                    </div>
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__text">
                                                            Tháng {{$item->thang_thu}}/{{$item->nam_thu}}
                                                            ({{count($item->ChiTietDotThuTien)}} đợt)
                                                        </span>
                                                    </div>

                                                </div>
                                            </a>
                                            @endforeach

                                        </div>

                                        <!--end::Widget 9-->
                                    </div>
                                </div>

                                <!--end:: Widgets/Download Files-->
                            </div>
                            {{-- @if (count($data_dot_thu)>0){ --}}

                            @if ($data_dot_thu!=null)
                            <div class="col-xl-9">
                                <div class="m-portlet">
                                    <div class="m-portlet__head d-flex justify-content-between">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title ">
                                                <div class="m-portlet__head-text">
                                                    Tháng 03/2020
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title ">
                                                <div class="m-portlet__head-text">
                                                    <a href="" type="button" id="xem-chi-tiet"
                                                        class="btn btn-success ">Xem chi tiết</a>

                                                    {{-- <button type="button" class="btn btn-light"><i
                                                            style="font-size: 22px" class="la la-print"></i></button> --}}
                                                    <div type="button" id="xem-chi-tiet" data-toggle="modal"
                                                        data-target="#thong_bao_theo_khoi"
                                                        class="btn btn-success ml-2 ">Gửi thông báo khối</div>
                                                    <button type="button" class="btn btn-light  "><i
                                                            class="flaticon-delete"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- modal gửi thông báo theo khối --}}
                                    <div class="modal fade" id="thong_bao_theo_khoi" role="dialog">
                                        <div class="modal-dialog modal-lg">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Gửi thông báo</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="" id="form_gui_thong_bao_theo_khoi" method="post">
                                                    <div class="modal-body">
                                                        <div class="form-group m-form__group">
                                                            <label for="exampleInputEmail1">Chọn khối <span
                                                                    class="bat_buoc">*</span></label>
                                                            <select name="id_khoi" class="form-control m-input m-input--square"
                                                                id="exampleSelect1">
                                                                @foreach ($nam_hoc_moi->Khoi as $item)
                                                                <option value="{{$item->id}}">{{$item->ten_khoi}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group m-form__group">
                                                            <label for="exampleInputEmail1">Chọn đợt thu <span
                                                                    class="bat_buoc">*</span></label>
                                                            <select name="dot_thu" class="form-control m-input m-input--square"
                                                                id="exampleSelect1">
                                                                @if ($data_dot_thu!=null)
                                                                @foreach ($data_dot_thu->ChiTietDotThuTien as
                                                                $chi_tiet_dot)
                                                                <option value="{{$chi_tiet_dot->id}}">
                                                                    {{$chi_tiet_dot->ten_dot_thu}}</option>
                                                                @endforeach
                                                            </select>
                                                                @endif
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="exampleInputEmail1">Thông báo thu tiền <span
                                                                        class="bat_buoc">*</span></label>
                                                                <select name="trang_thai_thong_bao" class="form-control m-input m-input--square"
                                                                    id="exampleSelect1">
                                                                    <option value="1">Thông báo thu tiền</option>
                                                                    <option value="2">Thông báo hủy thu tiền</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="exampleInputEmail1">Dư kiến thu từ ngày
                                                                    <span class="bat_buoc">*</span></label>
                                                                <input name="ngay_bat_dau" type="date" class="form-control m-input"
                                                                    id="exampleInputPassword1" placeholder="Password">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="exampleInputEmail1">Đến ngày <span
                                                                        class="bat_buoc">*</span></label>
                                                                <input name="ngay_ket_thuc" type="date" class="form-control m-input"
                                                                    id="exampleInputPassword1" placeholder="Password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Đóng</button>
                                                        <button type="button" onclick="GuiThongBaoTheoKhoi()"
                                                            class="btn btn-primary">Gửi thông báo</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- end thông báo theo khối--}}

                                    <!--begin::Section-->
                                    <div class="m-section__content">
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <!--begin:: Widgets/Download Files-->
                                                <div class="m-portlet m-portlet--full-height ">
                                                    <div class="m-portlet__body danh_sach_khoan_thu">

                                                        <!--begin::m-widget4-->

                                                        <div class="m-form__group form-group">
                                                            <label>Phạm vi</label>

                                                            <div class="m-radio-list">
                                                                <label class="m-radio m-radio--state-success">
                                                                    <input type="radio" onclick="chiTietHocPhiKhoi(0)"
                                                                        checked name="example_2" value="0">
                                                                    Tất cả
                                                                    <span></span>
                                                                </label>
                                                                @foreach ($nam_hoc_moi->Khoi as $chi_tiet_khoi)
                                                                <label class="m-radio m-radio--state-success">
                                                                    <input
                                                                        onclick="chiTietHocPhiKhoi({{$chi_tiet_khoi->id}})"
                                                                        type="radio" name="example_2"
                                                                        value="{{$chi_tiet_khoi->id}}">
                                                                    {{$chi_tiet_khoi->ten_khoi}}
                                                                    <span></span>
                                                                </label>
                                                                @endforeach

                                                            </div>
                                                        </div>

                                                        <div class="m-form__group form-group">
                                                            @if ($data_dot_thu!=null)
                                                            @foreach ($data_dot_thu->ChiTietDotThuTien as $chi_tiet_dot)
                                                            <label class="pt-3 pb-2">Khoản thu
                                                                {{$chi_tiet_dot->ten_dot_thu}}</label>
                                                            <div class="m-checkbox-list">
                                                                @foreach ($chi_tiet_dot->KhoanThu as
                                                                $khoan_thu_chi_tiet)
                                                                <label class="m-checkbox m-checkbox--success">
                                                                    <input checked type="checkbox">
                                                                    {{$khoan_thu_chi_tiet->ten_khoan_thu}}
                                                                    <span></span>
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                            @endforeach
                                                            @endif

                                                        </div>



                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>

                                                <!--end:: Widgets/Download Files-->
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="m-portlet m-portlet--full-height ">
                                                    <div class="m-portlet__body">

                                                        <!--begin::m-widget4-->

                                                        <table
                                                            class="table table-striped m-table m-table--head-bg-success">
                                                            <thead>
                                                                <tr>
                                                                    <th>Khối lớp</th>
                                                                    <th>Số thu</th>
                                                                    <th>Số đã thu</th>
                                                                    <th>Số còn phải thu</th>
                                                                    <th>Thông báo</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="danh_sach_tien_theo_khoi">
                                                                @foreach ($danh_sach_thu_tien_theo_khoi as
                                                                $danh_sach_khoi_thu)
                                                                <tr>
                                                                    <th class="ten_khoi" scope="row">
                                                                        {{$danh_sach_khoi_thu->ten_khoi}}</th>
                                                                    <td>{{number_format($danh_sach_khoi_thu->tong_tien_phai_dong)}}
                                                                    </td>
                                                                    <td>{{number_format($danh_sach_khoi_thu->so_da_thu)}}
                                                                    </td>
                                                                    <td>{{number_format($danh_sach_khoi_thu->con_phai_thu)}}
                                                                    </td>
                                                                    <td>{{$danh_sach_khoi_thu->so_luong_da_thong_bao}}/{{$danh_sach_khoi_thu->so_luong_chua_thong_bao}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <th class="ten_khoi" scope="row">Tổng Số</th>
                                                                    <td>{{number_format($tong_tien_toan_bo['tong_tien_phai_dong'])}}
                                                                    </td>
                                                                    <td>{{number_format($tong_tien_toan_bo['so_da_thu'])}}
                                                                    </td>
                                                                    <td>{{number_format($tong_tien_toan_bo['con_phai_thu'])}}
                                                                    </td>
                                                                    <td>{{$tong_tien_toan_bo['so_luong_da_thong_bao']}}/{{$tong_tien_toan_bo['so_luong_chua_thong_bao']}}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>



                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!--end::Section-->
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- }
                                
                        @endif --}}
                        </div>
                    </div>

                    <!--end::Section-->
                </div>
            </div>

            <!--end::Portlet-->
        </div>
    </div>
    <!--End::Section-->
</div>

{{-- start modal tạo đợt mới --}}
<div class="modal fade" id="modal_tao_dot_thu" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Lập đợt thu
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">

                        <div class="form-group m-form__group">
                            <label for="">Tên đợt thu <span class="bat_buoc">*</span></label>
                            <input type="text" id="ten_dot_thu" class="form-control m-input m-input--square"
                                placeholder="Tên đợt thu">
                        </div>
                        <div class="form-group m-form__group">
                            <label for="exampleInputPassword1">
                                Chọn tháng
                                <span>*</span></label>
                            <select style="width: 100%" name="thoi_gian_thu" class="form-control m-input"
                                id="thoi_gian_thu">
                                @foreach ($thang_trong_nam as $thang_nam)
                                <option {{$thang_nam}} value="{{$thang_nam}}">{{$thang_nam}}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <!--begin::Section-->
                    <div class="m-section">
                        <span class="m-section__sub">
                            Danh sách các khoản cần thu <span class="bat_buoc">*</span>
                        </span>
                        <div class="m-section__content">
                            <table class="table table-striped m-table m-table--head-bg-brand">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="checkAll(this)" name="" id=""></th>
                                        <th>Khoản thu</th>
                                        <th>Số tiền (VNĐ)</th>
                                        <th>Đơn vị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($khoan_thu as $item)
                                    <tr>
                                        <th scope="row"><input type="checkbox" class="checkbox" value="{{$item->id}}"
                                                name="" id=""></th>
                                        <td>{{$item->ten_khoan_thu}}</td>
                                        <td>{{number_format($item->muc_thu)}}</td>
                                        <td>{{config('common.don_vi_tinh')[$item->don_vi_tinh]}}</td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--end::Section-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" onclick="lapDotThu()" class="btn btn-primary">Đồng ý</button>
                </div>

                <!--end::Form-->
            </div>
        </div>

    </div>
</div>
{{-- end modal tạo đợt mới --}}




@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    const url_tao_dot_thu = "{{route('quan-ly-dot-thu-store')}}";
    const url_tong_tien_thu_theo_khoi = "{{route('get-tong-tien-thu-theo-khoi')}}";
    var url_chi_tiet_dot_thu_theo_khoi_fake = "{{route('get-chi-tiet-dot-thu',['id','khoi'])}}";
    var url_gui_thong_bao_theo_khoi = "{{route('gui-thong-bao-theo-khoi')}}";

    
    $(document).ready( function () {

        $("body").addClass('m-aside-left--minimize m-brand--minimize')
    });
    const checkAll = (e) => {
        $(e).parents('table').find('.checkbox').not(e).prop('checked', e.checked);
    };

    const lapDotThu = () =>{
        let element_add = document.querySelectorAll('.checkbox')
            let danh_sach_khoan_thu_cua_dot =  []
            element_add.forEach(element => {
                if($(element).prop('checked')){
                    danh_sach_khoan_thu_cua_dot.push($(element).val());
                }
            });
        axios.post(url_tao_dot_thu,{
            'ten_dot_thu' : $('#ten_dot_thu').val(),
            'thoi_gian_thu' : $('#thoi_gian_thu').val(),
            'danh_sach_khoan_thu_cua_dot' : danh_sach_khoan_thu_cua_dot
        })
            .then(function (response) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Thêm mới đợt thu thành công!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(
                    ()=> location.reload()
                    )
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });  
    };
    const chiTietHocPhiKhoi = (id)=>{
            axios.post(url_tong_tien_thu_theo_khoi,{
                'id_khoi': id,
                'id_dot_thu':{{$id}}
            })
            .then(function (response) {
                var html_data_show=''
                console.log(response.data)
                response.data.danh_sach_show.forEach(element => {
                    html_data_show += `
                    <tr>
                        <th class="ten_khoi" scope="row">${element.ten_khoi}</th>
                        <td>${element.tong_tien_phai_dong.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${element.so_da_thu.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${element.con_phai_thu.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${element.so_luong_da_thong_bao}/${element.so_luong_chua_thong_bao}</td>
                    </tr>  
                    `
                });
                html_data_show+=`
                <tr>
                        <th class="ten_khoi" scope="row">Tổng số</th>
                        <td>${response.data.tong_quat.tong_tien_phai_dong.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${response.data.tong_quat.so_da_thu.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${response.data.tong_quat.con_phai_thu.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}</td>
                        <td>${response.data.tong_quat.so_luong_da_thong_bao}/${response.data.tong_quat.so_luong_chua_thong_bao}</td>
                </tr>  
                `

                $('.danh_sach_tien_theo_khoi').html(html_data_show)
                var url_chi_tiet_dot_thu_theo_khoi = url_chi_tiet_dot_thu_theo_khoi_fake.replace('id',{{$id}}).replace('khoi',id);
                $('#xem-chi-tiet').attr('href',url_chi_tiet_dot_thu_theo_khoi)
                

            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            }); 
    };

    const GuiThongBaoTheoKhoi = () =>{
        let myForm = document.getElementById('form_gui_thong_bao_theo_khoi');
        let formData = new FormData(myForm);
        axios.post(url_gui_thong_bao_theo_khoi,formData)
            .then(function (response) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Gửi thông báo thành công!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(
                    ()=> location.reload()
                    )
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });  
    };
       
</script>
@endsection