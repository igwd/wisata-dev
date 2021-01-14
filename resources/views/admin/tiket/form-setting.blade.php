<div id="modal-upload" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body">
                    <p class="alert" style="display: none"></p>
                    <form id="form-data" name="form-data" action="{{@$action}}">
                        <input type="hidden" name="_method" value="{{@$method}}">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Tiket</label>
                                <input type="text" name="mt_nama_tiket" class="form-control" id="mt_nama_tiket" value="{{@$tiket->mt_nama_tiket}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan Tiket</label>
                                <input type="text" name="mt_keterangan" class="form-control" id="mt_keterangan" value="{{@$tiket->mt_keterangan}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Harga Tiket</label>
                                <input type="number" name="mt_harga" class="form-control" id="mt_harga" value="{{@$tiket->mt_harga}}" required>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-proses">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-upload').modal('show');

        $('#btn-proses').click(function(e){
            e.preventDefault();
            $.ajax({
                url:"{{@$action}}",
                data:$('#form-data').serialize(),
                type:"{{@$method}}",
                success:function(data){
                    $('#modal-upload .alert').removeClass('alert-success alert-danger');
                    $('#modal-upload .alert').css('display','none');
                    $('#modal-upload .alert').addClass(data.class);
                    $('#modal-upload .alert').html(data.text);
                    $('#modal-upload .alert').css('display','block');
                    table_tiket.ajax.reload();
                },complete:function(){
                    setTimeout(function(){
                        $('#modal-upload').modal('hide'); 
                    }, 1000);
                }
            })
        });
    });
</script>