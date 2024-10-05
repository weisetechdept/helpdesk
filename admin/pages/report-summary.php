<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    if(empty($_SESSION['adminName'] || $_SESSION['adminGroup'] || $_SESSION['userAdmin'])) {
        header('Location: /admin/auth');
    } else {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Help Desk System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="ระบบแจ้งซ่อมงานสำนักงาน Help Desk System" name="description" />
    <meta content="WTK" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- App favicon -->
    <link rel="shortcut icon" href="../../../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        .hidden {
            display:none;
        }
    </style>

</head>

<body>

    <div id="layout-wrapper">

        <?php include 'admin/inc-pages/nav.inc.php'; ?>
        <?php include 'admin/inc-pages/sidebar.inc.php'; ?>

        <div class="main-content" id="app">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">รายงานการแจ้งซ่อม</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">การตั้งค่า</a></li>
                                        <li class="breadcrumb-item active">รายละเอียด</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4 col-md-3">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">ค้นหาตามวันที่</h4>
                                    <div class="form-group">
                                        <label for="example-select">เริ่มวันที่</label>
                                        <input type="date" class="form-control" v-model="search.start">
                                    </div>

                                    <div class="form-group">
                                        <label for="example-select">ถึงวันที่</label>
                                        <input type="date" class="form-control" v-model="search.end">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" @click="searchData">ค้นหา</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row hidden">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">รายละเอียดการซ่อมสรุป</h4>

                                    <p class="card-subtitle mb-4">รายการแจ้งแบ่งตามประเภท วันที่ {{ search.start }} ถึง {{ search.end }}</p>

                                    <canvas class="mb-2" id="barChart"></canvas>

                                    <table class="table table-bordered table-centered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>รหัส</th>
                                                <th>ประเภท</th>
                                                <th>ทั้งหมด</th>
                                                <th>สำเร็จ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(label, index) in typeData.label" :key="index">
                                                <td>{{ label }}</td>
                                                <td>{{ typeData.name[index] }}</td>
                                                <td class="text-center">{{ typeData.count[index] }}</td>
                                                <td class="text-center">{{ typeData.done[index] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            2024 © WeiseTech
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <div class="menu-overlay"></div>

    <script src="../../../assets/js/jquery.min.js"></script>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/js/metismenu.min.js"></script>
    <script src="../../../assets/js/waves.js"></script>
    <script src="../../../assets/js/simplebar.min.js"></script>
    <script src="../../../assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="../../../assets/plugins/chart-js/chart.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                search: {
                    start: '<?php echo date('Y-m-01'); ?>',
                    end: '<?php echo date('Y-m-d'); ?>'
                },
                typeData: {
                    label:[],
                    count:[],
                    name:[],
                    done:[]
                }
            },
            mounted: function() {
                
            },
            methods: {
                searchData() {
                    swal({
                        title: "กำลังโหลดข้อมูล...",
                        text: "กรุณารอสักครู่",
                        icon: "info",
                        button: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    });

                    axios.get('/admin/system/report-sum.api.php?start='+this.search.start+'&end='+this.search.end)
                    .then(function (response) {
                        app.sumData = response.data;
                        app.typeData.label = app.sumData.byType.code;
                        app.typeData.count = app.sumData.byType.count;
                        app.typeData.name = app.sumData.byType.name;
                        app.typeData.done = app.sumData.byType.done;
                        app.typeChart(app.typeData.label, app.typeData.count, app.typeData.done);
                        $('.hidden').removeClass('hidden');
                        swal.close();
                    })
                    console.log(app.typeData.done);
                },
                typeChart(label,count,done) {
                    var currentChartCanvas = $("#barChart").get(0).getContext("2d");
                    var currentChart = new Chart(currentChartCanvas, {
                        type: 'bar',
                        data: {
                        labels: label,
                        datasets: [{
                                label: 'จำนวน',
                                data: count,
                                backgroundColor: '#f5c842'
                            },
                            {
                                label: 'สำเร็จ',
                                data: done,
                                backgroundColor: '#34c38f'
                            }
                        ]
                        },
                        options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        
                        scales: {
                            yAxes: [{
                            display: false,
                            gridLines: {
                                drawBorder: false,
                            },
                            ticks: {
                                fontColor: "#686868"
                            }
                            }],
                            xAxes: [{
                            ticks: {
                                fontColor: "#686868"
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            }
                            }]
                        },
                        elements: {
                            point: {
                            radius: 0
                            }
                        }
                        }
                    });
                }
            }
        });

      
    </script>

    </script>

    

</body>
 
</html>
<?php } ?>