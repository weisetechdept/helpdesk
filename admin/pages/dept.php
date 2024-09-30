<?php 
    session_start();
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

    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <link href="../../assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/theme.min.css" rel="stylesheet" type="text/css" />

    <link href="../../assets/css/use-bootstrap-tag.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        .use-bootstrap-tag>button:not(:disabled) {
            margin: 0 5px 0;
            border-radius: 5px;
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
                                <h4 class="mb-0 font-size-18">แผนก</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">การตั้งค่า</a></li>
                                        <li class="breadcrumb-item active">แผนก</li>
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
                                                เพิ่มแผนก
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มแผนก</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label">ชื่อแผนก:</label>
                                                        <input type="text" class="form-control" v-model="add.name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">สาขา:</label>
                                                        <select class="form-control" v-model="add.branch">
                                                            <option value="0">เลือกสาขา</option>
                                                            <option value="1">สำนักงานใหญ่</option>
                                                            <option value="2">สาขาตลาดไท</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">อีเมล ผจก. เพื่ออนุมัติงานซ่อม <small>เพิ่มได้สูงสุด 2 อีเมล</small>  :</label>
                                                        <input type="text" class="form-control" id="add-email"  data-ub-tag-max="2" />
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="addDept">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="control-label">การแสดงผล : </label><br />
                                            <select class="form-control" v-model="showList" @change="showListDept">
                                                <option value="all">แสดงทั้งหมด</option>
                                                <option value="1">แสดงเฉพาะสำนักงานใหญ่</option>
                                                <option value="2">แสดงเฉพาะตลาดไท</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มแผนก</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label">ชื่อแผนก:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">สาขา:</label>
                                                        <select class="form-control">
                                                            <option value="1">สำนักงานใหญ่</option>
                                                            <option value="2">สาขาตลาดไท</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">แก้ใข : {{ edit.deptName }}</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label">ชื่อแผนก:</label>
                                                        <input type="text" v-model="edit.name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">สาขา:</label>
                                                        <select class="form-control" v-model="edit.branch">
                                                            <option value="1">สำนักงานใหญ่</option>
                                                            <option value="2">สาขาตลาดไท</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">อีเมล ผจก. เพื่ออนุมัติงานซ่อม <small>เพิ่มได้สูงสุด 2 อีเมล</small> :</label>
                                                        <input type="text" class="form-control" id="email-tag" data-ub-tag-max="2" />
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">สถานะแผนก:</label>
                                                        <select class="form-control" v-model="edit.status">
                                                            <option value="1">ใช้งาน</option>
                                                            <option value="0">ไม่ใช่งาน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="updateData">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
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
                                                <th>รหัส</th>
                                                <th>ชื่อแผนก</th>
                                                <th>สาขา</th>
                                                <th>สถานะ</th>
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

    <script src="../../assets/js/use-bootstrap-tag.min.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showList: 'all',
                add:{
                    name: '',
                    branch: '0',
                    email: []
                },
                edit:{
                    id: '',
                    deptName:'',
                    name: '',
                    branch: '',
                    status: '',
                    email: []
                },
                
            },
            mounted() {
                UseBootstrapTag(document.getElementById('email-tag'));
                UseBootstrapTag(document.getElementById('add-email'));
                
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
                    ajax: '/admin/system/dept.api.php?action=list&branch=all',
                    "columns" : [
                        {'data':'0'},
                        {'data':'1'},
                        
                        {'data':'2',
                            render: function(data){
                                if(data == 1){
                                    return '<span class="badge badge-primary">สำนักงานใหญ่</span>';
                                } else {
                                    return '<span class="badge badge-info">สาขาตลาดไท</span>';
                                }
                            }
                        },
                        {'data':'3',
                            render: function(data){
                                if(data == 1){
                                    return '<span class="badge badge-success">ใช้งาน</span>';
                                } else if(data == 0) {
                                    return '<span class="badge badge-danger">ไม่ใช้งาน</span>';
                                }
                            }
                        },
                        {'data':'0',
                            render: function(data){
                                return '<button class="btn btn-outline-warning btn-sm mr-1" onclick="app.getUpdateData('+ data +')" data-toggle="modal" data-target="#editModal">แก้ใข</button> <a href="/admin/dept/de/'+data+'" class="btn btn-outline-primary btn-sm">ดูประวัติซ่อมของแผนก</a>';
                            }
                        }
                    ]
                });
            },
            methods: {
                getUpdateData(e){
                    UseBootstrapTag(document.getElementById('email-tag')).removeValue(this.edit.email);
                    axios.post('/admin/system/dept.api.php', {
                        action: 'get',
                        deptId: e
                    }).then(function(response){
                        app.edit.id = response.data.data.id;
                        app.edit.deptName = response.data.data.name;
                        app.edit.name = response.data.data.name;
                        app.edit.branch = response.data.data.branch;
                        app.edit.status = response.data.data.status;
                        app.edit.email = JSON.parse(response.data.data.email);
                        UseBootstrapTag(document.getElementById('email-tag')).addValue(JSON.parse(response.data.data.email));
                    });
                },
                updateData(){
                    this.edit.email = UseBootstrapTag(document.getElementById('email-tag')).getValues();  
                    axios.post('/admin/system/dept.api.php', {
                        action: 'update',
                        id: this.edit.id,
                        name: this.edit.name,
                        branch: this.edit.branch,
                        status: this.edit.status,
                        email: JSON.stringify(this.edit.email)
                    }).then(function(response){
                        if(response.data.status == 'success'){
                            swal('สำเร็จ', 'แก้ใขข้อมูลแผนกเรียบร้อย', 'success');
                            $('#datatable').DataTable().ajax.reload();
                            $('#editModal').modal('hide');
                        } else {
                            swal('เกิดข้อผิดพลาด', 'ไม่สามารถแก้ใขข้อมูลได้', 'error');
                        }
                    });
                    
                },
                showListDept: function(){
                    $('#datatable').DataTable().ajax.url('/admin/system/dept.api.php?action=list&branch='+this.showList).load();
                },
                addDept: function(){
                    this.add.email = UseBootstrapTag(document.getElementById('add-email')).getValues();
                    if(this.add.name == '' | this.add.branch == '0'){
                        swal('เกิดข้อผิดพลาด', 'กรุณากรอกข้อมูลให้ครบถ้วน', 'warning');
                        return;
                    } else {
                        axios.post('/admin/system/dept.api.php', {
                            action: 'add',
                            name: this.add.name,
                            branch: this.add.branch,
                            email: JSON.stringify(this.add.email)
                        }).then(function(response){
                            if(response.data.status == 'success'){
                                swal('สำเร็จ', 'เพิ่มข้อมูลแผนกเรียบร้อย', 'success');
                                $('#datatable').DataTable().ajax.reload();
                                $('#exampleModal').modal('hide');
                                app.add.name = '';
                                app.add.branch = '0';
                            } else {
                                swal('เกิดข้อผิดพลาด', 'ไม่สามารถเพิ่มข้อมูลได้', 'error');
                            }
                        });
                    }
                },
            }
        });

    </script>

</body>

</html>
<?php } ?>