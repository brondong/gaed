<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="keywords" content="image editor, edit, image, filter, image filter, gambar, edit gambar" />
  <meta name="description" content="Gambar editor online sederhana" />
  <meta name="robots" content="index,follow" />
  <meta name="author" content="Heru Rusdianto" />
  <title>Gambar Editor</title>
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plusstrap.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plusstrap-responsive.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/uploadify.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jcrop.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div class="row">
    <div class="span6">
      <img src="{{ asset('img/blank.png') }}" id="foto" />

      <div class="hilang">
        <input type="text" name="w" id="w" />
        <input type="text" name="h" id="h" />
        <input type="text" name="x" id="x" />
        <input type="text" name="y" id="y" />
      </div>
    </div>

    <div class="span6 center">
      <div id="tombol-foto">
        <button type="button" class="btn btn-large btn-danger" id="ambil-foto">Ambil Foto</button>
   
        <br />
        <strong>Atau</strong>
        <br />
   
        <input type="file" name="input-uploadify" id="input-uploadify" />
   
        <div id="div-error-uploadify">
           <div class="alert alert-error fade in hilang" id="error-uploadify">
             <span id="teks-error-uploadify"></span>
           </div>
        </div>
      </div>

      <div class="hilang" id="menu">
        <div id="tombol-menu">
          <button type="button" class="btn btn-large btn-danger tangan" id="potong-foto">Potong Foto</button>

          <div class="hilang" id="hilang-potong">
            <button type="button" class="btn  tangan" id="simpan-potong">Simpan</button>
            <button type="button" class="btn  tangan" id="batal-potong">Batal</button>

            <div id="div-error-potong">
              <div class="alert alert-error fade in hilang" id="error-potong">
                <span id="teks-error-potong"></span>
              </div>
            </div>
          </div>
     
          <br />
          <strong>Atau</strong>
          <br />

          <button type="button" class="btn btn-large btn-danger tangan" id="filter-foto">Filter Foto</button>
        </div>
      </div>

      <div class="hilang" id="filters">
        <legend>Daftar Filter</legend>
        <div class="kiri" id="filter">
          <div>
            <button class="btn tangan" id="revert">Revert</button>
            <button class="btn tangan" id="tiltShift">Tilt Shift</button>
            <button class="btn tangan" id="radialBlur">Radial Blur</button>
          </div>
          <div>
            <button class="btn tangan" id="edgeEnhance">Edge Enhance</button>
            <button class="btn tangan" id="edgeDetect">Edge Detect</button>
            <button class="btn tangan" id="emboss">Emboss</button>
          </div>
          <div>
            <button class="btn tangan" id="vintage">Vintage</button>
            <button class="btn tangan" id="lomo">Lomo</button>
            <button class="btn tangan" id="clarity">Clarity</button>
          </div>
          <div>
            <button class="btn tangan" id="sinCity">Sin City</button>
            <button class="btn tangan" id="sunrise">Sunrise</button>
            <button class="btn tangan" id="crossProcess">Cross Process</button>
          </div>
          <div>
            <button class="btn tangan" id="orangePeel">Orange Peel</button>
            <button class="btn tangan" id="love">Love</button>
            <button class="btn tangan" id="grungy">Grungy</button>
          </div>
          <div>
            <button class="btn tangan" id="jarques">Jarques</button>
            <button class="btn tangan" id="pinhole">Pinhole</button>
            <button class="btn tangan" id="oldBoot">Old Boot</button>
          </div>
          <div>
            <button class="btn tangan" id="glowingSun">Glowing Sun</button>
            <button class="btn tangan" id="hazyDays">Hazy Days</button>
            <button class="btn tangan" id="herMajesty">Her Majesty</button>
          </div>
          <div>
            <button class="btn tangan" id="nostalgia">Nostalgia</button>
            <button class="btn tangan" id="hemingway">Hemingway</button>
            <button class="btn tangan" id="concentrate">Concentrate</button>
          </div>
          <div>
            <button class="btn tangan" id="vibrance">Vibrance</button>
            <button class="btn tangan" id="greyscale">Greyscale</button>            
            <button class="btn tangan" id="invert">Invert</button>
          </div>
          <div>
            <button class="btn tangan" id="sepia">Sepia</button>
            <button class="btn tangan" id="boxBlur">Box Blur</button>
            <button class="btn tangan" id="heavyRadialBlur">Heavy Radial Blur</button>
          </div>
          <div>
            <button class="btn tangan" id="gaussianBlur">Gaussian Blur</button>
            <button class="btn tangan" id="motionBlur">Motion Blur</button>
            <button class="btn tangan" id="sharpen">Sharpen</button>
          </div>
        </div>
      </div>

      <a class="btn btn-large btn-danger tangan hilang" id="unduh" target="_blank" download="foto.png">Unduh</a>
    </div>

    <div class="modal hide fade" data-backdrop="static">
      <div class="modal-body center"></div>
      <div class="center">
        <a class="btn btn-large tangan" id="pengaturan-webcam"><img src="{{ asset('img/camera.png') }}" alt="" /></a>
        <br />
        <div id="div-error-webcam">
          <div class="alert alert-error fade in hilang" id="error-webcam">
            <span id="teks-error-webcam"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-large tangan" id="unggah-webcam">Unggah</button>
        <button type="button" class="btn btn-large tangan" id="batal-webcam" data-dismiss="modal" aria-hidden="true">Batal</button>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/uploadify.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/webcam.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jcrop.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/caman.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript">
  var swf_uploadify = "{{ asset('swf/uploadify.swf') }}";
  var url_uploadify = "{{ URL::to('uploadify') }}";

  var swf_webcam = "{{ asset('swf/webcam.swf') }}";
  var url_webcam = "{{ URL::to('webcam') }}";

  var url_crop = "{{ URL::to('crop') }}";
</script>
</html>