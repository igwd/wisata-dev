@extends('layout/app')

@section('title')
	Slide Show
	<small>Show</small>
@endsection

@section('content')
	<div class="box box-info">
		<div class="box-header">
	        <h3 class="box-title">
	          Detail Slide Show
	        </h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<table class="table table-striped table-condensed table-hover table-bordered">
				<tbody>
					<tr>
						<td width="15%" style="font-weight: bold">Judul</td>
						<td width="1%">:</td>
						<td>{!! $data->judul !!}</td>
					</tr>
					<tr>
						<td style="font-weight: bold">Deskripsi</td>
						<td>:</td>
						<td>{!! $data->deskripsi !!}</td>
					</tr>
					<tr>
						<td style="font-weight: bold">Image</td>
						<td>:</td>
						<td>
							<img src="{{ url($data->image) }}" width="80%">		
						</td>
					</tr>
					<tr>
						<td style="font-weight: bold">Created At</td>
						<td>:</td>
						<td>{{ $data->created_at }}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center">
							<a class="btn btn-info btn-sm btn-flat" href="{{url('admin/slideshow/list')}}"><i class="fa fa-reply"></i> Back</a>
							<a class="btn btn-warning btn-sm btn-flat" href="{{url('admin/slideshow/'.$data->id.'/edit')}}"><i class="fa fa-edit"></i> Edit</a>
							<button class="btn btn-danger btn-sm btn-flat" onclick="delSlider({{ $data->id }})"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box-body out -->

@endsection

@section('script')
<script type="text/javascript">
	function delImg(id){
	    swal({
	      title: "Are you sure?",
	      text: "You will not be able to recover this imaginary file!",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Yes, delete it!",
	      cancelButtonText: "No, cancel!",
	      closeOnConfirm: false,
	      closeOnCancel: false
	    },
	    function(isConfirm){
	      if (isConfirm) {
	      $.ajax({
	        url : '/dualbahasa/delImg?id='+id,
	        dataType : 'html',
	        success:function(data){
	            if(data=='1'){
	              swal("Deleted!", "Your data has been deleted.", "success");
	              location.reload();
	            }else{
	              swal("Failed!", "Your data failed to delete.", "danger");           }
	          }
	      })
	      } else {
	        swal("Cancelled", "Your imaginary file is safe :)", "error");
	      }
	    });
    }
    
    function delSlider(id){
	    swal({
	      title: "Are you sure?",
	      text: "You will not be able to recover this imaginary file!",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Yes, delete it!",
	      cancelButtonText: "No, cancel!",
	      closeOnConfirm: false,
	      closeOnCancel: false
	    },
	    function(isConfirm){
	      if (isConfirm) {
	      $.ajax({
			url : '{{ url("slideshow") }}/'+id,
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			type : 'DELETE',
			dataType : 'json',
	        success:function(data){
	            if(data.submit=='1'){
	              swal("Deleted!", "Your data has been deleted.", "success");
	              location.href = "{{ url('slideshow/list') }}";
	            }else{
	              swal("Failed!", "Your data failed to delete.", "danger");           }
	          }
	      })
	      } else {
	        swal("Cancelled", "Your imaginary file is safe :)", "error");
	      }
	    });
    }
</script>
@endsection
