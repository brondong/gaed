<?php

class HomeController extends BaseController {

	/**
	 * halaman index
	 * 
	 * @return php
	 */
	public function getIndex()
	{
		// session
		if (!Session::has('sesi')) {
			$sesi = str_random(15);
			Session::put('sesi', $sesi);
		}

		return View::make('master');
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
			// nama foto
			$sesi = Session::get('sesi');
			$nama_foto =  $sesi . '.png';

			// unggah foto ke dir "foto"
			Input::file('foto')->move('foto', $nama_foto);

			// resize foto
			$path_foto = 'foto/' . $nama_foto;
			Image::make($path_foto)->resize(555, 555, true)->save($path_foto);

			// pesan
			$status = 'sukses';
			$foto = asset('foto/' . $nama_foto);
			$respon = compact('status', 'foto');

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
		if (md5($input) == 'aedf28aaf9a3ed10147839c508bf17d0') {
			// pesan
			$status = 'error';
			$pesan = 'Foto dari webcam anda blank, silahkan coba lagi.';
			$respon = compact('status', 'pesan');
			
			return Response::json($respon);
		}

		// nama foto
		$sesi = Session::get('sesi');
		$nama_foto =  $sesi . '.png';
		$path = public_path() . '\foto\\' . $nama_foto;

		// unggah webcam ke dir "foto"
		file_put_contents($path, $input);

		// resize foto
		$path_foto = 'foto/' . $nama_foto;
		Image::open($path_foto)->resize(555, 555, true)->save($path_foto);

		// pesan
		$status = 'sukses';
		$foto = asset('foto/' . $nama_foto);
		$respon = compact('status', 'foto');
		
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
			// input
			$w = Input::get('w');
			$h = Input::get('h');
			$x = Input::get('x');
			$y = Input::get('y');

			// nama foto
			$sesi = Session::get('sesi');
			$nama_foto =  $sesi . '.png';
			$path_foto = 'foto/' . $nama_foto;

			// potong
			Image::open($path_foto)->crop($w, $h, $x, $y)->save($path_foto);

			// pesan
			$status = 'sukses';
			$foto = asset('foto/' . $nama_foto);
			$respon = compact('status', 'foto');
			
			return Response::json($respon);
		}
	}

}