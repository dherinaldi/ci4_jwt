<?php namespace App\Controllers;

// Panggil JWT
use \Firebase\JWT\JWT;
// panggil class Auht
use App\Controllers\Auth;
// panggil restful api codeigniter 4
use CodeIgniter\RESTful\ResourceController;
//Auth_model
use App\Models\Wilayahri_model;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class Wilayah extends ResourceController
{
	public function __construct()
	{
        // inisialisasi class Auth dengan $this->protect
		$this->protect = new Auth();
		$this->wil = new Wilayahri_model();
	}

	public function index()
	{
		
		//var_dump($this->wil->get_provinces(11)->getResultArray());
        // ambil dari controller auth function public private key
		$secret_key = $this->protect->privateKey();
		$token = null;
		$authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
		$arr = explode(" ", $authHeader);
		$token = $arr[1];

		$id = $this->request->getVar('id');
		$jenis = $this->request->getVar('jenis');

		switch ($jenis) {
			case 'prov':

			if(!empty($id)){
				$dat = $this->wil->get_provinces($id);
			}else{
				$dat = $this->wil->get_provinces();
			}

			break;

			case 'kot':

			if(!empty($id)){
				$dat = $this->wil->get_kota($id);
			}else{
				$dat = $this->wil->get_kota();
			}

			break;

			case 'kec':

			if(!empty($id)){
				$dat = $this->wil->get_kec($id);
			}else{
				$dat = $this->wil->get_kec();
			}

			break;

			case 'kel':

			if(!empty($id)){
				$dat = $this->wil->get_kel($id);
			}else{
				$dat = $this->wil->get_kel();
			}

			break;

		}
		$data = $dat->getResultArray();
		if($token){
			try {

				$decoded = JWT::decode($token, $secret_key, array('HS256'));
				// Access is granted. Add code of the operation here
				if($decoded){
                    // response true
					$output = [
					'message' => 'Access granted',
					'data'=>$data
					];
					return $this->respond($output, 200);
				}
				
			} catch (\Exception $e){

				$output = [
				'message' => 'Access denied',
				"error" => $e->getMessage()
				];

				return $this->respond($output, 401);
			}
		}
	}
	
}
