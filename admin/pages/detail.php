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

    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <link href="../../assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

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
        .active {
            background-color: #e5effb;
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
                                <h4 class="mb-0 font-size-18">รายการซ่อม</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">ช่วยเหลือ</a></li>
                                        <li class="breadcrumb-item active">รายการ</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                  
                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                   
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td width="150px">รหัส</td>
                                                <td>{{ detail.id }}</td>
                                            </tr>
                                            <tr>
                                                <td>ทรัพย์สิน (ASM)</td>
                                                <td>{{ detail.code }}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td>ประเภท</td>
                                                <td>{{ detail.type }}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td>หัวข้อการซ่อม</td>
                                                <td>{{ detail.topic }}</td>
                                            </tr>
                                            <tr>
                                                <td>รายละเอียดชำรุด</td>
                                                <td>{{ detail.detail }}</td>
                                            </tr>
                                            <tr>
                                                <td>สถานะ</td>
                                                <td v-if="detail.status == '0'"><span class="badge badge-soft-info">รออนุมัติ (ผจก.)</span></td>
                                                <td v-if="detail.status == '1'"><span class="badge badge-soft-warning">รอกำเนินการ</span></td>
                                                <td v-else-if="detail.status == '2'"><span class="badge badge-soft-primary">กำลังดำเนินการ</span></td>
                                                <td v-else-if="detail.status == '3'"><span class="badge badge-soft-success">เสร็จสิ้น</span></td>
                                                <td v-else-if="detail.status == '10'"><span class="badge badge-soft-danger">ไม่เสร็จสิ้น</span></td>
                                            </tr>
                                            <tr>
                                                <td>ผู้แจ้ง</td>
                                                <td>{{ detail.owner }}</td>
                                            </tr>
                                            <tr>
                                                <td>สังกัด</td>
                                                <td>{{ detail.division }} ({{ detail.branch }})</td>
                                            </tr>
                                            <tr>
                                                <td>วันที่แจ้ง</td>
                                                <td>{{ detail.datetime }}</td>
                                            </tr>
                                            <tr class="active">
                                                <td>ประเภทงาน</td>
                                                <td>{{ detail.fix_type }}</td>
                                            </tr>
                                            <tr class="active">
                                                <td>ผู้ปฏิบัติงาน</td>
                                                <td>{{ detail.vd }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                      
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-6 col-md-12" v-if="detail.code !== ''">
                            <div class="card m-b-30">
                                <div class="card-body">
                                   <h4>ข้อมูลจาก ASM</h4>
                                   <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td>รหัส</td>
                                                <td>{{ asm.code }}</td>
                                            </tr>
                                            <tr>
                                                <td>ชื่อ</td>
                                                <td>{{ asm.name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Serail.</td>
                                                <td>{{ asm.serail }}</td>
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
                                                <td>วันที่</td>
                                                <td>{{ asm.importedDate }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                   <h4>บันทึก</h4>
                                   <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td>ลำดับ</td>
                                                <td>รายละเอียด</td>
                                                <td>บันทึกเวลา</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                   <h4>เอกสารแนบ</h4>
                                    
                                   
                                      
                                </div>
                            </div>
                        </div>

                </div>
                    <div v-if="detail.status == '1'" class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">การดำเนินงาน</h4>
                                    <div class="form-group">
                                        <label>ประเภทงาน</label>
                                        <select v-model="send.type_fix" class="form-control">
                                            <option v-for="t in type_fix" :value="t.id">{{ t.name }}</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>ผู้ปฏิบัติงาน</label>
                                        <select v-model="send.vendor" class="form-control">
                                            <option v-for="v in vendor" :value="v.id">{{ v.name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" @click="upStp1">บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="detail.status == '2' || detail.status == '3' || detail.status == '4' || detail.status == '5'" class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">สถานะการดำเนินงาน</h4>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option value="2">กำลังดำเนินการ</option>
                                                <option value="3">ขออนุมัติซ่อม (มีค่าใช้จ่าย)</option>
                                                <option value="4">รออะไหล่</option>
                                                <option value="5">รอส่งงานนอก</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button @click="upStep2" class="btn btn-primary">บันทึก</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="detail.status == '2' || detail.status == '3' || detail.status == '4' || detail.status == '5'" class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">ดำเนินงานเสร็จสิ้น</h4>
                                        <div class="form-group">
                                            <button class="btn btn-success">งานซ่อมเสร็จสื้น</button> <button class="btn btn-outline-danger ml-2">ยกเลิกงานซ่อม</button>
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
                detail: [],
                asm: [],
                vendor: [],
                type_fix: [],
                id: <?php echo $id; ?>,
                send: {
                    type_fix: 0,
                    vendor: 0
                },
                upSend: {
                    status: 5
                }
            },
            mounted() {
                this.getDetail();
            },
            methods: {
                upStep2(){
                    swal({
                        title: 'กำลังดำเนินการ',
                        text: 'ตรวจสอบข้อมูล และทำการอนุมัติการแจ้งซ่อมใช่หรือไม่',
                        icon: 'info',
                        buttons: {
                            cancel: 'ยกเลิก',
                            confirm: 'ยืนยัน'
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false

                    }).then(function () {
                        axios.post('/admin/system/upTicket.api.php?po=stp2', {
                            id: app.id,
                            status: app.upSend.status
                        })
                        .then(function (response) {
                            
                        })
                    });
                },
                upStp1(){
                    if(this.send.type_fix == 0) {
                        swal('ผิดพลาด', 'กรุณาเลือกประเภทการซ่อม', 'error');
                        return;
                    } else if(this.send.vendor == 0) {
                        swal('ผิดพลาด', 'กรุณาเลือกผู้ปฏิบัติงาน', 'error');
                        return;
                    } else {
                        axios.post('/admin/system/upTicket.api.php?po=stp1', {
                            id: this.id,
                            type_fix: this.send.type_fix,
                            vendor: this.send.vendor
                        })
                        .then(function (response) {
                            if(response.data.status == 'success') {
                                swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                    .then(function() {
                                        window.location.reload();
                                    });
                            } else {
                                swal('ผิดพลาด', response.data.message, 'error');
                            }
                        })
                    }
                },
                getDetail() {
                    axios.get('/admin/system/detail.api.php?id=<?php echo $id; ?>')
                        .then(function (response) {
                            app.detail = response.data;
                            app.vendor = response.data.vendor;
                            app.type_fix = response.data.type_fix;

                            app.upSend.status = response.data.detail.status;

                            //console.log(response.data);
                            
                            axios.get('/user/system/asm.api.php?code='+response.data.code)
                                .then(function (response) {
                                    app.asm = response.data;
                                })
                        })
                },
                approval(){
                    swal({
                        title: 'กำลังดำเนินการ',
                        text: 'ตรวจสอบข้อมูล และทำการอนุมัติการแจ้งซ่อมใช่หรือไม่',
                        icon: 'info',
                        buttons: {
                            cancel: 'ยกเลิก',
                            confirm: 'ยืนยัน'
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false

                    }).then(function () {

                        axios.post('/user/system/approval.api.php', {
                            id: app.id
                        })
                        .then(function (response) {
                            if(response.data.status == 'success') {
                                swal('สำเร็จ', response.data.message, 'success')
                                    .then(function() {
                                        window.location.href = '/user/de/'+app.id;
                                    });
                                
                            } else {
                                swal('ผิดพลาด', response.data.message, 'error');
                            }
                        })
                        
                    });
                    
                }
            }
        });
    </script>


</body>

</html>