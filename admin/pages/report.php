<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");

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

    <link href="../../../assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

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
                                <h4 class="mb-0 font-size-18">รายงาน</h4>

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

                                    <h4 class="card-title">ค้นหา</h4>
                                    <div class="form-group">
                                        <label for="example-select">เริ่มวันที่</label>
                                        <input type="date" class="form-control" v-model="search.start">
                                    </div>

                                    <div class="form-group">
                                        <label for="example-select">ถึงวันที่</label>
                                        <input type="date" class="form-control" v-model="search.end">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" @click="searchDetail">ค้นหา</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">รายละเอียดการซ้อมทั้งหมด</h4>
                                    <table id="datatable" class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th width="50px">รหัส</th>
                                                <th width="150px">รหัสทรัพย์สิน</th>
                                                <th>หัวข้อ</th>
                                                <th width="150px">ประเภท</th>
                                                <th width="150px">หมวดหมู่ซ่อม</th>
                                                <th width="150px">ผู้แจ้ง</th>
                                                <th width="150px">แผนก</th>
                                                <th width="150px">แผนก</th>
                                                <th width="150px">ผู้รับผิดชอบ</th>
                                                <th width="100px">สถานะ</th>
                                                <th width="90px">วันที่แจ้ง</th>
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

    <script src="../../../assets/js/jquery.min.js"></script>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/js/metismenu.min.js"></script>
    <script src="../../../assets/js/waves.js"></script>
    <script src="../../../assets/js/simplebar.min.js"></script>
    <script src="../../../assets/js/theme.js"></script>

    <script src="../../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/plugins/datatables/dataTables.bootstrap4.js"></script>
    <script src="../../../assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../../../assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="../../../assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../../../assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../../../assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="../../../assets/plugins/datatables/buttons.flash.min.js"></script>
    <script src="../../../assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="../../../assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="../../../assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="../../../assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="../../../assets/plugins/datatables/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                search:{
                    start: '',
                    end: ''
                }
            },
            mounted() {
                $('#datatable').DataTable({
                    initComplete: function () {
                        this.api()
                            .columns()
                            .every(function () {
                                let column = this;
                                let title = column.header().textContent;
                
                                let input = document.createElement('input');
                                input.placeholder = title;
                                column.header().replaceChildren(input);
                
                                input.addEventListener('keyup', () => {
                                    if (column.search() !== this.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                            });
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'print'
                    ],
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
                    ajax: '/admin/system/report.api.php?action=detail',
                    "columns" : [
                        {'data':'0'},
                        {'data':'1'},
                        {'data':'2'},
                        {'data':'3'},
                        {'data':'4'},
                        {'data':'5'},
                        {'data':'6'},
                        {'data':'7'},
                        {'data':'8'},
                        {'data':'9',
                            'render': function(data, type, row, meta) {
                                if(data == 0){
                                    return '<span class="badge badge-info">รออนุมัติ (ผจก.)</span>';
                                } else if(data == 1){
                                    return '<span class="badge badge-warning">รอดำเนินการ</span>';
                                } else if(data == 2) {
                                    return '<span class="badge badge-primary">กำลังดำเนินการ</span>';
                                } else if(data == 3) {
                                    return '<span class="badge badge-success">เสร็จสิ้น</span>';
                                } else if(data == 10) {
                                    return '<span class="badge badge-danger">ไม่เสร็จสิ้น</span>';
                                }
                            }
                        },
                        {'data':'10'},
                        {'data':'0',
                            'render': function(data, type, row, meta) {
                                return '<a href="/admin/de/'+data+'" class="btn btn-sm btn-outline-primary">รายละเอียด</a>';
                            }
                        }
                    ]
                });
            },
            methods: {
                searchDetail(){
                    if(this.search.start == '' || this.search.end == ''){
                        swal('ข้อมูลไม่ครบ', 'กรุณากรอกข้อมูลให้ครบถ้วน วันที่เริ่ม และวันที่จบของข้อมมูล', 'warning');
                        return;
                    } else {
                        $('#datatable').DataTable().ajax.url('/admin/system/report.api.php?action=search&start=' + app.search.start + '&end=' + app.search.end).load();
                    }
                    
                }
            }
        });

    </script>

</body>
 
</html>