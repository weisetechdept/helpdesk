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

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <link href="/assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        .profile-img {
            width: 160px;
            height: 160px;
            margin: 0 auto;
            display: block;
            margin-bottom: 40px;
            margin-top: 20px;
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
                                <h4 class="mb-0 font-size-18">เพิ่มสมาชิกใหม่</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">สมาชิก</a></li>
                                        <li class="breadcrumb-item active">เพิ่มสมาชิกใหม่</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-6" id="app">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="145px">ชื่อ</td>
                                            <td><input class="form-control" v-model="user.f_name"></td>
                                        </tr>
                                        <tr>
                                            <td>นามสกุล</td>
                                            <td><input class="form-control" v-model="user.l_name"></td>
                                        </tr>
                                        <tr>
                                            <td>รหัสพนักงาน</td>
                                            <td><input class="form-control" type="number" v-model="user.code" maxlength="10"></td>
                                        </tr>
                                        <tr>
                                            <td>แผนก</td>
                                            <td>
                                                <select v-model="user.dept" class="form-control">
                                                    <option value="0">= เลือกแผนก =</option>
                                                    <option v-for="d in dept" :value="d.id">{{ d.name }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ระดับ</td>
                                            <td>
                                                <select v-model="user.permission" class="form-control">
                                                    <option value="officer">Officer</option>
                                                    <option value="supervisor">Supervisor</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <buttons @click="addUser" class="btn btn-primary">บันทึกข้อมูล</buttons>
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

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metismenu.min.js"></script>
    <script src="/assets/js/waves.js"></script>
    <script src="/assets/js/simplebar.min.js"></script>
    <script src="/assets/js/theme.js"></script>

    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
    <script src="/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.flash.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="/assets/plugins/datatables/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                user: {
                    code:'',
                    f_name: '',
                    l_name: '',
                    permission: 'officer',
                    dept: '0'
                },
                dept: []
            },
            mounted() {
                axios.get('/admin/system/user.api.php?data=dept')
                    .then(function (response) {
                        app.dept = response.data.dept;
                        console.log(response.data);
                    })
            },
            methods: {
                addUser(){
                    axios.post('/admin/system/user.api.php?data=addUser',{
                        action: 'add',
                        code: app.user.code,
                        f_name: app.user.f_name,
                        l_name: app.user.l_name,
                        permission: app.user.permission,
                        dept: app.user.dept
                    })
                    .then(function (response) {
                        console.log(response.data);
                        if(response.data.status == 'success'){
                            swal('ทำรายการสำเร็จ','เพิ่มสมาชิกสำเร็จ','success').then(function(){
                                window.location.href = '/admin/user?type=all';
                            });
                        }else{
                            swal('ทำรายการไม่สำเร็จ','เพิ่มสมาชิกไม่สำเร็จ','error');
                        }
                    })
                }
            }
        });

    </script>

</body>

</html>
<?php } ?>