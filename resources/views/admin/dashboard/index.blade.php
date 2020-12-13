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

    .max-lines-datatable {
        display: block;/* or inline-block */
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 3.6em;
        line-height: 1.8em;
    }

    .card{
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    @if(Session::has('message'))
        @php $messages = Session::get('message') @endphp
        <p class="alert {{$messages['class']}}">{!! $messages['text'] !!}</p>
    @else
        <p class="alert" style="display: none"></p>
    @endif
    <h1 class="h3 text-gray-800">Dashboard</h1>
    <p class="mb-2">Dashboard admin merupakan halaman yang digunakan untuk mengelola konten yang terdapat pada halaman web</p>
    <!-- Content Row -->
    <div class="row">
    	<div class="col-md-12 card">
    		<div class="card-header">
    			<h6 class="m-0 font-weight-bold text-primary">Pengaturan Slide Show <button id="btn-add-slideshow" class="btn btn-primary btn-sm float-right">Tambah Data</button></h6>
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
    			<h6 class="m-0 font-weight-bold text-primary">Pengaturan Halaman</h6>
    		</div>
    		<div class="card-body table-responsive">
		    	<table id="data-halaman" class="table table-striped" style="width:100%">
                    <thead>
                        <th width="90%">Tampilan</th>
                        <th width="10%">Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
		    </div>
	    </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
	var table_slide_show;
    var table_halaman;
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
                    searchable: true,
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

        $('#data-slide-show_filter input').unbind();
        $('#data-slide-show_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table_slide_show.search(this.value).draw();   
            }
        });

        $('#btn-add-slideshow').click(function(){
            window.location.href="{{url('admin/slideshow/create')}}"
        });

        table_halaman = $('#data-halaman').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("admin/listDataHalaman")}}',
                data: function(d) {
                    /*d.id_universitas = $('#universitas').val();
                    d.id_jenis_lomba = $('#kategori_lomba').val();
                    d.verifikasi = $('#verifikasi').val();*/
                }
            },
            columns: [         
                {
                    data: 'page',
                    name: 'page',
                    orderable: false,
                    searchable: true,
                    class: 'text-left'
                },
                {
                    data: 'aksi',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    class: 'text-center'
                }
            ],
        });
        $('#data-halaman_filter input').unbind();
        $('#data-halaman_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table_halaman.search(this.value).draw();   
            }
        });
    });
	
    function deleteSlideShow(){
        console.log('judul',judul);
        var id = $('.btn-delete').data('id');
        var judul = $('.btn-delete').data('judul');
        var file = $('.btn-delete').data('file');
        var confirm = window.confirm("Hapus data Slide Show "+judul+" ?");
        if (confirm) {
            $.ajax({
              url : '{{url("admin/slideshow")}}/'+id+"/destroy",
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              data:{'id':id,'judul':judul,'file':file},
              type : 'DELETE',
              success:function(data){
                $('.alert').removeClass('alert-success alert-danger');
                $('.alert').css('display','none');
                $('.alert').addClass(data.class);
                $('.alert').html(data.text);
                $('.alert').css('display','block');
                table_slide_show.ajax.reload();
              }
            });
        }
    }
</script>
@endsection