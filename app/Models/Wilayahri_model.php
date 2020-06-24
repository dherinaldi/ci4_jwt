<?php

namespace App\Models;

use CodeIgniter\Model;

class Wilayahri_model extends Model{

    protected $table = "users";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }

    public function cek_login($email)
    {
        $query = $this->table($this->table)
        ->where('email', $email)
        ->countAll();

        if($query >  0){
            $hasil = $this->table($this->table)
            ->where('email', $email)
            ->limit(1)
            ->get()
            ->getRowArray();
        } else {
            $hasil = array(); 
        }
        return $hasil;
    }

    public function get_provinces($id = null){
        if(!empty($id)){
            $builder = $this->db->table('provinces')->where('id',$id);
        }else{
            $builder = $this->db->table('provinces');
        }
        $query   = $builder->get();
        return $query;
    }

    public function get_kota($id = null){
        if(!empty($id)){
            $builder = $this->db->table('regencies')->where('province_id',$id);
        }else{
            $builder = $this->db->table('regencies');
        }
        $query   = $builder->get();
        return $query;
    }

    public function get_kec($id = null){
        if(!empty($id)){
            $builder = $this->db->table('districts')->where('regency_id',$id);
        }else{
            $builder = $this->db->table('districts');
        }
        $query   = $builder->get();
        return $query;
    }

    public function get_kel($id = null){
        if(!empty($id)){
            $builder = $this->db->table('villages')->where('districts_id',$id);
        }else{
            $builder = $this->db->table('villages');
        }
        $query   = $builder->get();
        return $query;
    }


}