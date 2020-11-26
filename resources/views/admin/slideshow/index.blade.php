@extends('layout')
@section('content')
<section class="content-header">
	<h1>
		Add Slideshow
		<small>AUN Universitas Udayana</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Slideshow</a></li>
		<li class="active">Add Slideshow</li>
	</ol>
</section>
<section class="content">
	<div class="box box-info">
		<div class="box-header">
	        <h3 class="box-title">
	          Add Slideshow
	        </h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			{!! Form::open(array('url'=>'page','files' => true)) !!}
              <div class="box-body">
              	<div class="row">
              		<div class="col-md-8">
		                <div class="form-group">
		                	{!! Form::label('judul_ina', 'Judul Ina*') !!}
		                	{!! Form::text('judul_ina', null, ['class' => 'form-control', 'placeholder' => 'Kategori Ina','required'=>'required','id'=>'judul_ina']) !!}
		                </div>
	              	</div>
                    <div class="col-md-4">
						<div class="form-group">
						{!! Form::label('tanggal_publish', 'Tanggal Publish*') !!}
						<div class="input-group date">
							<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
							</div>
							{!! Form::text('tanggal_publish', date('d/m/Y'), ['class' => 'form-control pull-right datepicker', 'placeholder' => 'Tanggal Publish','required'=>'required','id'=>'created_at']) !!}
						</div>

                      </div>
                    </div>	
	            	<div class="col-md-12">
						<div class="form-group">
						{!! Form::label('konten_ina', 'Konten Ina*') !!}
						<textarea class="form-control summernote" id="konten_ina" name="konten_ina" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						</div>
                	</div>
                	<!-- <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="form-group">
                          <label>Cover*</label>
                          <div id="foto-fileframe" class="fileframe"></div>
                          <input type="hidden" name="ko_foto" id="ko_foto" class="form-control"/>
                          <input type="hidden" name="tmp_foto" id="tmp_foto" class="form-control"/>
                          <input type="hidden" name="tmp_cover" id="tmp_cover" class="form-control"/>
                        </div>
                    </div> -->
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('judul_eng', 'Title Eng*') !!}
		                	{!! Form::text('judul_eng', null, ['class' => 'form-control', 'placeholder' => 'Title Eng','required'=>'required','id'=>'judul_eng']) !!}
		                </div>
	            	</div>  
	            	<div class="col-md-12">
						<div class="form-group">
						{!! Form::label('konten_eng', 'Content Eng*') !!}
						<textarea class="form-control summernote" id="konten_eng" name="konten_eng" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						</div>
	                </div> 
	                <div class="form-group">
						<div class="col-md-12" style="padding-right:30px;">
							<div class="btn-group pull-right">
								<button class="btn btn-xs btn-primary" type="button" id="btn_file" class="btn_file" data-template="file">Tambah Tugas</button>
							</div>
						</div>
					</div>
					<hr>
	                <div class="main_tmp">
						<div class="form-group">
							<div class="col-md-3">
								{!! Form::label('file_lampiran_', 'File Lampiran*') !!}
								{!! Form::file('file_lampiran[]', ['id'=>'file_lampiran1','class' => 'filex', 'placeholder' => 'File Lampiran']) !!}
							</div>
							<div class="col-md-9">
								{!! Form::label('deskripsi_file_', 'Deskripsi File*') !!}
								{!! Form::text('deskripsi_file[]', NULL, ['id'=>'deskripsi_file1','class' => 'form-control', 'placeholder' => 'Deskripsi File']) !!}
							</div>
						</div>
					</div>
					<div class="hide" id="fileTemplate">
						<div class="form-group">
							<div class="col-md-3">
								{!! Form::label('file_lampiran_', 'File Lampiran*') !!}
								{{ Form::file('', ['class' => 'tmp_file_lampiran ']) }}
							</div>
							<div class="col-md-8">
								{!! Form::label('deskripsi_tugas_', 'Deskripsi Tugas*') !!}
								{!! Form::text('', NULL, ['class' => 'form-control tmp_deskripsi_file', 'placeholder' => 'Deskripsi Tugas']) !!}
							</div>
							<div class="col-md-1" style="margin-top: 32px;margin-left: -15px;">
								<a href="javascript:;" class="removeButton" data-template="file" ><i class="fa fa-trash"></i></a>
							</div>
						</div>
					</div>        	
              	</div>
              	
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary flat">Submit</button>
                <button type="reset" class="btn btn-danger flat">Reset</button>
              </div>
            {!! Form::close() !!}
		</div><!-- /.box-body -->
	</div><!-- /.box-body out -->
</section><!-- /.content -->

@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('.summernote').summernote({
			height: 230,
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
				['insert', ['link','picture']],
				//['view', ['fullscreen', 'codeview']],
				//['misc', ['undo','redo']]
			]
		});

		

    	$('#btn_file').on('click', function() {
			var index = $(this).data('index');
			if (!index) {
				index = 1;
				$(this).data('index', 1);
			}
			index++;
			$(this).data('index', index);

			var template     = $(this).attr('data-template'),
				$templateEle = $('#' + template + 'Template'),
				$row         = $templateEle.clone().attr('id','ele_wrap'+index).insertBefore($templateEle).removeClass('hide'),
				$el1         = $row.find('input.tmp_deskripsi_file').eq(0).attr('name', 'deskripsi_file[]').attr('id','deskripsi_file'+index);
				$el2         = $row.find('input.tmp_file_lampiran').eq(0).attr('name', 'file_lampiran[]').attr('id','file_lampiran'+index);
				$row.on('click', '.removeButton', function(e) {
	               
	                $row.remove();
	            });
		});
	    /*$("#btnfile").on("click",function(){
	    	$("#frm_tgs").fadeIn("slow");
	    	$("#tbl_tgs").hide();
	    	$("#btnTgs").hide();
	    	$("#btnSmpTgs").show();
	    	$("#btnCclTgs").show();
	    });*/
	})
	function sendFile(file, el) {
        var form_data = new FormData();
        form_data.append('file', file);

        $.ajax({
          data: form_data,
          type: "POST",
          url: 'sendFile',
          headers: {
				   'X-CSRF-TOKEN': $('input[name="_token"]').val()
			  },
          cache: false,
          contentType: false,
          enctype: 'multipart/form-data',
          processData: false,
          success: function(url) {
            $(el).summernote('editor.insertImage', url);
          }
        });
      }
</script>
@endsection
