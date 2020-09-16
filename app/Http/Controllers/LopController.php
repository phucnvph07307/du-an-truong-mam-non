<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\KhoiRepository;
use App\Repositories\GiaoVienRepository;
use App\Repositories\LopRepository;

class LopController extends Controller
{
    protected $KhoiRepository;
    protected $GiaoVienRepository;
    protected $LopRepository;

    public function __construct(
        LopRepository $LopRepository,
        GiaoVienRepository $GiaoVienRepository,
        KhoiRepository $KhoiRepository
    ) {
        $this->LopRepository = $LopRepository;
        $this->GiaoVienRepository = $GiaoVienRepository;
        $this->KhoiRepository = $KhoiRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $khoi = $this->KhoiRepository->getAll();
        $lop = $this->LopRepository->getAllPhanTrang();

        return view('quan-ly-lop.index', [
            'khoi' => $khoi,
            'lop' => $lop
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $khoi = $this->KhoiRepository->getAll();
        $giao_vien = $this->GiaoVienRepository->getGIaoVienChuaCoLop();
        return view('quan-ly-lop.create', [
            'khoi' => $khoi,
            'giao_vien' => $giao_vien
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            "khoi_id" => $request->khoi,
            "ten_lop" => $request->ten_lop,
        ];
        $idLop = $this->LopRepository->addLop($data);
        if ($request->giao_vien_cn != null) {
            $giao_vien_cn = $request->giao_vien_cn;
            $this->GiaoVienRepository->phanLopGiaoVienCn($giao_vien_cn, $idLop->id);
        }
        if (isset($request->giao_vien_phu)) {
            foreach ($request->giao_vien_phu as $key => $value) {
                $this->GiaoVienRepository->phanLopGiaoVienPhu($value, $idLop->id);
            }
        }
        return redirect()->route('quan-ly-lop-index')->with('status', 'Thêm mới dữ liệu thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('quan-ly-lop.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lop = $this->LopRepository->find($id);
        // dd($lop->giao_vien_chu_nhiem->id);
        $khoi = $this->KhoiRepository->getAllKhoi();
        $giao_vien = $this->GiaoVienRepository->getGIaoVienChuaCoLop();
        return view('quan-ly-lop.edit', [
            'khoi' => $khoi,
            'giao_vien' => $giao_vien,
            'lop' => $lop
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function phanLop()
    {
        return view('quan-ly-lop.phan-lop');
    }
}
