@extends('admin.template')
@section('content')
<style type="text/css">
  #map {
    height: 400px;
    /* The height is 400 pixels */
    width: 100%;
    /* The width is the width of the web page */
  }
</style>
<div class="container-fluid">
    <!-- Content Row -->
  <!-- Page Heading -->
  <div class="row">
      <h1 class="h3 text-gray-800">Manajemen Fasilitas</h1>
  </div>
    <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/fasilitas/tempatmakan">Tempat Makan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit - {{$data->nama_fasilitas}}</li>
      </ol>
    </nav>
      <div class="col-md-12 card">
        <div class="card-body">
          @if(Session::has('message'))
            @php 
              $messages = Session::get('message');
            @endphp
            <p class="alert {{@$messages['class']}}">
              @foreach(@$messages['text'] as $err => $errvalue)
                {!!@$errvalue!!}<br>
              @endforeach
            </p>
          @endif
          <form id="form-data" name="form-data" method="POST" enctype="multipart/form-data" action="{{url('/')}}/admin/fasilitas/tempatmakan/{{$data->id}}/update">
            <!-- form reqiure laravel -->
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <!-- form require laravel end -->
            <div class="form-group">
              <input type="hidden" name="group_kategori" value="TEMPAT_MAKAN">
              <label>Nama Fasilitas</label>
              <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" value="{{$data->nama_fasilitas}}">
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" class="form-control" name="alamat_fasilitas" id="alamat_fasilitas" value="{{$data->alamat_fasilitas}}">
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="deskripsi" name="deskripsi" class="summernote form-control">{{$data->deskripsi}}</textarea>
            </div>
            <div class="form-group">
              <label>Upload Gambar</label>
              <input type="hidden" name="url_gambar" id="url_gambar" value="{{$data->thumbnail}}">
              <input type="file" name="image" class="form-control" id="image">
            </div>
            <div class="form-group">
              <label>Lokasi</label>
              <input type="text" name="geo_location" id="geo_location" class="form-control" value="{{$data->geo_location}}" readonly="">
              <div id="map"></div>
            </div>
          </form>
          <div class="group-btn pull-right">
            <button id="btn-simpan" class="btn btn-success">Simpan</button>
            <button id="btn-batal" class="btn btn-danger">Batal</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  let markers = [];
  let map;
  const image = "{{url('/public/marker/resto.png')}}";
  $(document).ready(function(){
    $('#btn-simpan').click(function(){
      $('#form-data').submit();
    });

    $('#btn-batal').click(function(){
      window.location.href = "{{url('/admin/fasilitas/tempatmakan')}}"; 
    });

    $('.summernote').summernote();
    initMap();
  });

  function initMap() {
    // The location of Uluru
    //-8.469175816336243, 115.20347722623673
    const pengempu = { lat: -8.469175816336243, lng: 115.20347722623673 };
    // The map, centered at Uluru
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 15,
      center: pengempu,
    });
    // The marker, positioned at Uluru
    const center = new google.maps.Marker({
      position: pengempu,
      map: map,
    });

    //fetch map on database
    let markers_db = [];
    markers_db.push({!!$data->geo_location!!});
    for (let i = 0; i < markers_db.length; i++) {
      const marker = new google.maps.Marker({
        position: new google.maps.LatLng(markers_db[i]['lat'], markers_db[i]['lng']),
        icon: image,
        map: map,
      });
      markers.push(marker);
    }

    // This event listener calls addMarker() when the map is clicked.
    google.maps.event.addListener(map, "click", (event) => {
      deleteMarkers();
      addMarker(event.latLng, map);
    });
    // Add a marker at the center of the map.
    //addMarker(center, map);
  }

// Adds a marker to the map.
function addMarker(location, map) {
  // Add the marker at the clicked location, and add the next-available label
  // from the array of alphabetical characters.
  const marker = new google.maps.Marker({
    position: location,
    icon: image,
    map: map,
  });
  markers.push(marker);
  $('#geo_location').val(JSON.stringify(location.toJSON()));
  console.log(markers);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

</script>
@endsection
