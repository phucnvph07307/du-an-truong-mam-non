@extends('layouts.main') @section('title', "Thiết lập năm học")
@section('style')
<style>
    .error {
        color: red;
    }
    #name-error,
    #StartDate-error,
    #EndDate-error {
        color: red;
    }
</style>
@endsection @section('content')
<div class="m-content">
    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-3">
            <!--begin:: Widgets/Announcements 1-->
            <div class="m-portlet m--bg-accent m-portlet--bordered-semi m-portlet--skin-dark m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Danh sách năm học
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <button class="btn btn-outline-secondary m-btn" type="button" onclick="checkNew()">
                            <i class="flaticon-add"></i>
                        </button>

                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true"
                        style="height: 200px; overflow: hidden;">
                        <div class="m-widget6">
                            <div class="m-widget6__body">
                                <div id="m_calendar_external_events" class="fc-unthemed">
                                    @forelse ($data as $item)

                                    <div onclick="getData(this)" data-name="{{ $item->name }}"
                                        data-start_date="{{ $item->start_date }}" data-end_date="{{ $item->end_date }}"
                                        data-type="{{ $item->type }}"
                                        data-route="{{ route('nam-hoc-chi-tiet',['id'=> $item->id]) }}"
                                        class="change_type m-nav__link fc-event fc-event-external fc-start m-fc-event--primary m--margin-bottom-15 ui-draggable ui-draggable-handle"
                                        data-color="m-fc-event--primary">
                                        <div class="fc-title">
                                            <div class="fc-content">
                                                {{ $item->name }}
                                                <span class="pull-right">
                                                    <i
                                                        class="check_lock fa {{ $item->type == 1 ? 'fa-lock-open' : 'fa-lock'}}"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    <span class="text-danger">Hãy tạo năm học mới</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="ps__rail-x" style="left: 0px; bottom: -1132px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 1132px; height: 200px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 160px; height: 40px;"></div>
                        </div>
                    </div>
                    <!--begin::Widget 7-->

                    <!--end::Widget 7-->
                </div>
            </div>

            <!--end:: Widgets/Announcements 1-->
        </div>
        <div class="col-xl-9">
            <!--begin:: Widgets/Blog-->

            <!--begin:: Widgets/Blog-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <a  id="btn_xep_lop_or_lich_su"
                                    href="@if (isset($data[0]) && $data[0]->id){{ route('nam-hoc-chi-tiet',['id' => $data[0]->id ]) }} @endif"
                                    class="btn {{ isset($data[0]) && $data[0]->type != 1 ? 'btn-warning' : 'btn-info'}} btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                    @if (isset($data[0]) && $data[0]->type != 1)
                                        <span>
                                            <i class="la la-archive"></i>
                                            <span>Lịch sử</span>
                                        </span>
                                    @else
                                        <span>
                                            <i class="la la-archive"></i>
                                            <span>Xếp lớp</span>
                                        </span>
                                    @endif
                                    
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="m-subheader__title m-subheader__title--separator">
                THÔNG TIN NĂM HỌC
                <span id="static_name" class="m--font-warning">{{ isset($data[0]) ? $data[0]->name : '' }}</span>
            </h3>
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-6">
                            <label class="col-form-label">Ngày bắt đầu năm học</label>
                            <input type="text" class="form-control m-input" readonly
                                value="{{ isset($data[0]) ? $data[0]->start_date : '' }}" id="static_start_date" />
                        </div>
                        <div class="col-6">
                            <label class="col-form-label">Ngày kết thúc năm học</label>
                            <input type="text" class="form-control m-input" readonly
                                value="{{ isset($data[0]) ? $data[0]->end_date : '' }}" id="static_end_date" />
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Blog-->
        </div>
    </div>
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        TẠO NĂM HỌC MỚI
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="m-form m-form--fit m-form--label-align-right" id="form-ceate"
                    action="{{ route('nam-hoc.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group">
                                <label>Ngày bắt đầu năm học:</label>
                                <input type="date"
                                    class="form-control m-input @error('start_date') is-invalid @enderror"
                                    name="start_date" id="StartDate" />
                                @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group m-form__group">
                                <label>Ngày kết thúc năm học:</label>
                                <input type="date" class="form-control m-input @error('end_date') is-invalid @enderror"
                                    name="end_date" id="EndDate" />
                                @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Cất
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Hủy bỏ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Section-->
</div>
<div id="loading" style="text-align: center;position: fixed;z-index: 500;width: 100vw;height: 100vh;background: #000;top: 0;left: 0;opacity:0.4;display:none;">
        <img src="{{ asset('images/loading1.gif')}}" style="width: 10%;height: auto;padding-top: 20%;">
</div>

@endsection @section('script')
<script type="text/javascript">
    var check_lock = '{{ $checkNew }}';
    function checkNew() {
        if (Number(check_lock) == 1) {
            $('#m_modal_1').modal('show');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Năm học hiện tại chưa đóng!',
                footer: '<p class="text-danger">Nhà trường cần đóng năm học hiện tại mới có thể khởi tạo năm học mới.</p>',
                showCancelButton: true,
                confirmButtonText: `Đóng luôn`
            }).then((result) => {
                if(result.value){
                    $('#loading').css('display','block');
                    axios.post('{{ route("nam-hoc.lock") }}', {
                        '_token': "{{ csrf_token() }}"
                    }).then(res =>{
                        $('#loading').css('display','none');
                        if(res.data.code == 200){
                            check_lock = 1;
                            $('#m_modal_1').modal('show');
                            $('.check_lock').removeClass('fa-lock-open').addClass('fa-lock');
                            $('.change_type').attr('data-type',2);
                        }else{
                            check_lock = 0;
                            Swal.fire({
                                icon: 'error',
                                title: 'Đóng thất bại',
                                text: 'Vui lòng kiểm tra kết nối'
                            })
                        }
                    }).catch(err => {
                            $('#loading').css('display','none');
                            check_lock = 0;
                            Swal.fire({
                                icon: 'error',
                                title: 'Đóng thất bại',
                                text: 'Vui lòng kiểm tra kết nối'
                            })
                            console.log(err);
                    })
                }
            })
        }
    }

    function getData(element) {
        $('#loading').css('display','block');
        setTimeout(function(){
            $('#loading').css('display','none');
        },700);
        let name = $(element).attr("data-name");
        let start_date = $(element).attr("data-start_date");
        let end_date = $(element).attr("data-end_date");
        let type = $(element).attr("data-type");
        let route = $(element).attr("data-route");
        
        $("#static_name").html(name);
        $("#static_start_date").val(start_date);
        $("#static_end_date").val(end_date);

        if(type != 1){
            $("#btn_xep_lop_or_lich_su").removeClass('invisible btn-info').addClass('btn-warning').attr('href',route)
            .html('<span><i class="la la-archive"></i><span>Lịch sử</span></span>');
        }else{
            $("#btn_xep_lop_or_lich_su").removeClass('invisible btn-warning').addClass('btn-info').attr('href',route)
            .html('<span><i class="la la-archive"></i><span>Xếp lớp</span></span>');
        }
    }

    $(document).ready(function () {
        jQuery.validator.addMethod("greaterThan", function (
            value,
            element,
            params
        ) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return (
                (isNaN(value) && isNaN($(params).val())) ||
                Number(value) > Number($(params).val())
            );
        });

        $("#form-ceate").validate({
            rules: {
                start_date: {
                    required: true
                },
                end_date: {
                    required: true,
                    greaterThan: "#StartDate"
                }
            },
            messages: {
                start_date: {
                    required: "Vui lòng nhập thời gian bắt đầu năm học"
                },
                end_date: {
                    required: "Vui lòng nhập thời gian kết thúc năm học",
                    greaterThan: "Vui lòng nhập thời gian kết thúc lớn hơn thời gian bắt đầu"
                }
            }
        });
    });
</script>

@if (count($errors->all()) > 0)
<script>
    $(window).on('load',function(){
        $('#m_modal_1').modal('show');
    });
</script>
@endif
@if (session('success'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Thêm khối thành công !",
        showConfirmButton: false,
        timer: 2000
    });

</script>
@endif @if (session('error'))
<script>
    Swal.fire({
        position: "center",
        icon: "error",
        title: "Thêm khối thất bại !",
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif @endsection
