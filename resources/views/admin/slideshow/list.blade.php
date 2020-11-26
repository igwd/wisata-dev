@extends('layout/app')

@section('title')
	Slide Show
	<small>List</small>
@endsection

@section('content')
	@if (Session::has('message'))
    <div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<table  id="tbSlideShow" class="table table-bordered table-striped table-hover" width="100%">
						<thead>
						    <tr>
						        <th width="5%">No.</th>
						        <th width="20%">Judul</th>
						        <th width="20%">Image</th>
						        <th width="5%">Status</th>
						        <th width="5%">Action</th>
						    </tr>
					    </thead>
					    <tbody>

					    </tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box-body out -->
		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var tbSlideShow = $('#tbSlideShow').dataTable( {
			processing: true,
	        serverSide: true,
	        ajax: '{{ url("admin/slideshow/tb") }}',
	        columns: [
	            {data: 'no', name: 'no',width:"2%"},
	            {data: 'judul', name: 'judul'},
	            {data: 'images', name: 'images',searchable: false},        	            
	            {data: 'status_id', name: 'status_id',searchable: false},        	            
	            {data: 'action', name: 'action',searchable: false},        	            
	        ],
	        rowCallback: function( row, data, iDisplayIndex ) {
				var api = this.api();
				var info = api.page.info();
				var page = info.page;
				var length = info.length;
				var index = (page * length + (iDisplayIndex +1));
				$('td:eq(0)', row).html(index);
			}

		} );
					
		$('#tbSlideShow_filter input').unbind();
		$('#tbSlideShow_filter input').bind('keyup', function(e) {
			if(e.keyCode == 13) {
				tbperiode.fnFilter(this.value);
			 }
		}); 
	})
	function delSlider(id){
		var txt;
	    var r = confirm("Apakah anda yakin ?");
	    if (r == true) {
	        $.ajax({
	          url : '{{ url("admin/slideshow") }}/'+id,
	          headers: {
	            'X-CSRF-TOKEN': '{{ csrf_token() }}'
	          },
	          type : 'DELETE',
	          dataType : 'json',
	          success:function(data){
	              if(data.submit=='1'){
	                //swal("Deleted!", "Your data has been deleted.", "success");
	                var tbSlideShow = $('#tbSlideShow').dataTable();
	                tbSlideShow.api().ajax.reload();
	                location.href = "{{ url('admin/slideshow/list') }}";
	              }else{
	                //swal("Failed!", "Your data failed to delete.", "danger");           
	              }
	            }
	        })
	    } else {

	    } 
	}
	function aktifSlider(id){
		$.ajax({
			url : '{{ url("admin/slideshow/aktifSlideShow") }}',
			data : 'id='+id,
			type : 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			dataType : 'json',
			success : function(data){
				if(data.submit==1){
					//swal("Updated!", "Your data has been updated.", "success");
					var tbSlideShow = $('#tbSlideShow').dataTable();
					tbSlideShow.api().ajax.reload();
				}else{
					//swal("Failed!", "Your data failed to delete.", "danger");		
				}
			}
		})
	}
</script>
@endsection
