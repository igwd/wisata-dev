<div id="modal-upload" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rating Fasilitas - {{@$fasilitas->nama_fasilitas}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body">
                    <p class="alert" style="display: none"></p>
                    <div class="row">
                        <form id="form-data" name="form-data" action="{{@$action}}">
                            <input type="hidden" name="_method" value="{{@$method}}">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="fasilitas_id" value="{{@$fasilitas->fasilitas_id}}">
                                    <input type="hidden" name="skor" value="{{@$fasilitas->skor}}">
                                    <input type="hidden" name="nama_fasilitas" value="{{@$fasilitas->nama_fasilitas}}">
                                    <label>Nama Responden</label>
                                    <input type="text" name="rf_name" class="form-control" id="rf_name" value="{{@$fasilitas->rf_name}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Responden</label>
                                    <input type="text" name="rf_email" class="form-control" id="rf_email" value="{{@$fasilitas->rf_email}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Komentar Review</label>
                                    <input type="text" name="rf_review" class="form-control" id="rf_review" value="{{@$fasilitas->rf_review}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-proses">Review</button>
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
                    getRatingFasilitas();
                },complete:function(){
                    setTimeout(function(){
                        $('#modal-upload').modal('hide'); 
                    }, 3000);
                }
            })
        });
    });
</script>