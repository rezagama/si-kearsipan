$(function () {
    $('#jumlah').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Akses Arsip'
        },
        subtitle: {
            text: 'Jumlah akses arsip menurut jenisnya'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Akses'
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
            name: 'Jumlah Akses',
            colorByPoint: true,
            data: [{
                name: 'Arsip Aktif',
                y: 152,
                drilldown: 'Arsip Aktif'
            }, {
                name: 'Arsip Inaktif',
                y: 125,
                drilldown: 'Arsip Inaktif'
            }, {
                name: 'Arsip Statis',
                y: 95,
                drilldown: 'Arsip Statis'
            }, {
                name: 'Arsip Dimusnakan',
                y: 100,
                drilldown: 'Arsip Dimusnakan'
            }, {
                name: 'Arsip Lain-lain',
                y: 70,
                drilldown: 'Arsip Lain-lain',
            }]
        }],
        drilldown: {
            series: [{
                name: 'Microsoft Internet Explorer',
                id: 'Microsoft Internet Explorer',
                data: [
                    [
                        'v11.0',
                        24.13
                    ],
                    [
                        'v8.0',
                        17.2
                    ],
                    [
                        'v9.0',
                        8.11
                    ],
                    [
                        'v10.0',
                        5.33
                    ],
                    [
                        'v6.0',
                        1.06
                    ],
                    [
                        'v7.0',
                        0.5
                    ]
                ]
            }, {
                name: 'Chrome',
                id: 'Chrome',
                data: [
                    [
                        'v40.0',
                        5
                    ],
                    [
                        'v41.0',
                        4.32
                    ],
                    [
                        'v42.0',
                        3.68
                    ],
                    [
                        'v39.0',
                        2.96
                    ],
                    [
                        'v36.0',
                        2.53
                    ],
                    [
                        'v43.0',
                        1.45
                    ],
                    [
                        'v31.0',
                        1.24
                    ],
                    [
                        'v35.0',
                        0.85
                    ],
                    [
                        'v38.0',
                        0.6
                    ],
                    [
                        'v32.0',
                        0.55
                    ],
                    [
                        'v37.0',
                        0.38
                    ],
                    [
                        'v33.0',
                        0.19
                    ],
                    [
                        'v34.0',
                        0.14
                    ],
                    [
                        'v30.0',
                        0.14
                    ]
                ]
            }, {
                name: 'Firefox',
                id: 'Firefox',
                data: [
                    [
                        'v35',
                        2.76
                    ],
                    [
                        'v36',
                        2.32
                    ],
                    [
                        'v37',
                        2.31
                    ],
                    [
                        'v34',
                        1.27
                    ],
                    [
                        'v38',
                        1.02
                    ],
                    [
                        'v31',
                        0.33
                    ],
                    [
                        'v33',
                        0.22
                    ],
                    [
                        'v32',
                        0.15
                    ]
                ]
            }, {
                name: 'Safari',
                id: 'Safari',
                data: [
                    [
                        'v8.0',
                        2.56
                    ],
                    [
                        'v7.1',
                        0.77
                    ],
                    [
                        'v5.1',
                        0.42
                    ],
                    [
                        'v5.0',
                        0.3
                    ],
                    [
                        'v6.1',
                        0.29
                    ],
                    [
                        'v7.0',
                        0.26
                    ],
                    [
                        'v6.2',
                        0.17
                    ]
                ]
            }, {
                name: 'Opera',
                id: 'Opera',
                data: [
                    [
                        'v12.x',
                        0.34
                    ],
                    [
                        'v28',
                        0.24
                    ],
                    [
                        'v27',
                        0.17
                    ],
                    [
                        'v29',
                        0.16
                    ]
                ]
            }]
        }
    });
});

Highcharts.chart('pertambahan', {

    title: {
        text: 'Pertambahan Arsip'
    },

    yAxis: {
        title: {
            text: 'Jumlah Arsip'
        }
    },

    xAxis: {
        categories: ['2011', '2012', '2013', '2014', '2015', '2016', '2017']
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },


    series: [{
        name: 'Arsip Aktif',
        data: [59, 65, 70, 91, 103, 111, 120]
    }, {
        name: 'Arsip Inaktif',
        data: [71, 82, 90, 93, 101, 105, 109]
    }, {
        name: 'Arsip Statis',
        data: [47, 50, 71, 77, 85, 105, 115]
    }, {
        name: 'Arsip Dimusnahkan',
        data: [52, 70, 90, 112, 131, 169, 180]
    }, {
        name: 'Arsip Lain-lain',
        data: [48, 89, 90, 101, 116, 145, 150]
    }]

});

Highcharts.chart('grafik-kategori', {

    title: {
        text: 'Grafik Jumlah Arsip'
    },

    subtitle: {
        text: 'Jumlah arsip berdasarkan jenisnya'
    },

    yAxis: {
        title: {
            text: 'Jumlah'
        }

    },

    xAxis: {
        categories: ['Arsip Aktif', 'Arsip Inaktif', 'Arsip Statis', 'Arsip Dimusnahkan', 'Arsip Lain-lain']
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: [29.9, 71.5, 106.4, 129.2, 144.0],
        showInLegend: false
    }]

});


$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});
