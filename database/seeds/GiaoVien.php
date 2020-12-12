<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class GiaoVien extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nam_hoc_moi = DB::table('nam_hoc')->where('type', 1)->first();
        $url = file_get_contents("https://raw.githubusercontent.com/duyet/vietnamese-namedb/master/uit_member.json");
        $json_ten = json_decode($url);
        // dd($json_ten[1]);

        // $lop_hoc_moi = DB::table('lop_hoc')
        
        // ->join('khoi', 'khoi.id', '=', 'lop_hoc.khoi_id')
        // ->select('lop_hoc.*')
        // ->where('khoi.nam_hoc_id', $nam_hoc_moi->id)->get();
        function CovertVn($str){
            $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|� �|ặ|ẳ|ẵ)/", 'a', $str);
            $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
            $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
            $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|� �|ợ|ở|ỡ)/", 'o', $str);
            $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
            $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
            $str = preg_replace("/(đ)/", 'd', $str);
            $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|� �|Ặ|Ẳ|Ẵ)/", 'A', $str);
            $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
            $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
            $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|� �|Ợ|Ở|Ỡ)/", 'O', $str);
            $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
            $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
            $str = preg_replace("/(Đ)/", 'D', $str);
            $str = preg_replace("/( )/", '_', $str);
            return $str;
        }
        for ($i=0; $i <40 ; $i++) { 
            $rand = rand(200,3000);
            $rand1= rand(10000,99999);
            $id_gv = DB::table('users')->insertGetId([
                'name' => $json_ten[$rand]->full_name,
                'username' => CovertVn($json_ten[$rand]->full_name).'GV'.rand(1,10),
                'avatar' => "",
                'email' => CovertVn($json_ten[$rand]->full_name).$rand1.'GV'.$rand.'gmail.com',
                'password' => Hash::make('1234567890'),
                'time_code' => Carbon::now(),
                'role' => 2,
                'active' => 1,
                'phone_number' => '03766'.$rand1
                
             ]);
            DB::table('giao_vien')->insert([
                'ma_gv' => 'GV0'.$id_gv,
                'ten' => $json_ten[$rand]->full_name,
                'gioi_tinh' => rand(0,1),
                'dien_thoai' => '03766'.$rand1,
                'ngay_sinh' => '199'.rand(1,9).'-08-'.rand(1,30),
                'dan_toc' => 'Kinh',
                'trinh_do' => 'Cao đằng mầm non',
                'email' => CovertVn($json_ten[$rand]->full_name).$rand1.'GV'.$rand.'@gmail.com',
                'chuyen_mon' => 'Cao đằng',
                'noi_dao_tao' => 'Hà Nội',
                'nam_tot_nghiep' => '2010',
                'so_cmtnd' => '026200006416',
                'ngay_cap_cmtnd' => '2015-06-25',
                'noi_cap_cmtnd_matp' => '01',
                'user_id' => $id_gv

            ]);
            
        }
    }
}