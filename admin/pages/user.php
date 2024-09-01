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
                                <h4 class="mb-0 font-size-18">รายชื่อสมาชิก</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">สมาชิก</a></li>
                                        <li class="breadcrumb-item active">รายชื่อสมาชิก</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    

                    <div class="row" id="app">
<?php if($_GET['type'] == 'all') { ?>
                        <div class="col-6 col-md-2">
                            <a href="user?type=all">
                                <div class="card bg-primary border-primary">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">ผู้ใช้ทั้งหมด</h5>
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
<?php } 
    if($_GET['type'] == 'all' || $_GET['type'] == 'active') {
?>
                        <div class="col-6 col-md-2">
                            <a href="user?type=active">
                                <div class="card bg-success border-success">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">ใช้งาน</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.active }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
<?php } 
    if($_GET['type'] == 'all' || $_GET['type'] == 'pending') {
?>
                        <div class="col-6 col-md-2">
                            <a href="/admin/user?type=pending">
                                <div class="card bg-warning border-warning">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">รออนุมัติ</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.pending }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
<?php } 
    if($_GET['type'] == 'all' || $_GET['type'] == 'inactive') {
?>
                        <div class="col-6 col-md-2">
                            <a href="user?type=inactive">
                                <div class="card bg-danger border-danger">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <h5 class="card-title mb-0 text-white">ยกเลิกใช้งาน</h5>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    {{ count.inactive }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
<?php } ?>

                        <div class="col-12 col-md-3" id="app">
                            <div class="card">
                                <label class="card-header">ส่วนเสริม</label>
                                <div class="card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" value="https://helpdesk.toyotaparagon.com/user/add-ticket/{รหัสพนักงาน}">
                                    </div>
                                    <div class="col-6">
                                        <a href="/admin/add-user" class="btn btn-primary btn-block nmt-2">เพิ่มสมาชิกใหม่</a>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="app">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>รหัส</th>
                                                <th>ชื่อ - สกุล</th>
                                                <th>แผนก</th>
                                                <th>ระดับ</th>
                                                <th>สถานะ</th>
                                                <th>วันสมัคร</th>
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
                count: [],
                dept: [],
                type: 0
            },
            mounted() {
                $('#datatable').DataTable({
                    "language": {
                        "paginate": {
                            "previous": "<i class='mdi mdi-chevron-left'>",
                            "next": "<i class='mdi mdi-chevron-right'>"
                        },
                        "lengthMenu": "แสดง _MENU_ รายชื่อ",
                        "zeroRecords": "ขออภัย ไม่มีข้อมูล",
                        "info": "หน้า _PAGE_ ของ _PAGES_",
                        "infoEmpty": "ไม่มีข้อมูล",
                        "search": "ค้นหา:",
                    },
                    "drawCallback": function () {
                        $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    },
                    ajax: '/admin/system/user.api.php?get=<?php echo $_GET['type']; ?>&data=list',
                    "columns" : [
                        {'data':'0'},
                        {'data':'1'},
                        {'data':'2'},
                        {'data':'3'},
                        {'data':'4',
                            render: function(data){
                                if(data == 0){
                                    return '<span class="badge badge-warning">รออนุมัติ</span>';
                                }else if(data == 1){
                                    return '<span class="badge badge-success">ใช้งาน</span>';
                                }else if(data == 10){
                                    return '<span class="badge badge-danger">ยกเลิกใช้งาน</span>';
                                }
                            }
                        },
                        {'data':'5'},
                        {'data':'0',
                            render: function(data){
                                return '<a href="user/de/'+data+'" class="btn btn-outline-primary btn-sm">ดูข้อมูล</a>';
                            }
                        }
                    ]
                });

                axios.get('/admin/system/user.api.php?data=count')
                    .then(function (response) {
                        app.count = response.data.count;
                        app.dept = response.data.dept;
                    })
            },
            methods: {
                search(){
                    $('#datatable').DataTable().ajax.url('/admin/system/user.api.php?data=search&dept=1').load();
                }
            }
        });

    </script>

</body>

</html>