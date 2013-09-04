<?php

class Foto extends Eloquent {
	
	/**
	 * nama tabel
	 * 
	 * @var string
	 */
	protected $table = 'foto';

	/**
	 * nama kolom yang dapat diisi
	 * 
	 * @var array
	 */
	protected $fillable = array('nama');

	/**
	 * nama kolom yang tidak dapat diisi
	 * 
	 * @var array
	 */
	protected $guarded = array('id', 'created_at', 'updated_at');

	/**
	 * cek ada tidaknya nama foto di basisdata
	 * 
	 * @param string $nama_foto
	 * @return bool
	 */
	public static function cek($nama)
	{
		$data = Foto::where('nama', '=', $nama)->count();
		return ($data > 0) ? false : true;
	}

	/**
	 * tambah data di basisdata
	 * 
	 * @param  string $nama
	 * @return void
	 */
	public static function tambah($nama)
	{
		$data = compact('nama');
		Foto::create($data);
	}

	/**
	 * ambil semua data di basisdata
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function semua()
	{
		return Foto::orderBy('updated_at', 'desc')->paginate(1);
	}
}