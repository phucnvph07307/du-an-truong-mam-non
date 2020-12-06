<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuanLyKhoanThuRepository;
use App\Repositories\QuanLyDotThuRepository;
use App\Repositories\NamHocRepository;
use App\Repositories\DiemDanhDenRepository;
use App\Repositories\DanhSachThuTienRepository;
use App\Repositories\ChinhSachCuaHocSinhRepository;
use App\Repositories\PhamViThuRepository;
use App\Repositories\NoiDungThongBaoRepository;

use App\Models\ChiTietDongTienHocSinh;
use App\Repositories\QuanLyChiTietDotThuRepository;
use App\Repositories\DoiTuongChinhSachRepository;
use App\Repositories\KhoiRepository;
use Illuminate\Support\Facades\Auth;
use App\Jobs\jobThongBaoToiHocSinh;
use App\Repositories\NotificationRepository;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class QuanLyDotThuController extends Controller
{
    protected $QuanLyKhoanThuRepository;
    protected $QuanLyDotThuRepository;
    protected $NamHocRepository;
    protected $DiemDanhDenRepository;
    protected $DanhSachThuTienRepository;
    protected $QuanLyChiTietDotThuRepository;
    protected $DoiTuongChinhSachRepository;
    protected $ChinhSachCuaHocSinhRepository;
    protected $PhamViThuRepository;
    protected $KhoiRepository;
    protected $NoiDungThongBaoRepository;
    protected $NotificationRepository;

    private $tong_tien_phai_dong = 0;
    private $danh_sach_chi_tiet_khoan_thu = [];
    public function __construct(
        QuanLyKhoanThuRepository $QuanLyKhoanThuRepository,
        QuanLyDotThuRepository $QuanLyDotThuRepository,
        NamHocRepository $NamHocRepository,
        DiemDanhDenRepository $DiemDanhDenRepository,
        DanhSachThuTienRepository $DanhSachThuTienRepository,
        QuanLyChiTietDotThuRepository $QuanLyChiTietDotThuRepository,
        DoiTuongChinhSachRepository $DoiTuongChinhSachRepository,
        ChinhSachCuaHocSinhRepository $ChinhSachCuaHocSinhRepository,
        PhamViThuRepository $PhamViThuRepository,
        KhoiRepository $KhoiRepository,
        NoiDungThongBaoRepository $NoiDungThongBaoRepository,
        NotificationRepository $NotificationRepository
    ) {
        $this->QuanLyKhoanThuRepository = $QuanLyKhoanThuRepository;
        $this->QuanLyDotThuRepository = $QuanLyDotThuRepository;
        $this->NamHocRepository = $NamHocRepository;
        $this->DiemDanhDenRepository = $DiemDanhDenRepository;
        $this->DanhSachThuTienRepository = $DanhSachThuTienRepository;
        $this->QuanLyChiTietDotThuRepository = $QuanLyChiTietDotThuRepository;
        $this->DoiTuongChinhSachRepository = $DoiTuongChinhSachRepository;
        $this->ChinhSachCuaHocSinhRepository = $ChinhSachCuaHocSinhRepository;
        $this->PhamViThuRepository = $PhamViThuRepository;
        $this->KhoiRepository = $KhoiRepository;
        $this->NoiDungThongBaoRepository = $NoiDungThongBaoRepository;
        $this->NotificationRepository = $NotificationRepository;
    }
    public function index($id)
    {
        $id_nam_hoc = $this->NamHocRepository->maxID();
        $nam_hoc_moi = $this->NamHocRepository->find($id_nam_hoc);
        $period = CarbonPeriod::create($nam_hoc_moi->start_date, '1 month', $nam_hoc_moi->end_date);
        $thang_trong_nam = [];
        foreach ($period as $dt) {
            array_push($thang_trong_nam, $dt->format("m-Y"));
        }
        $khoan_thu = $this->QuanLyKhoanThuRepository->getKhoanThuTheoDoi();
        $dot_thu = $nam_hoc_moi->DotThuTien()->orderBy('nam_thu', 'desc')->orderBy('thang_thu', 'desc')->get();
        if ($id == 0 && count($dot_thu) > 0) {
            $tong_tien_toan_bo = [];
            $tong_tien_toan_bo['tong_tien_phai_dong'] = 0;
            $tong_tien_toan_bo['so_da_thu'] = 0;
            $tong_tien_toan_bo['con_phai_thu'] = 0;
            $tong_tien_toan_bo['so_luong_chua_thong_bao'] = 0;
            $tong_tien_toan_bo['so_luong_da_thong_bao'] = 0;
            $data_dot_thu = $dot_thu[0];
            $id = $dot_thu[0]->id;
            foreach ($data_dot_thu->ChiTietDotThuTien as $key => $value) {
                $id_dot_thu_tien = $value->id;
                foreach ($nam_hoc_moi->Khoi as $key_khoi => $chi_tiet_khoi) {
                    $chi_tiet_khoi->tong_tien_phai_dong += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $chi_tiet_khoi->id);
                    $chi_tiet_khoi->so_da_thu = $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $chi_tiet_khoi->id);
                    $chi_tiet_khoi->con_phai_thu = $chi_tiet_khoi->tong_tien_phai_dong - $chi_tiet_khoi->so_da_thu;
                    $chi_tiet_khoi->so_luong_chua_thong_bao += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                    $chi_tiet_khoi->so_luong_da_thong_bao += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);

                    $tong_tien_toan_bo['tong_tien_phai_dong'] += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $chi_tiet_khoi->id);;
                    $tong_tien_toan_bo['so_da_thu'] += $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $chi_tiet_khoi->id);
                    $tong_tien_toan_bo['con_phai_thu'] = $tong_tien_toan_bo['tong_tien_phai_dong'] - $tong_tien_toan_bo['so_da_thu'];
                    $tong_tien_toan_bo['so_luong_chua_thong_bao'] += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                    $tong_tien_toan_bo['so_luong_da_thong_bao'] += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                }
            }
            $danh_sach_thu_tien_theo_khoi = $nam_hoc_moi->Khoi;
        } else {

            if ($id == 0) {
                $data_dot_thu = null;
            } else {
                $data_dot_thu = $this->QuanLyDotThuRepository->find($id);
            }
            // dd($data_dot_thu);

            $tong_tien_toan_bo = [];
            $tong_tien_toan_bo['tong_tien_phai_dong'] = 0;
            $tong_tien_toan_bo['so_da_thu'] = 0;
            $tong_tien_toan_bo['con_phai_thu'] = 0;
            $tong_tien_toan_bo['so_luong_chua_thong_bao'] = 0;
            $tong_tien_toan_bo['so_luong_da_thong_bao'] = 0;
            if ($data_dot_thu != null) {
                foreach ($data_dot_thu->ChiTietDotThuTien as $key => $value) {
                    $id_dot_thu_tien = $value->id;
                    foreach ($nam_hoc_moi->Khoi as $key_khoi => $chi_tiet_khoi) {
                        $chi_tiet_khoi->tong_tien_phai_dong += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $chi_tiet_khoi->id);
                        $chi_tiet_khoi->so_da_thu = $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $chi_tiet_khoi->id);
                        $chi_tiet_khoi->con_phai_thu = $chi_tiet_khoi->tong_tien_phai_dong - $chi_tiet_khoi->so_da_thu;
                        $chi_tiet_khoi->so_luong_chua_thong_bao += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                        $chi_tiet_khoi->so_luong_da_thong_bao += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);

                        $tong_tien_toan_bo['tong_tien_phai_dong'] += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $chi_tiet_khoi->id);;
                        $tong_tien_toan_bo['so_da_thu'] += $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $chi_tiet_khoi->id);
                        $tong_tien_toan_bo['con_phai_thu'] = $tong_tien_toan_bo['tong_tien_phai_dong'] - $tong_tien_toan_bo['so_da_thu'];
                        $tong_tien_toan_bo['so_luong_chua_thong_bao'] += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                        $tong_tien_toan_bo['so_luong_da_thong_bao'] += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $chi_tiet_khoi->id);
                    }
                    // dd($chi_tiet_khoi->tong_tien_phai_dong);

                }
            }
            $danh_sach_thu_tien_theo_khoi = $nam_hoc_moi->Khoi;
        }

        return view('quan-ly-hoc-phi.dot_thu', compact('khoan_thu', 'thang_trong_nam', 'dot_thu', 'nam_hoc_moi', 'data_dot_thu', 'danh_sach_thu_tien_theo_khoi', 'id', 'tong_tien_toan_bo'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['id_nam_hoc'] = $this->NamHocRepository->maxID();
        $thoi_gian_thu = $pieces = explode("-", $request->thoi_gian_thu);
        $data['nam_thu'] = $thoi_gian_thu[1];
        $data['thang_thu'] = $thoi_gian_thu[0];
        // start lấy danh sách khoản thu
        $danh_sach_khoan = [];
        $khoan_tien_an = 0;
        $khoan_tien_hoc = 0;

        foreach ($data['danh_sach_khoan_thu_cua_dot'] as $key => $value) {
            $khoan_thu = $this->QuanLyKhoanThuRepository->find($value);

            if ($khoan_thu->mac_dinh == 1) {
                $khoan_tien_an = $khoan_thu;
            }
            if ($khoan_thu->mac_dinh == 2) {
                $khoan_tien_hoc = $khoan_thu;
            }
            array_push($danh_sach_khoan, $khoan_thu);
        }
        // dd($khoan_tien_hoc);
        // end lấy danh sách khoản thu


        DB::transaction(function () use ($data, $request, $khoan_tien_an, $khoan_tien_hoc, $danh_sach_khoan) {
            // start add đợt thu tồn tại
            $kiem_tra_ton_tai_dot_thu = $this->QuanLyDotThuRepository->kiemTraTonTaiDotThu($data['nam_thu'], $data['thang_thu']);

            if ($kiem_tra_ton_tai_dot_thu != null) {
                $chi_tiet_dot_thu = [
                    'ten_dot_thu' => $data['ten_dot_thu'],
                    'id_dot_thu_tien' => $kiem_tra_ton_tai_dot_thu->id
                ];
                $id_chi_tiet_dot_thu =  $this->QuanLyChiTietDotThuRepository->create($chi_tiet_dot_thu)->id;
            } else {
                $id_dot_thu =  $this->QuanLyDotThuRepository->create($data)->id;
                $chi_tiet_dot_thu = [
                    'ten_dot_thu' => $data['ten_dot_thu'],
                    'id_dot_thu_tien' => $id_dot_thu
                ];
                $id_chi_tiet_dot_thu =  $this->QuanLyChiTietDotThuRepository->create($chi_tiet_dot_thu)->id;
            }

            $khoan_thu_cua_dot = $data['danh_sach_khoan_thu_cua_dot'];
            foreach ($khoan_thu_cua_dot as $key => $value) {
                $khoan_thu_find = $this->QuanLyKhoanThuRepository->find((int)$value);
                $pham_vi_thu = $this->PhamViThuRepository->getAllPhamViThuBackUp((int)$value);
                $id_tao_moi_khoan_thu = $this->QuanLyKhoanThuRepository->create($khoan_thu_find->toArray())->id;
                foreach ($pham_vi_thu as $pham_vi_thu_dot_khac) {
                    $pham_vi_thu_dot_khac->id_khoan_thu = $id_tao_moi_khoan_thu;
                    $this->PhamViThuRepository->create($pham_vi_thu_dot_khac->toArray());
                }


                // dd($khoan_thu_find);
            }
            $this->QuanLyKhoanThuRepository->capNhatKhoanThuCuaDot($khoan_thu_cua_dot, $id_chi_tiet_dot_thu);

            // end add đợt thu tồn tại

            //start tính tiền cho học sinh
            if ($request->session()->has('id_nam_hoc')) {
                $id = $request->session()->get('id_nam_hoc');
            } else {
                $id = $this->NamHocRepository->maxID();
            }
            $nam_hoc_moi = $this->NamHocRepository->find($id);
            $khoi = $nam_hoc_moi->Khoi->each->LopHoc;
            // dd($khoiơ);

            // dd($khoi);

            $lop = [];
            foreach ($khoi as $key => $value) {
                array_push($lop, $value->LopHoc);
            }
            $collection = collect($lop);
            $data_lop = $collection->collapse();
            $data_lop->all();

            $hoc_sinh = [];
            foreach ($data_lop->all() as $key => $value) {
                array_push($hoc_sinh, $value->HocSinh()->select('id', 'doi_tuong_chinh_sach_id', 'lop_id')->get());
            }
            $collection = collect($hoc_sinh);
            $data_hoc_sinh = $collection->collapse();
            $danh_sach_hoc_sinh = $data_hoc_sinh->all();

            // start tính tiền cho học sinh
            foreach ($danh_sach_hoc_sinh as $key => $hoc_sinh) {
                // dd($hoc_sinh);
                // miễn giảm học phí cao nhật
                $max_mien_giam = 0;
                if ($hoc_sinh->doi_tuong_chinh_sach== 1) {
                    $max_mien_giam = $this->ChinhSachCuaHocSinhRepository->maxMienGiam($hoc_sinh->id);
                }
                $thong_tin_dong_tien = [];
                $this->danh_sach_chi_tiet_khoan_thu = [];
                // tinh tiền ăn

                $this->tong_tien_phai_dong = 0;
                foreach ($danh_sach_khoan as $khoan_thu) {
                    // dd($khoan_thu);

                    if ($khoan_thu->pham_vi_thu == 0) {
                        $this->tinhTienChoHocSinh($khoan_thu, $khoan_tien_an, $hoc_sinh, $data, $this->tong_tien_phai_dong, $khoan_tien_hoc, $max_mien_giam, $this->danh_sach_chi_tiet_khoan_thu);
                    }
                    if ($khoan_thu->pham_vi_thu == 1) {

                        $pham_vi_thu = $this->PhamViThuRepository->getAllPhamViThu($khoan_thu->id);

                        $kiem_tra_pham_vi = in_array($hoc_sinh->Lop->Khoi->id, array_column($pham_vi_thu->toArray(), 'id_khoi_lop_thu'));
                        if ($kiem_tra_pham_vi) {
                            $this->tinhTienChoHocSinh($khoan_thu, $khoan_tien_an, $hoc_sinh, $data, $this->tong_tien_phai_dong, $khoan_tien_hoc, $max_mien_giam, $this->danh_sach_chi_tiet_khoan_thu);
                        }
                    }
                    if ($khoan_thu->pham_vi_thu == 2) {

                        $pham_vi_thu = $this->PhamViThuRepository->getAllPhamViThu($khoan_thu->id);

                        $kiem_tra_pham_vi = in_array($hoc_sinh->Lop->id, array_column($pham_vi_thu->toArray(), 'id_khoi_lop_thu'));
                        if ($kiem_tra_pham_vi) {
                            $this->tinhTienChoHocSinh($khoan_thu, $khoan_tien_an, $hoc_sinh, $data, $this->tong_tien_phai_dong, $khoan_tien_hoc, $max_mien_giam, $this->danh_sach_chi_tiet_khoan_thu);
                        }
                    }
                    // var_dump($this->tong_tien_phai_dong);
                }
                // dd($hoc_sinh->this->tong_tien_phai_dong);
                $thong_tin_dong_tien['id_dot_thu_tien'] = $id_chi_tiet_dot_thu;
                $thong_tin_dong_tien['id_hoc_sinh'] = $hoc_sinh->id;
                $thong_tin_dong_tien['lop_id'] = $hoc_sinh->lop_id;
                $thong_tin_dong_tien['khoi_id'] = $hoc_sinh->Lop->Khoi->id;
                $thong_tin_dong_tien['so_tien_phai_dong'] = $hoc_sinh->tong_tien_phai_dong == null ? 0 : $hoc_sinh->tong_tien_phai_dong;
                $id_danh_sach_thu_tien = $this->DanhSachThuTienRepository->create($thong_tin_dong_tien)->id;
                foreach ($this->danh_sach_chi_tiet_khoan_thu as $key => $item_chi_tiet) {
                    $this->danh_sach_chi_tiet_khoan_thu[$key]['id_danh_sach_thu_tien'] = $id_danh_sach_thu_tien;
                }
                ChiTietDongTienHocSinh::insert($this->danh_sach_chi_tiet_khoan_thu);
            }
        });
        return redirect()->route('quan-ly-dot-thu-index', ['id' => 0])->with('status', 'Profile updated!');
    }

    public function tinhTienChoHocSinh($khoan_thu, $khoan_tien_an, $hoc_sinh, $data, $tong_tien_phai_dong, $khoan_tien_hoc, $max_mien_giam, $danh_sach_chi_tiet_khoan_thu)
    {
        if ($khoan_thu->mac_dinh == 1) {
            $so_buoi_an = $this->DiemDanhDenRepository->soNgayAnCuaHocSinhTheoThang($hoc_sinh->id, $data['nam_thu'], $data['thang_thu']);
            $tong_tien_an = $so_buoi_an * $khoan_tien_an->muc_thu;
            // dd($so_buoi_an);
            $chi_tiet_khoan_thu = [
                'id_khoan_thu' => $khoan_thu->id,
                'so_tien' => $tong_tien_an
            ];
            $this->tong_tien_phai_dong += $tong_tien_an;
            // var_dump($this->tong_tien_phai_dong);
        } elseif ($khoan_thu->mac_dinh == 2) {
            $chi_tiet_khoan_thu = [
                'id_khoan_thu' => $khoan_thu->id,
                'so_tien' => $khoan_tien_hoc->muc_thu - $khoan_tien_hoc->muc_thu * $max_mien_giam / 100
            ];
            $this->tong_tien_phai_dong += $khoan_tien_hoc->muc_thu - $khoan_tien_hoc->muc_thu * $max_mien_giam / 100;
            // var_dump($this->tong_tien_phai_dong);

        } else {
            $so_buoi_hoc = $this->DiemDanhDenRepository->soBuoiHocCuaHocSinhTheoThang($hoc_sinh->id, $data['nam_thu'], $data['thang_thu']);
            if ($khoan_thu->don_vi_tinh == 0) {
                $tinh_khoan_thu_theo_don_vi = $khoan_thu->muc_thu;
            }
            if ($khoan_thu->don_vi_tinh == 1) {
                $so_ngay_tinh_tien = ceil($so_buoi_hoc / 2);
                $tinh_khoan_thu_theo_don_vi = $khoan_thu->muc_thu * $so_ngay_tinh_tien;
            }

            if ($khoan_thu->don_vi_tinh == 2) {
                $tinh_khoan_thu_theo_don_vi = $khoan_thu->muc_thu * $so_buoi_hoc;
            }

            $chi_tiet_khoan_thu = [
                'id_khoan_thu' => $khoan_thu->id,
                'so_tien' => $tinh_khoan_thu_theo_don_vi
            ];
            if ($khoan_thu->mien_giam > 0 && $max_mien_giam > 0) {
                $this->tong_tien_phai_dong += $tinh_khoan_thu_theo_don_vi - $tinh_khoan_thu_theo_don_vi * $khoan_thu->mien_giam / 100;
            } else {
                $this->tong_tien_phai_dong += $tinh_khoan_thu_theo_don_vi;
            }
        }

        array_push($this->danh_sach_chi_tiet_khoan_thu, $chi_tiet_khoan_thu);
        $hoc_sinh->tong_tien_phai_dong = $this->tong_tien_phai_dong;
    }

    public function getKhoanThuTheoKhoi(Request $request)
    {
        if ($request->id_khoi == 0) {
            $id_nam_hoc = $this->NamHocRepository->maxID();
            $nam_moi = $this->NamHocRepository->find($id_nam_hoc);
            $danh_sach_khoi =  $nam_moi->Khoi;
        } else {
            $danh_sach_khoi = $this->KhoiRepository->getArrayKhoi($request->id_khoi);
        }
        $data_dot_thu = $this->QuanLyDotThuRepository->find($request->id_dot_thu);


        $danh_sach_show = [];
        // tổng tiền toàn bộ
        $tong_tien_toan_bo = [];
        $tong_tien_toan_bo['tong_tien_phai_dong'] = 0;
        $tong_tien_toan_bo['so_da_thu'] = 0;
        $tong_tien_toan_bo['con_phai_thu'] = 0;
        $tong_tien_toan_bo['so_luong_chua_thong_bao'] = 0;
        $tong_tien_toan_bo['so_luong_da_thong_bao'] = 0;
        foreach ($danh_sach_khoi as $key => $khoi) {

            // thông tin showw khối
            $thong_tin_tien_cua_khoi = [];

            $thong_tin_tien_cua_khoi['tong_tien_phai_dong'] = 0;
            $thong_tin_tien_cua_khoi['so_da_thu'] = 0;
            $thong_tin_tien_cua_khoi['con_phai_thu'] = 0;
            $thong_tin_tien_cua_khoi['so_luong_chua_thong_bao'] = 0;
            $thong_tin_tien_cua_khoi['so_luong_da_thong_bao'] = 0;
            foreach ($data_dot_thu->ChiTietDotThuTien as $key => $value) {
                $id_dot_thu_tien = $value->id;
                $thong_tin_tien_cua_khoi['id_khoi'] = $khoi->id;
                $thong_tin_tien_cua_khoi['ten_khoi'] = $khoi->ten_khoi;
                $thong_tin_tien_cua_khoi['tong_tien_phai_dong'] += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $khoi->id);
                $thong_tin_tien_cua_khoi['so_da_thu'] += $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $khoi->id);
                $thong_tin_tien_cua_khoi['con_phai_thu'] = $thong_tin_tien_cua_khoi['tong_tien_phai_dong'] - $thong_tin_tien_cua_khoi['so_da_thu'];
                $thong_tin_tien_cua_khoi['so_luong_chua_thong_bao'] += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $khoi->id);
                $thong_tin_tien_cua_khoi['so_luong_da_thong_bao'] += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $khoi->id);

                // tính tổng tiền
                $tong_tien_toan_bo['tong_tien_phai_dong'] += $this->DanhSachThuTienRepository->tongTienPhaiDong($id_dot_thu_tien, $khoi->id);;
                $tong_tien_toan_bo['so_da_thu'] += $this->DanhSachThuTienRepository->tongTienDaThu($id_dot_thu_tien, $khoi->id);
                $tong_tien_toan_bo['con_phai_thu'] = $tong_tien_toan_bo['tong_tien_phai_dong'] - $tong_tien_toan_bo['so_da_thu'];
                $tong_tien_toan_bo['so_luong_chua_thong_bao'] += $this->DanhSachThuTienRepository->tongSoLuongCanThongBao($id_dot_thu_tien, $khoi->id);
                $tong_tien_toan_bo['so_luong_da_thong_bao'] += $this->DanhSachThuTienRepository->soLuongDaThongBao($id_dot_thu_tien, $khoi->id);
            }
            array_push($danh_sach_show, $thong_tin_tien_cua_khoi);
        }

        return [
            'danh_sach_show' => $danh_sach_show,
            'tong_quat' => $tong_tien_toan_bo,
        ];
    }
    public function chiTietDotThu($id, $khoi)
    {
        $dot_thu = $this->QuanLyDotThuRepository->find($id);
        $khoi_thu = $this->KhoiRepository->find($khoi);

        return view('quan-ly-hoc-phi.chi_tiet_dot_thu', compact('dot_thu', 'khoi_thu'));
    }

    public function chiTietDotThuTheoLop(Request $request)
    {
        $khoan_thu_trong_dot = $this->QuanLyChiTietDotThuRepository->find($request->id_dot);
        $khoan_thu_hoc_sinh = $this->DanhSachThuTienRepository->DotThuTheoLop($request->id_dot, $request->id_lop);
        foreach ($khoan_thu_hoc_sinh as $key => $value) {
            $value->chi_tiet_hoc_sinh = $value->HocSinh;
            $value->chi_tiet_khoan_thu_hoc_sinh = $value->ChiTietDongTienHocSinh;
            if (count($value->ChiTietDongTienHocSinh) == 0) {
                $khoan_thu_hoc_sinh = [];
            }
        }

        return [
            'dot_thu' => $khoan_thu_trong_dot,
            'khoan_thu_trong_dot' => $khoan_thu_trong_dot->KhoanThu,
            'khoan_thu_hoc_sinh' => $khoan_thu_hoc_sinh

        ];
    }

    public function guiThongBaoTheoKhoi(Request $request)
    {
        $hoc_sinh_theo_khoi_dot = $this->DanhSachThuTienRepository->danhSachHocSinhKhoiDot($request->dot_thu, $request->id_khoi);
        // dd($hoc_sinh_theo_khoi_dot);
        $thong_tin_dot = $this->QuanLyChiTietDotThuRepository->find($request->dot_thu);
        // dd($thong_tin_dot);
        $content = [
            "title"   => 'Thông báo đóng tiền học ' . $thong_tin_dot->DotThuTien->thang_thu . '/' . $thong_tin_dot->DotThuTien->nam_thu . ' ' . $thong_tin_dot->ten_dot_thu,
            "content" => 'Đóng tiền học',
            "auth_id" => Auth::id(),
            "type"    => 1,
            "route"   => "tin_tuc"
        ];

        $dataCreate = [
            'title'     => 'Thông báo đóng tiền học ' . $thong_tin_dot->DotThuTien->thang_thu . '/' . $thong_tin_dot->DotThuTien->nam_thu . ' ' . $thong_tin_dot->ten_dot_thu,
            'content'   => 'Đóng tiền',
            'auth_id'   => Auth::id(),
            'type'      => config('common.noi_dung_thong_bao_type.hoc_sinh')
        ];

        $list_id_hoc_sinh = [];
        $list_device = [];
        foreach ($hoc_sinh_theo_khoi_dot as $hoc_sinh) {
            array_push($list_id_hoc_sinh, $hoc_sinh->id);
            if ($hoc_sinh->HocSinh->User != null) {
                array_push($list_device, $hoc_sinh->HocSinh->User->device);
            }
        }
        $list_id_hoc_sinh_save_noti = [];
        foreach ($list_id_hoc_sinh as $key => $value) {
            // dd($value);
            $user_id = [
                'user_id' => $value,
                'role'    => config('common.notification_role.hoc_sinh')
            ];
            $data_notifi = collect([$user_id, $content]);
            $data_save_notifi = $data_notifi->collapse();
            $list_id_hoc_sinh_save_noti[$key] = $data_save_notifi->toArray();
        }

        foreach ($list_device as $key => $value) {
            $content['device'] = $value;
            $data_device = collect([$content]);
            $data_send_device = $data_device->collapse();
            $list_device[$key] = $data_send_device;
        }

     

        $list_id_hoc_sinh_save_thong_bao = [];



        DB::transaction(function () use ($dataCreate, $list_id_hoc_sinh_save_noti, $list_id_hoc_sinh_save_thong_bao, $list_id_hoc_sinh,$list_device,$content,$request) {
            $id_thong_bao = $this->NoiDungThongBaoRepository->create($dataCreate)->id;

            foreach ($list_id_hoc_sinh as $key => $value) {
                $user_id = [
                    'user_id'     =>  $value,
                    'thongbao_id' =>  $id_thong_bao
                ];
                array_push($list_id_hoc_sinh_save_thong_bao, $user_id);
            }

            $this->DanhSachThuTienRepository->updateThongBaoHocSinhKhoiDot($request->all());
            
            jobThongBaoToiHocSinh::dispatch($list_id_hoc_sinh_save_noti, $list_id_hoc_sinh_save_thong_bao, $list_device, $content, $this->NotificationRepository);
        });
    }

    public function guiThongBaoTheoLop(Request $request)
    {
        $hoc_sinh_theo_id=$this->DanhSachThuTienRepository->getDanhSachHocSinhtThongBaoTheoLop($request->danh_sach_hoc_sinh,$request->id_lop_chon,$request->id_dot_chon);
        $thong_tin_dot = $this->QuanLyChiTietDotThuRepository->find($request->id_dot_chon);
        $content = [
            "title"   => 'Thông báo đóng tiền học ' . $thong_tin_dot->DotThuTien->thang_thu . '/' . $thong_tin_dot->DotThuTien->nam_thu . ' ' . $thong_tin_dot->ten_dot_thu,
            "content" => 'Đóng tiền học',
            "auth_id" => Auth::id(),
            "type"    => 1,
            "route"   => "tin_tuc"
        ];

        $dataCreate = [
            'title'     => 'Thông báo đóng tiền học ' . $thong_tin_dot->DotThuTien->thang_thu . '/' . $thong_tin_dot->DotThuTien->nam_thu . ' ' . $thong_tin_dot->ten_dot_thu,
            'content'   => 'Đóng tiền',
            'auth_id'   => Auth::id(),
            'type'      => config('common.noi_dung_thong_bao_type.hoc_sinh')
        ];

        $list_id_hoc_sinh = [];
        $list_device = [];
        foreach ($hoc_sinh_theo_id as $hoc_sinh) {
            array_push($list_id_hoc_sinh, $hoc_sinh->id);
            if ($hoc_sinh->HocSinh->User != null) {
                array_push($list_device, $hoc_sinh->HocSinh->User->device);
            }
        }
        $list_id_hoc_sinh_save_noti = [];
        foreach ($list_id_hoc_sinh as $key => $value) {
            // dd($value);
            $user_id = [
                'user_id' => $value,
                'role'    => config('common.notification_role.hoc_sinh')
            ];
            $data_notifi = collect([$user_id, $content]);
            $data_save_notifi = $data_notifi->collapse();
            $list_id_hoc_sinh_save_noti[$key] = $data_save_notifi->toArray();
        }

        foreach ($list_device as $key => $value) {
            $content['device'] = $value;
            $data_device = collect([$content]);
            $data_send_device = $data_device->collapse();
            $list_device[$key] = $data_send_device;
        }

     

        $list_id_hoc_sinh_save_thong_bao = [];



        DB::transaction(function () use ($dataCreate, $list_id_hoc_sinh_save_noti, $list_id_hoc_sinh_save_thong_bao, $list_id_hoc_sinh,$list_device,$content,$request) {
            $id_thong_bao = $this->NoiDungThongBaoRepository->create($dataCreate)->id;

            foreach ($list_id_hoc_sinh as $key => $value) {
                $user_id = [
                    'user_id'     =>  $value,
                    'thongbao_id' =>  $id_thong_bao
                ];
                array_push($list_id_hoc_sinh_save_thong_bao, $user_id);
            }

            $this->DanhSachThuTienRepository->updateThongBaoHocSinhLopDot($request->all());
            // dd(1);
            jobThongBaoToiHocSinh::dispatch($list_id_hoc_sinh_save_noti, $list_id_hoc_sinh_save_thong_bao, $list_device, $content, $this->NotificationRepository);
        });
    }
}
