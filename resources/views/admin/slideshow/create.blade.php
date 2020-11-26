@extends('layout/app')

@section('title')
	Slide Show
	<small>Create</small>
@endsection

@section('content')
@if (Session::has('message'))
<div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
{!! Form::open(array('url'=>'admin/slideshow','files'=>true,'class'=>'validated_form')) !!}
<div class="row">
  	<div class="col-md-12">
		<div class="box box-solid">
          	<div class="box-body">
            	<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('image', 'File Image*') !!}
							{!! Form::file('image', ['id'=>'image','class' => 'file', 'placeholder' => 'File Image','accept'=>'image/*']) !!}
						</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						{!! Form::label('judul','Judul*')!!}
						{!! Form::text('judul', NULL, ['id'=>'judul','class' => 'form-control required', 'placeholder' => 'Judul']) !!}
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						{!! Form::label('deskripsi','Deskripsi')!!}
						{!! Form::textarea('deskripsi', NULL, ['id'=>'deskripsi','class' => 'form-control summernote', 'placeholder' => 'Deskripsi']) !!}
					</div>
				</div>
          	</div>
          <!-- /.box-body -->
		</div><!-- /.box-body out -->
	</div>
</div>
<br>
<div class="row">
  	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">
	              <!-- /.box-body -->
				<div class="box-footer">
					<center>
						<button type="submit" class="btn btn-primary flat">Submit</button>
						<button type="reset" class="btn btn-danger flat">Reset</button>
					</center>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box-body out -->
	</div>
</div>
{!! Form::close() !!}
<!-- Modal -->
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('.summernote').summernote({
			height: 480,
			minHeight: null,
			maxHeight: null,
			focus: false,
			callbacks: {
				onImageUpload: function(files, editor, welEditable) {
				  for (var i = files.length - 1; i >= 0; i--) {
				    sendFile(files[i], this);
				  }
				},
				onInit: function() {
				  var noteBtn = '<button id="upload_gambar" type="button" class="btn btn-default btn-sm btn-small" title="Upload Images" data-event="something" tabindex="-1"><i class="fa fa-file-image-o"></i></button>';
				  
				  var fileGroup = '<div class="note-file btn-group">' + noteBtn + '</div>';

				  //$(fileGroup).appendTo($('.note-toolbar'));

				  // Button tooltips
				  $('#upload_gambar').tooltip({
				    container: 'body',
				    placement: 'bottom'
				  });
				  
				  // Button events
				  $('#upload_gambar').click(function(event) {
				    alert('gamaar..');
				  });
				},
			},
			toolbar: [
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['font', ['style','bold', 'italic', 'underline', 'clear']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				//['height', ['height']],
				['table', ['table']],
				/*['insert', ['link','picture']],*/
				//['view', ['fullscreen', 'codeview']],
				//['misc', ['undo','redo']]
			]
		});
	})
</script>
@endsection
