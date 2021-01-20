<div id="modal-upload" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body">
                    <p class="alert" style="display: none"></p>
                    <input type="hidden" name="group_kategori" id="group_kategori" value="{{$group_kategori}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="data-fasilitas" class="table table-bordered table-responsive">
                                    <thead>
                                        <th width="70%">Nama Fasilitas</th>
                                        <th width="10%">Aksi</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var tabel_fasilitas;
$(document).ready(function(){
    $('#modal-upload').modal('show');

    tabel_fasilitas = $('#data-fasilitas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{url("admin/tiket/listDataFasilitas")}}',
          data: function(d) {
            d.group_kategori = $('#group_kategori').val();
          }
        },
        columns: [         
          {
            data: 'fasilitas',
            name: 'fasilitas',
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
        ]
    });

    $('#data-fasilitas_filter input').unbind();
    $('#data-fasilitas_filter input').bind('keyup', function(e) {
        if(e.keyCode == 13) {
          tabel_fasilitas.search(this.value).draw();   
        }
    });
});
</script>