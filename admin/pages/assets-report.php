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
        .thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
        }
        .images-fix {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
        }
        #img-loading {
            min-height: 165px;
        }
        .assetImg {
            width: 100%;
            height: auto;
            padding: 5px;
        }
        .trans{
            min-height:250px;
        }
        .img-fix {
            height: 250px;
        }
        .export {
            display: none;
        }
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 780px;
            }
        }
        @media (max-width: 767px) {
            .thumb {
                width: 50px;
                height: 50px;
            }
            h5, .h5 {
                font-size: 0.8rem;
            }
            #img-loading {
                min-height: 130px;
            }
            .trans{
                min-height:350px;
            }
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
                                <h4 class="mb-0 font-size-18">รายงานทรัพย์สินรายชิ้น</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">การตั้งค่า</a></li>
                                        <li class="breadcrumb-item">รายงานทรัพย์สินรายชิ้น</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div id="app">
                        <div class="row">
                            <div class="col-12 col-md-4" id="app">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="card-title">รายงานทรัพย์สินรายชิ้น</h4>
                                        <p>ระบบจะสร้างรายงานรายชิ้นตามรหัสทรัพย์สินที่จะรวมข้อมูลจาก Helpdesk และ ASM สามาดูข้อมูลหรือส่งออกเป็น PDF</p>
                                        <input type="text" class="form-control" v-model="search" placeholder="ค้นหาโดยรหัสทรัพย์สิน">
                                        <br>
                                        <buttons class="btn btn-primary" @click="getAssets">ค้นหา</buttons>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="export">
                                    <div class="col-12 mb-4">
                                        <button class="btn btn-outline-primary">นำออกข้อมูล PDF</button>
                                    </div>

                                    <div class="col-12">
                                        <div class="page-title-box d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0 font-size-18">ข้อมูลจาก Helpdesk</h4>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card m-b-30">
                                            <div class="card-body">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัส</th>
                                                            <th>ชื่อ</th>
                                                            <th>รายละเอียด</th>
                                                            <th>สถานะ</th>
                                                            <th>วันที่แจ้ง</th>
                                                            <th>จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="h in hd">
                                                            <td>{{ h.id }}</td>
                                                            <td>{{ h.topic }}</td>
                                                            <td>{{ h.type }}</td>
                                                            <td v-if="h.status == '0'"><span class="badge badge-soft-info">รออนุมัติ (ผจก.)</span></td>
                                                            <td v-if="h.status == '1'"><span class="badge badge-soft-warning">รอกำเนินการ</span></td>
                                                            <td v-if="h.status == '2'"><span class="badge badge-soft-primary">กำลังดำเนินการ</span></td>
                                                            <td v-if="h.status == '3'"><span class="badge badge-soft-success">เสร็จสิ้น</span></td>
                                                            <td v-if="h.status == '10'"><span class="badge badge-soft-danger">ยกเลิก</span></td>
                                                            <td>{{ h.datetime }}</td>
                                                            <td>
                                                                <a :href="'/admin/de/'+h.id" target="_blank" class="btn btn-outline-primary btn-sm">ดู</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                
                                    <div class="col-12">
                                        <div class="page-title-box d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0 font-size-18">ข้อมูลจาก ASM</h4>
                                        </div>
                                    </div>
                                

                                    <div class="col-lg-12">
                                        <div class="card m-b-30">
                                            <div class="card-body">
                                            <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td width="145px">รหัส</td>
                                                            <td>{{ asm.code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ชื่อ</td>
                                                            <td>{{ asm.name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Serail</td>
                                                            <td>{{ asm.serial }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ประเภท</td>
                                                            <td>{{ asm.type }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>แผนกครอบครอง</td>
                                                            <td>{{ asm.division }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ผู้ครอบครอง</td>
                                                            <td>{{ asm.owner }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ราคา</td>
                                                            <td>{{ asm.price }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>โลเคชั่น</td>
                                                            <td>{{ asm.locationName }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                    
                                        <div class="card" id="img-loading">
                                            <div class="card-body">
                                                <h4>ประวันติการซ่อมบน ASM</h4>

                                                <table class="table table-responsive mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>รายละเอียด</th>
                                                            <th>รหัสเอกสาร</th>
                                                            <th>ราคา</th>
                                                            <th>บริษัทซ่อม/สั่งซื้อ</th>
                                                            <th>สถานะ</th>
                                                            <th>ผู้พิจารณา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="r in repair">
                                                            <td>{{ r.description }}</td>
                                                            <td>{{ r.documentNo }}</td>
                                                            <td>{{ r.price }}</td>
                                                            <td>{{ r.responsibleCompany }}</td>
                                                            <td>{{ r.statusText }}</td>
                                                            <td>{{ r.whoSignName }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>

                                        <div class="card m-b-30" id="img-loading">
                                            <div class="card-body">
                                                <h4>รูปจาก ASM</h4>
                                                <img v-for="a in asmImg" :src="'data:image/png;base64,'+a" class="img-fluid thumb">
                                                <a href="#" data-toggle="modal" data-target="#exampleModal">
                                                    <img src="/assets/images/more.jpg" class="img-fluid thumb">
                                                </a>
                                            </div>
                                        </div>

                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">รูปทรัพย์สิน {{ asm.name }}</h5>
                                                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img v-for="a in asmImgAll" :src="'data:image/png;base64,'+a" class="img-fluid assetImg">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
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
                search: '',
                asm: [],
                asmImg: [],
                asmImgAll: [],
                repair: [],
                hd:[]

            },
            methods: {
                getAssets() {
                    if(this.search == '') {
                        swal('กรุณากรอกรหัสทรัพย์สิน');
                        return;
                    } else {
                        swal({
                            title: "กำลังค้นหา...",
                            buttons: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            timer: 3000
                        });
                        axios.post('/admin/system/assets-report.api.php', {
                            search: this.search
                        }).then(function(response) {
                            swal.close();
                            if(response.data.asm.getStatus == 'error') {
                                swal('ไม่พบข้อมูล');
                            } else {
                                swal('พบข้อมูล');
                                app.asm = response.data.asm;
                                app.asmImg = response.data.asm.img;
                                app.asmImgAll = response.data.asm.imgAll;
                                app.repair = response.data.asm.assetRepairs;
                                app.hd = response.data.hd;
                                document.querySelector('.export').style.display = 'block';
                            }
                        });
                    }
                    
                }
            }
        });

    </script>

</body>

</html>
<?php } ?>