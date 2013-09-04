@foreach ($foto as $data)
<li>
  <a href="{{ asset('foto/' . $data->nama) }}" rel="lightbox">
    <img src="{{ asset('foto/thumbs_' . $data->nama) }}" alt="{{ $data->nama }}" />
  </a>
</li>
@endforeach