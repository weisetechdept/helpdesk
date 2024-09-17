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

        <div class="main-content" id="app">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">ผู้รับงาน</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">การตั้งค่า</a></li>
                                        <li class="breadcrumb-item active">ผู้รับงาน</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="control-label">จัดการ : </label><br />
                                            <button type="button" class="btn btn-primary btn-block waves-effect waves-light" data-toggle="modal" data-target="#exampleModal">
                                                เพิ่มผู้รับงาน
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มผู้รับงาน</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label">ชื่อ:</label>
                                                        <input type="text" class="form-control" v-model="add.name">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="addVendor">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ใขผู้รับงาน</h5>
                                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">ชื่อผู้รับงาน :</label>
                                            <input type="text" class="form-control" v-model="edit.name">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">สถานะ :</label>
                                            <select class="form-control" v-model="edit.status">
                                                <option value="1">ใช้งาน</option>
                                                <option value="0">ไม่ใช้งาน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" @click="editData">บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th width="50px">รหัส</th>
                                                <th>ชื่อ</th>
                                                <th width="50px">สถานะ</th>
                                                <th width="50px">วันที่เพิ่ม</th>
                                                <th width="100px">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
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
                showList: 'all',
                add:{
                    name: ''
                },
                edit: {
                    id: '',
                    name: '',
                    status: ''
                }
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
                    ajax: '/admin/system/vendor.api.php?action=list',
                    "columns" : [
                        {'data':'0'},
                        {'data':'1'},
                        {'data':'3',
                            render: function(data){
                                if(data == 1){
                                    return '<span class="badge badge-success">ใช้งาน</span>';
                                } else if(data == 0) {
                                    return '<span class="badge badge-danger">ไม่ใช้งาน</span>';
                                }
                            }
                        },
                        {'data':'4'},
                        {'data':'0',
                            render: function(data){
                                return '<button class="btn btn-outline-warning btn-sm" onclick="app.getEditData('+ data +')" data-toggle="modal" data-target="#editModal">แก้ใข</button>';
                            }
                        }
                    ]
                });
            },
            methods: {
                editData(){

                    axios.post('/admin/system/vendor.api.php', {
                        action: 'editData',
                        id: this.edit.id,
                        name: this.edit.name,
                        status: this.edit.status
                    }).then(function(response){
                        if(response.data.status == 'success'){
                            swal('สำเร็จ', 'แก้ใขข้อมูลเรียบร้อย', 'success');
                            $('#datatable').DataTable().ajax.reload();
                            $('#editModal').modal('hide');
                        } else {
                            swal('เกิดข้อผิดพลาด', response.data.message, 'error');
                        }
                    });

                },
                getEditData(e) {
                    axios.post('/admin/system/vendor.api.php', {
                        action: 'getEditData',
                        id: e
                    }).then(function(response){
                        app.edit.id = response.data.editData.id;
                        app.edit.name = response.data.editData.name;
                        app.edit.status = response.data.editData.status;
                    });
                },
                changeStatus(e){
                    swal({
                        title: "คุณแน่ใจหรือไม่?",
                        text: "คุณต้องการเปลี่ยนสถานะข้อมูลนี้ใช่หรือไม่",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                },
                showListDept: function(){
                    $('#datatable').DataTable().ajax.url('/admin/system/vendor.api.php?action=list&branch='+this.showList).load();
                },
                addVendor: function(){
                    if(this.add.name == ''){
                        swal('เกิดข้อผิดพลาด', 'กรุณากรอกข้อมูลให้ครบถ้วน', 'warning');
                        return;
                    } else {
                        axios.post('/admin/system/vendor.api.php', {
                            action: 'add',
                            name: this.add.name
                        }).then(function(response){
                            if(response.data.status == 'success'){
                                swal('สำเร็จ', 'เพิ่มข้อมูลแผนกเรียบร้อย', 'success');
                                $('#datatable').DataTable().ajax.reload();
                                $('#exampleModal').modal('hide');
                                app.add.name = '';
                                app.add.group = '0';
                            } else {
                                swal('เกิดข้อผิดพลาด', response.data.message, 'error');
                            }
                        });
                    }
                },
            }
        });

    </script>

</body>

</html>