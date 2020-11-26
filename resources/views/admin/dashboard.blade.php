@extends('admin.template')
@section('content')
<!-- Main style sheet -->
<link href="public/site/assets/css/style.css" rel="stylesheet">
<style type="text/css">
	#mu-slider {
	    min-height: 340px!important;
   	}

	.card-header {
	    padding: .75rem 1.25rem;
	    margin-bottom: 0;
	    background-color: #ffffff !important;
	    border-bottom: 1px solid #e3e6f0;
	}

	#mu-slider .mu-slider-single {
	    min-height: 340px !important;
	}

	#mu-slider .mu-slider-single .mu-slider-content {
	    top: 10% !important;
	}

	#mu-slider .mu-slider-single .mu-slider-content a {
	    margin-top: 5px !important; 
	}

	.slider-action{
		position: relative !important;
	    z-index: 99999 !important;
	}
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Dashboard</h1>
    <p class="mb-2">Dashboard admin merupakan halaman yang digunakan untuk mengelola konten yang terdapat pada halaman web, yaitu <i>slide show</i> dan <i>about</i></p>
    <!-- Content Row -->
    <div class="row">
    	<div class="col-md-12 card">
    		<div class="card-header">
    			<h6 class="m-0 font-weight-bold text-primary">Pengaturan Slide Show <button class="btn btn-primary btn-sm float-right">Tambah Data</button></h6>
    		</div>
    		<div class="card-body table-responsive">
		    	<table id="data-slide-show" class="" style="width:100%">
		            <thead>
		            	<th>Data Slide Show</th>
		            </thead>
		            <tbody></tbody>
		        </table>
		    </div>
	    </div>
    </div>
    <div class="row">
    	<div class="col-md-12 card">
    		<div class="card-header">
    			<h6 class="m-0 font-weight-bold text-primary">Halaman About</h6>
    		</div>
    		<div class="card-body">
		    	
		    </div>
	    </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
	var table_slide_show;
	$(document).ready(function() {
        table_slide_show = $('#data-slide-show').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("admin/listDataSlideShow")}}',
                data: function(d) {
                    /*d.id_universitas = $('#universitas').val();
                    d.id_jenis_lomba = $('#kategori_lomba').val();
                    d.verifikasi = $('#verifikasi').val();*/
                }
            },
            columns: [         
                {
                    data: 'slideshow',
                    name: 'slideshow',
                    orderable: false,
                    searchable: false,
                    class: 'text-center'
                }
            ],
            "lengthMenu": [[1, 5, 10, -1],[1, 5, 10, "All"]]
            /*rowCallback: function(row, data, iDisplayIndex) {
                var api = this.api();
                var info = api.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (iDisplayIndex + 1));
                $('td:eq(0)', row).html(index);
            },
            stateSaveCallback: function(settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
            },
            drawCallback: function(settings) {
                var api = this.api();
            }*/
        });
    });
	
</script>
@endsection