<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\HocSinhDangKyNhapHoc;
class DangKiNhapHocRepository extends BaseRepository
{
    protected $model;
    public function __construct(
        HocSinhDangKyNhapHoc $model
    ) {
        parent::__construct();
        $this->model = $model;
    }

    public function getTable()
    {
        return 'hoc_sinh_dang_ky_nhap_hoc';
    }

    

    public function getOneHocSinhDangKy($id){
        return $this->model->where('id',$id)->first();
    }

    public function createHocSinhDangKy($arrayData){
        return $this->model->insertGetId($arrayData);
    }
    

    public function updateHocSinhDangKy($key,$arrayData){
		return $this->model->where('id',$key)->update($arrayData);
	}


    public function getAllHocSinhDangKy($params){
        $query = $this->model->where('status',2);

        if (isset($params['sdt_dk_sreach']) && !empty($params['sdt_dk_sreach'])) {
            $query->where('dien_thoai_dang_ki', $params['sdt_dk_sreach']);
         }
         if (isset($params['ten_sreach']) && !empty($params['ten_sreach'])) {
           $query->where('ten', 'LIKE', '%' . $params['ten_sreach']. '%');
         }

         return $query->get();
    }

    // public function sreachHocSinhDangKy($params){
    //    $query =  $this->model->where('status',2);

    //    if (isset($params['sdt_dk_sreach']) && !empty($params['sdt_dk_sreach'])) {
    //       $query->where('dien_thoai_dang_ki', $params['sdt_dk_sreach']);
    //    }
    //    if (isset($params['ten_sreach']) && !empty($params['ten_sreach'])) {
    //      $query->where('ten', 'LIKE', '%' . $params['ten_sreach']. '%');
    //    }

    //    return $query->get();
    // }

    
  
}