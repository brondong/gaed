<?php

class HomeController extends BaseController {

	/**
	 * halaman index
	 * 
	 * @return view
	 */
	public function getIndex()
	{
		return View::make('home');
	}

	/**
	 * upload file foto
	 * 
	 * @return json
	 */
	public function postUploadify()
	{
		// validasi
		$input = Input::all();
		$aturan = array('foto' => 'required|mimes:jpg,jpeg,png|max:5000');
		$validasi = Validator::make($input, $aturan);

		// tidak valid
		if ($validasi->fails()) {
			// pesan
			$status = 'error';
			$pesan = $validasi->messages()->first('foto') ?: '';
			$respon = compact('status', 'pesan');

			return Response::json($respon);

		// valid
		} else {
			// cek nama foto di basisdata
			$cek = false;
			do {
				// nama foto
				$nama =  strtolower(str_random(15)) . '.png';
				$cek  = Foto::cek($nama);
			} while (!$cek);

			// tambah foto di basisdata
			Foto::tambah($nama);

			// unggah foto ke dir "foto"
			Input::file('foto')->move('foto', $nama);

			// path foto
			$foto = asset('foto/' . $nama);
			$path_foto = 'foto/' . $nama;

			// ukuran foto
			list($lebar, $tinggi) = getimagesize($foto);

			// terlalu besar
			if ($lebar > 1000 || $tinggi > 1000) {
				// resize foto				
				Image::open($path_foto)->resize(1000, 1000, true)->save($path_foto);
			}

			// thumbnail foto
			$thumbs_foto = 'foto/thumbs_' . $nama;
			Image::open($path_foto)->resize(300, 300, true)->save($thumbs_foto);

			// pesan
			$status = 'sukses';
			$respon = compact('status', 'foto', 'nama');

			return Response::json($respon);
		}
	}

	/**
	 * upload webcam
	 * 
	 * @return json
	 */
	public function postWebcam()
	{
		// input foto webcam
		$input = file_get_contents('php://input');

		// foto blank
		if (md5($input) == '5b8d00c9c0d88b54f122196a0ad4e1ea') {
			// pesan
			$status = 'error';
			$pesan = 'Foto dari webcam anda blank, silahkan coba lagi.';
			$respon = compact('status', 'pesan');
			
			return Response::json($respon);
		}

		// cek nama webcam di basisdata
		$cek = false;
		do {
			// nama webcam
			$nama =  strtolower(str_random(15)) . '.png';
			$cek  = Foto::cek($nama);
		} while (!$cek);

		// tambah webcam di basisdata
		Foto::tambah($nama);

		// path foto
		$path = public_path() . '/foto/' . $nama;

		// unggah webcam ke dir "foto"
		file_put_contents($path, $input);

		// resize foto
		$path_foto = 'foto/' . $nama;
		Image::open($path_foto)->resize(1000, 1000, true)->save($path_foto);

		// thumbnail foto
		$thumbs_foto = 'foto/thumbs_' . $nama;
		Image::open($path_foto)->resize(300, 300, true)->save($thumbs_foto);

		// pesan
		$status = 'sukses';
		$foto = asset('foto/' . $nama);
		$respon = compact('status', 'foto', 'nama');
		
		return Response::json($respon);
	}

	/**
	 * potong foto
	 * 
	 * @return json
	 */
	public function postCrop()
	{
		// validasi
		$input = Input::get();
		$aturan = array('w' => 'required|integer', 'h' => 'required|integer', 'x' => 'required|integer', 'y' => 'required|integer');
		$validasi = Validator::make($input, $aturan);

		// tidak valid
		if ($validasi->fails()) {
			// pesan
			$status = 'error';
			$pesan = 'Inputan koordinat tidak valid.';
			$respon = compact('status', 'pesan');
			
			return Response::json($respon);

		// valid
		} else {
			// koordinat
			$w = trim(Input::get('w'));
			$h = trim(Input::get('h'));
			$x = trim(Input::get('x'));
			$y = trim(Input::get('y'));

			// nama foto
			$nama = trim(Input::get('nama'));
			$path_foto = 'foto/' . $nama;

			// potong
			Image::open($path_foto)->crop($w, $h, $x, $y)->save($path_foto);

			// thumbnail foto
			$thumbs_foto = 'foto/thumbs_' . $nama;
			Image::open($path_foto)->resize(300, 300, true)->save($thumbs_foto);

			// pesan
			$status = 'sukses';
			$foto = asset('foto/' . $nama);
			$respon = compact('status', 'foto');
			
			return Response::json($respon);
		}
	}

	/**
	 * simpan perubahan foto
	 * 
	 * @return void
	 */
	public function postFilter()
	{
		// validasi
		$input = Input::get();
		$aturan = array('foto' => 'required', 'nama' => 'required');
		$validasi = Validator::make($input, $aturan);

		// tidak valid
		if ($validasi->fails()) {
			// pesan
			$status = 'error';
			$pesan = 'Perubahan foto gagal disimpan.';
			$respon = compact('status', 'pesan');
			
			return Response::json($respon);

		// valid
		} else {
			// input
			$foto = trim(Input::get('foto'));
			$nama = trim(Input::get('nama'));

			// decode
			list($tipe, $foto) = explode(';', $foto);
			list(, $foto) = explode(',', $foto);
			$foto = base64_decode($foto);

			// path foto
			$path = public_path() . '/foto/' . $nama;

			// simpan perubahan foto
			file_put_contents($path, $foto);
			
			// resize foto
			$path_foto = 'foto/' . $nama;
			
			// thumbnail foto
			$thumbs_foto = 'foto/thumbs_' . $nama;
			Image::open($path_foto)->resize(300, 300, true)->save($thumbs_foto);
			
			// pesan
			$status = 'sukses';
			$respon = compact('status');
			
			return Response::json($respon);
		}
	}

	/**
	 * galeri foto yang disimpan
	 * 
	 * @return view
	 */
	public function getGaleri()
	{
		// data foto
		$foto = Foto::semua();
		$data = compact('foto');

		// ada foto
		if (count($foto)) {
			// bukan ajax
			if (!Request::ajax()) {
				return View::make('galeri', $data);

			// ajax
			} else {
				return View::make('ajax', $data);
			}

		// tidak ada foto
		} else {
			return Redirect::to('/');
		}
	}

}