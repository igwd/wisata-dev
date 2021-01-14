<div id="modal-upload" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Bayar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body">
                    <p class="alert" style="display: none"></p>
                    <form id="form-data" name="form-data"enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nomor Rekening Dituju</label>
                                <input type="text" name="no_rekening" class="form-control" id="no_rekening" value="{{$invoice->no_rekening}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Gambar</label>
                                <input type="hidden" name="url_gambar" id="url_gambar" value="{{$invoice->file_bukti}}">
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                        </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-upload">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-upload').modal('show');

        $('#btn-upload').click(function(e){
            e.preventDefault();
            $.ajax({
                url:"{{url('/')}}/booking/{{$invoice->it_kode_unik}}/upload",
                data:$('#form-data').serialize(),
                type:"PUT",
                success:function(data){
                    $('#modal-upload .alert').removeClass('alert-success alert-danger');
                    $('#modal-upload .alert').css('display','none');
                    $('#modal-upload .alert').addClass(data.class);
                    $('#modal-upload .alert').html(data.text);
                    $('#modal-upload .alert').css('display','block');
                    table_tiket.ajax.reload();
                }
            })
        });
    });
</script>