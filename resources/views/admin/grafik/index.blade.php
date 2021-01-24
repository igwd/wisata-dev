@extends('admin.template')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="row" style="width: 100%">
            <div class="col-md-10" style="width: 100%">
                <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Grafik Kunjungan</h1>
            </div>
            <div class="col-md-2" style="width: 100%;padding:0px">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input readonly type="text" style="text-align: right" name="tahun-kunjungan" id="tahun-kunjungan" class="form-control" value="{!!date('Y')!!}">
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-kunjungan">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan Tiket</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-pendapatan">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="min-height:360px">
                    <div class="chart-area">
                        <canvas id="myAreaChartKunjungan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Kategori Tiket</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="min-height:360px">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChartKunjungan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan Tiket</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="min-height:360px">
                    <div class="chart-area">
                        <canvas id="myAreaChartPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Metode Pembayaran</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="min-height:360px">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChartPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script type="text/javascript">
var myLineChartKunjungan,myPieChartKunjungan,myLineChartPendapatan,myPieChartPendapatan;
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
$(document).ready(function(){
    $('#tahun-kunjungan').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose:true,
    }).on('changeDate', function(e) {
        getGrafikKunjungan();         
    });

    getGrafikKunjungan();

    var ctxAreaKunjungan = document.getElementById("myAreaChartKunjungan");
    myLineChartKunjungan = new Chart(ctxAreaKunjungan, {
      type: 'line',
      data: {
        labels:[],
        datasets: [{
          label: "Kunjungan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [],
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return '' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: true
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });


    var ctxPieKunjungan = document.getElementById("myPieChartKunjungan");
    myPieChartKunjungan = new Chart(ctxPieKunjungan, {
      type: 'pie',
      data: {
        labels: [],
        datasets: [{
          data: [],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 0,
      },
    });


    var ctxAreaPendapatan = document.getElementById("myAreaChartPendapatan");
    myLineChartPendapatan = new Chart(ctxAreaPendapatan, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          label: "Pendapatan",
          backgroundColor: "#4e73df",
          hoverBackgroundColor: "#2e59d9",
          borderColor: "#4e73df",
          data: [],
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 6
            },
            maxBarThickness: 25,
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return 'Rp.' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: true
        },
        tooltips: {
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
            }
          }
        },
      }
    });

    var ctxPiePendapatan = document.getElementById("myPieChartPendapatan");
    myPieChartPendapatan = new Chart(ctxPiePendapatan, {
      type: 'doughnut',
      data: {
        labels: [],
        datasets: [{
          data: [],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          callbacks: {
            // this callback is used to create the tooltip label
            label: function(tooltipItem, data) {
              // get the data label and data value to display
              // convert the data value to local string so it uses a comma seperated number
              var dataLabel = data.labels[tooltipItem.index];
              var value = ': Rp. ' + number_format(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], 0, ',', '.');
              //data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString();

              // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
              if(Chart.helpers.isArray(dataLabel)) {
                // show value on first line of multiline label
                // need to clone because we are changing the value
                dataLabel = dataLabel.slice();
                dataLabel[0] += value;
              }else{
                dataLabel += value;
              }
              // return the text to display on the tooltip
              return dataLabel;
            }
          }
        },
        legend: {
          display: true
        },
        cutoutPercentage: 30,
      },
    });
});

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example

function getGrafikKunjungan(){
    $.ajax({
        url: "{{url('/admin/grafik/kunjungan')}}",
        data:{'tahun':$('#tahun-kunjungan').val()},
        method: "GET",
        success: function(response) {
            //console.log(data);
            var labelMonth = [];
            var valueMonth = [];

            var labelPieKategoriTiket = [];
            var valuePieKategoriTiket = [];

            var valuePendapatanMonth = [];

            var labelPiePendapatanMetodeBayar = [];
            var valuePiePendapatanMetodeBayar = [];

            var total_kunjungan = 0;
            var total_pendapatan = 0;
            $.each(response, function(i, item) {
                total_kunjungan += item.qty;
                total_pendapatan += item.nominal;
                var check_month = jQuery.inArray(item.bulan, labelMonth);
                if(check_month < 0){
                    labelMonth.push(item.bulan);
                    valueMonth.push(item.qty);
                    valuePendapatanMonth.push(item.nominal);
                }else{
                    var index = labelMonth.indexOf(item.bulan);
                    valueMonth[index] += item.qty;
                    valuePendapatanMonth[index] += item.nominal;
                }

                var check_cat_tiket = jQuery.inArray(item.category, labelPieKategoriTiket);
                if(check_cat_tiket < 0){
                    labelPieKategoriTiket.push(item.category);
                    valuePieKategoriTiket.push(item.qty);
                }else{
                    var index = labelPieKategoriTiket.indexOf(item.category);
                    valuePieKategoriTiket[index] += item.qty;
                }

                var check_metode_bayar = jQuery.inArray(item.jenis_pembayaran, labelPiePendapatanMetodeBayar);
                if(check_metode_bayar < 0){
                    labelPiePendapatanMetodeBayar.push(item.jenis_pembayaran);
                    valuePiePendapatanMetodeBayar.push(item.nominal);
                }else{
                    var index = labelPiePendapatanMetodeBayar.indexOf(item.jenis_pembayaran);
                    valuePiePendapatanMetodeBayar[index] += item.nominal;
                }                
            });

            //remove previous data            
            myLineChartKunjungan.data.labels.pop();
            myLineChartKunjungan.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            myLineChartKunjungan.update();

            //add new data to chart
            if(labelMonth.length > 0){
                $.each(labelMonth,function(i,item){
                    myLineChartKunjungan.data.labels.push(labelMonth[i]);
                    myLineChartKunjungan.data.datasets.forEach((dataset) => {
                        dataset.data.push(valueMonth[i]);
                    });
                });
            }
            myLineChartKunjungan.update();

            //remove previous data
            myPieChartKunjungan.data.labels.pop();
            myPieChartKunjungan.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            myPieChartKunjungan.update();

            //add new data to chart
            if(labelPieKategoriTiket.length > 0){
                $.each(labelPieKategoriTiket,function(i,item){
                    myPieChartKunjungan.data.labels.push(labelPieKategoriTiket[i]);
                    myPieChartKunjungan.data.datasets.forEach((dataset) => {
                        dataset.data.push(valuePieKategoriTiket[i]);
                    });
                });
            }
            myPieChartKunjungan.update();

            // chart-pendapatan
            // myLineChartPendapatan | myPieChartPendapatan

            //remove previous data            
            myLineChartPendapatan.data.labels.pop();
            myLineChartPendapatan.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            myLineChartPendapatan.update();

            //add new data to chart
            if(labelMonth.length > 0){
                $.each(labelMonth,function(i,item){
                    myLineChartPendapatan.data.labels.push(labelMonth[i]);
                    myLineChartPendapatan.data.datasets.forEach((dataset) => {
                        dataset.data.push(valuePendapatanMonth[i]);
                    });
                });
            }
            myLineChartPendapatan.update();

            //remove previous data
            myPieChartPendapatan.data.labels.pop();
            myPieChartPendapatan.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            myPieChartPendapatan.update();

            console.log(valuePiePendapatanMetodeBayar);
            //add new data to chart
            if(labelPiePendapatanMetodeBayar.length > 0){
                $.each(labelPiePendapatanMetodeBayar,function(i,item){
                    myPieChartPendapatan.data.labels.push(labelPiePendapatanMetodeBayar[i]);
                    myPieChartPendapatan.data.datasets.forEach((dataset) => {
                        dataset.data.push(valuePiePendapatanMetodeBayar[i]);
                    });
                });
            }
            myPieChartPendapatan.update();

            $('#total-kunjungan').html(number_format(total_kunjungan, 0, ',', '.'));
            $('#total-pendapatan').html('Rp.'+number_format(total_pendapatan, 2, ',', '.'));
        }
    });
}
</script>
@endsection