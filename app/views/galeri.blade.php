<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="keywords" content="image editor, edit, image, filter, image filter, gambar, edit gambar" />
  <meta name="description" content="Gambar editor online sederhana" />
  <meta name="robots" content="index,follow" />
  <meta name="author" content="Heru Rusdianto" />
  <title>Galeri Gambar Editor</title>
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plusstrap.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plusstrap-responsive.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/wookmark-reset.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/galeri.css') }}" />
</head>
<body>
  <div class="center">
    @if (count($foto))
      <ul id="galeri">
        @foreach ($foto as $data)
        <li>
          <a href="{{ asset('foto/' . $data->nama) }}" rel="lightbox">
            <img src="{{ asset('foto/thumbs_' . $data->nama) }}" alt="{{ $data->nama }}" />
          </a>
        </li>
        @endforeach
      </ul>

      <br />

      <div class="navbar-fixed-bottom">{{ str_replace('href', 'data-target', $foto->links()) }}</div>
    @else
      <div id="kosong">
         <div class="alert alert-error fade in hilang" id="error-kosong">
           <span id="teks-error-kosong">aaa</span>
         </div>
      </div>
    @endif
  </div>

  <div class="modal hide fade">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Sukses</h3>
    </div>
      <div class="modal-body center">
        <p><strong>Semua foto pada galeri berhasil dimuat.</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-large tangan" id="batal" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/wookmark.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/colorbox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/galeri.js') }}"></script>
</body>
</html>