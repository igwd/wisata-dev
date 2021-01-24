<div id="modal-upload" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting User</h5>
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
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{@$user->name}}" required {!!($tipe == 'resetpassword'? 'readonly' :'')!!}>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username/Email</label>
                                <input type="text" name="email" class="form-control" id="email" value="{{@$user->email}}" required {!!($tipe == 'resetpassword' ? 'readonly' :'')!!}>
                            </div>
                        </div>
                        @if($tipe == 'resetpassword' || $tipe=='create')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password" value="" required>
                            </div>
                        </div>
                        @endif
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