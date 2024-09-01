<?php 
    session_start();

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
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <link href="../../assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
    </style>

</head>

<body>

    <div id="layout-wrapper">

        <?php include 'admin/inc-pages/nav.inc.php'; ?>
        <?php include 'admin/inc-pages/sidebar.inc.php'; ?>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">รายการแจ้งซ่อม</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">ช่วยเหลือ</a></li>
                                        <li class="breadcrumb-item active">รายการ</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    

                    <div class="row" id="app">

                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="#">
                                <div class="card bg-primary border-primary">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">ทั้งหมด</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.all }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="#">
                                <div class="card bg-warning border-warning">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">รอดำเนินการ</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.wait }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <a href="#">
                                <div class="card bg-info border-info">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">กำลังดำเนินการ</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.process }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-subtitle mb-4">
                                        คุณสามารถเลือกจำนวนข้อมูล ค้นหา รายการตามความต้องการของคุณได้ที่เครื่องมือด้านล่าง
                                    </p>

                                    <table id="datatable" class="table dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th width="50px">รหัส</th>
                                                <th>หัวข้อ</th>
                                                <th width="180px">ประเภท</th>
                                                <th width="100px">สาขา</th>
                                                <th width="110px">แผนก</th>
                                                <th width="100px">สถานะ</th>
                                                <th width="100px">วันที่แจ้ง</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/metismenu.min.js"></script>
    <script src="../../assets/js/waves.js"></script>
    <script src="../../assets/js/simplebar.min.js"></script>
    <script src="../../assets/js/theme.js"></script>

    <script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/datatables/dataTables.bootstrap4.js"></script>
    <script src="../../assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../../assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../../assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="../../assets/plugins/datatables/buttons.flash.min.js"></script>
    <script src="../../assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="../../assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="../../assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="../../assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="../../assets/plugins/datatables/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                count: {
                    all: 0,
                    wait: 0,
                    process: 0
                },
            },
            mounted: function(){
                this.getCount();

                $('#datatable').DataTable({
                    order: [0, 'desc'],
                    ajax: '/admin/system/list.api.php?get=list',
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    bInfo: false,
                    order: [[0, "desc"]],
                    language: {
                        "processing": "กำลังดาวน์โหลดข้อมูล...",
                        "search": "ค้นหา:",
                        "lengthMenu": "แสดง _MENU_ รายการ",
                    },
                    search: {
                        "regex": true,
                        "smart": false,
                    },
                });
            },
            methods: {
                getCount: function(){
                    axios.get('/admin/system/list.api.php?get=count')
                    .then(function (response) {
                        app.count.all = response.data.count.all;
                        app.count.wait = response.data.count.wait;
                        app.count.process = response.data.count.process;
                    })
                }
            }
        });

    </script>

</body>

</html>