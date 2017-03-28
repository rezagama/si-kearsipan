$(document).ready(function(){
  var base = window.location.protocol+'//'+window.location.host;

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });

  var data = [{
    arsip_aktif: 0,
    arsip_inaktif: 0,
    arsip_statis: 0,
    arsip_musnah: 0,
    arsip_lain: 0
  }];

  renderChart(data);

  $.ajax({
      type: "GET",
      url: base + '/statistik/jenis/arsip',
      success: function (data) {
          renderChart(data);
      },
      error: function (data) {
          console.log('Error:', data);
      }
  });

  function renderChart(data){
    $(function () {
        $('#chart').highcharts({
            chart: {
                type: 'column',
                height: 450
            },

            title: {
                text: 'Jumlah Arsip'
            },
            subtitle: {
                text: 'Jumlah Arsip menurut jenisnya'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Jumlah'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:1f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:2f}</b><br/>'
            },

            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: [{
                    name: 'Arsip Aktif',
                    y: data['arsip_aktif'],
                    drilldown: 'Arsip Aktif'
                }, {
                    name: 'Arsip Inaktif',
                    y: data['arsip_inaktif'],
                    drilldown: 'Arsip Inaktif'
                }, {
                    name: 'Arsip Statis',
                    y: data['arsip_statis'],
                    drilldown: 'Arsip Statis'
                }, {
                    name: 'Arsip Dimusnakan',
                    y: data['arsip_dimusnahkan'],
                    drilldown: 'Arsip Dimusnakan'
                }, {
                    name: 'Arsip Lain-lain',
                    y: data['arsip_lain'],
                    drilldown: 'Arsip Lain-lain'
                }]
            }]
        });
    });
  }
});
