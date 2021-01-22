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
                    <input type="hidden" name="index" id="index-f" value="{{$index}}">
                    <input type="text" name="selected" id="selected" value="{{$selected}}">
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
            d.selected = $('#selected').val();
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

function pilihFasilitas(data,act){
    //data = JSON.parse(data);
    var group = $('#group_kategori').val();
    var table_id = '';
    var index = $('#index-f').val();
    if(act){
        if(group == "TEMPAT_MAKAN"){
            table_id = 'table-kuliner'
        }else if(group == "PENGINAPAN"){
            table_id = 'table-penginapan';
        }else if(group == 'TRANSPORT'){
            table_id = 'table-transport';
        }

        $('#'+table_id+' #booking_id'+index).val(data.tiket_id);
        $('#'+table_id+' #booking_name'+index).val(data.booking_name);
        $('#'+table_id+' #harga'+index).val(data.itd_nominal);
        $('#'+table_id+' #qty'+index).val(data.itd_qty);
        $('#'+table_id+' #qty'+index).attr('data-harga',data.itd_nominal);
        $('#'+table_id+' #qty'+index).attr('data-tiketid',data.tiket_id);
        $('#'+table_id+' #subtotal'+index).val(data.itd_subtotal);

        //change subtotal format
        var sanitized = $('#'+table_id+' #subtotal'+index).val().replace(/[^-.0-9]/g, '');
        // Remove non-leading minus signs
        sanitized = sanitized.replace(/(.)-+/g, '$1');
        // Remove the first point if there is more than one
        sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
        // Update value
        var value = sanitized,
        plain = plainNumber(value),
        reversed = reverseNumber(plain),
        reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
        normal = reverseNumber(reversedWithDots);
        $('#'+table_id+' #subtotal'+index).val(normal);

        hitungTrx();

        $('#modal-upload').modal('hide');
    }
    //$('#modal-upload').modal('hide');
    var newindex = parseInt($('#index').val())+1;
    $('#index').val(newindex);
    if(group == "TEMPAT_MAKAN" && act){
        addRowKuliner(newindex);
    }else if(group == "PENGINAPAN" && act){
        addRowPenginapan(newindex);
    }else if(group == 'TRANSPORT' && act){
        addRowTransport(newindex);
    }
}
</script>