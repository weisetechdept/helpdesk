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
        .thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
        }
        .images-fix {
            width: 100%;
            height: auto;
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

        .swal-text {
            text-align: center;
            line-height: 1.6rem;
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
                                        <li class="breadcrumb-item">รายการ</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                  
                        <div class="col-lg-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                   
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td width="150px">รหัส</td>
                                                <td>{{ detail.id }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">การแจ้งช่อม</td>
                                                <td>{{ detail.caretaker }}</td>
                                            </tr>
                                            <tr>
                                                <td>ทรัพย์สิน (ASM)</td>
                                                <td>
                                                    {{ detail.code }}
                                                </td>
                                                
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
                                                <td v-if="detail.status == '2'"><span class="badge badge-soft-primary">กำลังดำเนินการ</span></td>
                                                <td v-if="detail.status == '3'"><span class="badge badge-soft-success">เสร็จสิ้น</span></td>
                                                <td v-if="detail.status == '10'"><span class="badge badge-soft-danger">ยกเลิก</span></td>
                                            </tr>
                                            <tr>
                                                <td>ผู้แจ้ง</td>
                                                <td>{{ detail.owner }}</td>
                                            </tr>
                                            <tr> 
                                                <td>สังกัด</td>
                                                <td>{{ detail.deptName }}</td>
                                            </tr>
                                            <tr> 
                                                <td>เบอร์ภายใน</td>
                                                <td>{{ detail.tel }}</td>
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

                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <button class="btn btn-outline-warning mr-2" data-toggle="modal" data-target="#exampleModal3">แก้ใขข้อมูล</button>
                                            <a :href="'/admin/pages/export-asm.php?code='+detail.code" target="_blank" class="btn btn-outline-primary">สรุปรายงาน PDF</a>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel3">แก้ใขข้อมูล {{ asm.name }}</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td width="150px">รหัส</td>
                                                            <td>{{ detail.id }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>รหัสทรัพย์สิน</td>
                                                            <td><input type="text" class="form-control" v-model="edit.code"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>สังกัด</td>
                                                            <td>
                                                                <select class="form-control" v-model="edit.deptId">
                                                                    <option v-for="d in dept" :value="d.id">{{ d.name }}</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-primary mt-2" @click="editCode">บันทึก</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-6">

<div v-if="asm.getStatus == 'success'">

                            <div class="card m-b-30">
                                <div class="card-body">
                                   <h4>ข้อมูลจาก ASM</h4>
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
                                                <td>Serial</td>
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

                            <div class="card m-b-30" id="img-loading" v-if="detail.code !== ''" >
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
                        
                            <div class="card m-b-30 trans">
                                <div class="card-body">

                                    <div class="page-title-box d-flex align-items-center justify-content-between pb-1">
                                        <h4 class="text-left mb-0">บันทึก</h4>
                                        <a href="#" class="text-right" data-toggle="modal" data-target="#ModalMemo">ดูทั้งหมด</a>
                                    </div>

                                    <div class="modal fade" id="ModalMemo" tabindex="-1" role="dialog" aria-labelledby="ModalMemoLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalMemoLabel">บันทึกทรัพย์สิน {{ asm.name }}</h5>
                                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th>รายละเอียด</th>
                                                                <th>บันทึกเวลา</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="t in trans_all">
                                                                <td>{{ t.id }}</td>
                                                                <td>{{ t.detail }}</td>
                                                                <td>{{ t.datetime }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รายละเอียด</th>
                                                <th>บันทึกเวลา</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="t in transaction">
                                                <td>{{ t.id }}</td>
                                                <td>{{ t.detail }}</td>
                                                <td>{{ t.datetime }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>

                        
                            <div class="card m-b-30">
                                <div class="card-body">
                                   <h4>เอกสารแนบ</h4>
<div class="row">
                                    <div class="col-4" v-for="i in images">

                                        <a :href="i.link" target="_blank">
                                            <img :src="i.link" class="img-fluid images-fix">
                                        </a>

                                    </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row" v-if="detail.status == '1' || detail.status == '2'">

                       
                        
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">จัดการ Ticket นี้</h4>
                            </div>
                        </div>

                    </div>

                    <div class="row" v-if="detail.status == '1' || detail.status == '2'">

                        <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">สถานะการดำเนินงาน</h4>
                                            <div class="row col-12" v-if="detail.status == '2'">
                                                
                                                <div class="form-group">
                                                    <p class="mb-2">สถานะหลัก</p>
                                                    <button class="btn btn-success" @click="takeFinish">งานซ่อมเสร็จสื้น</button> <button class="btn btn-outline-danger ml-2" @click="takeCancel">ยกเลิกงานซ่อม</button>
                                                </div>
                                            </div>

                                            <div>
                                                <p>สถานะการดำเนินงาน</p>
                                                <div class="form-group">
                                                    <select class="form-control" v-model="upSend.status">
                                                        <option value="1">กำลังดำเนินการ</option>
                                                        <option value="2">ขออนุมัติซ่อม (มีค่าใช้จ่าย)</option>
                                                        <option value="3">รออะไหล่</option>
                                                        <option value="4">รอส่งงานนอก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="รายละเอียดเพิ่มเติม" v-model="upSend.detail"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <button @click="upStep2" class="btn btn-primary">บันทึก</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">การดำเนินงาน</h4>

                                        <div class="form-group">
                                            <p>ประเภทงาน</p>
                                            <select v-model="send.type_fix" class="form-control">
                                                <option v-for="t in type_fix" :value="t.id">{{ t.name }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <p>ผู้ปฏิบัติงาน</p>
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

                            <div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">แนบรูปภาพ</h4>

                                        <div class="row">
                                            <div class="col form-group mt-2">
                                                <label>อัพโหลดรูปแจ้งซ่อม</label>
                                                <div class="custom-file">
                                                    <input type="file" class="file-upload" id="uploadfiles" ref="uploadfiles">
                                                    <br />
                                                    <button class="btn btn-primary mt-2" @click="uploadImg">อัพโหลด</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js" integrity="sha512-JRlcvSZAXT8+5SQQAvklXGJuxXTouyq8oIMaYERZQasB8SBDHZaUbeASsJWpk0UUrf89DP3/aefPPrlMR1h1yQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                detail: [],
                asm: [],
                asmImg: [],
                asmImgAll: [],
                vendor: [],
                type_fix: [],
                id: <?php echo $id; ?>,
                send: {
                    type_fix: 0,
                    vendor: 0
                },
                upSend: {
                    status: '1',
                    detail: ''
                },
                transaction: [],
                trans_all: [],
                images: [],
                edit: {
                    code: '',
                    deptId: ''
                },
                repair: [],
                dept: [],
                

            },
            mounted() {
                this.getDetail();
            },
            methods: {
                uploadImg() {
                    swal("ยืนยันการอัพโหลด", "คุณต้องการอัพโหลดใช่หรือไม่", "info", {
                        buttons: {
                            cancel: "ยกเลิก",
                            confirm: "ยืนยัน"
                        },
                    }).then((value) => {
                        if(value) {
                            swal("กำลังดำเนินการ", "กรุณารอสักครู่", "info", {
                                buttons: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            });

                            var formData = new FormData();
                            var image = this.$refs.uploadfiles.files[0];

                            formData.append('file_upload', image);
                            formData.append('id', app.detail.id);

                            axios.post('/admin/system/upTicket.api.php?po=uploadImg', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }).then(function(response){

                                if(response.data.status == 'success') {
                                    swal("สำเร็จ", "แจ้งซ่อมเรียบร้อยแล้ว", "success").then((value) => {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("เกิดข้อผิดพลาด", "กรุณาลองใหม่อีกครั้ง", "error");
                                }
                                    
                            });
                        }
                    });
                },
                editCode() {
                    axios.post('/admin/system/upTicket.api.php?po=editCode', {
                        id: this.id,
                        code: this.edit.code,
                        deptId: this.edit.deptId
                    }).then(function (response) {
                        if(response.data.status == 'success') {
                            swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                .then(function() {
                                    window.location.reload();
                                });
                        } else {
                            swal('ผิดพลาด', response.data.message, 'error');
                        }
                    })
                },
                takeCancel(){

                    swal("กำลังดำเนินการ","ตรวจสอบข้อมูล และโปรดใส่เหตุผลในการยกเลิก", {
                        content: "input"
                    }).then((value) => {
                        if (value !== null && value !== '') {

                            axios.post('/admin/system/upTicket.api.php?po=cancel', {
                                id: app.id,
                                status: '10',
                                detail: value
                            }).then(function (response) {

                                if(response.data.status == 'success') {
                                    swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                    .then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    swal('ผิดพลาด', response.data.message, 'error');
                                }

                            })

                        } else {
                            swal('ยกเลิก', 'คุณไม่ได้กรอกเหตุผลในการยกเลิก', 'error');
                        }
                    });   

                },
                takeFinish(){

                        swal("รายการนี้มีค่าใช้จ่ายหรือไม่","หากมีค่าใช้จ่าย ให้กรอกค่าใช้จ่ายรวมทั้งหมดของการซ่อมนี้ลงในช่อง หากไม่มีให้ใส่ 0", {
                            content: "input"
                        }).then((value) => {
                            if (value !== null && value !== '') {
                                axios.post('/admin/system/upTicket.api.php?po=finish', {
                                    id: app.id,
                                    status: '3',
                                    fixed_cost: value
                                }).then(function (response) {
                                    if(response.data.status == 'success') {
                                        swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                        .then(function() {
                                            window.location.reload();
                                        });
                                    } else {
                                        swal('ผิดพลาด', response.data.message, 'error');
                                    }
                                });
                            } else {
                                swal('ยกเลิก', 'คุณไม่ได้กรอกค่าใช้จ่าย', 'error');
                            }
                        });

                },
                upStep2(){
                    swal({
                        title: 'ดำเนินการ',
                        text: 'โปรดตรวจสอบข้อมูล สภานะ และทำรายการ',
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
                            status: app.upSend.status,
                            detail: app.upSend.detail
                        }).then(function (response) {

                            if(response.data.status == 'success') {
                                swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                .then(function() {
                                    window.location.reload();
                                });
                            } else {
                                swal('ผิดพลาด', response.data.message, 'error');
                            }

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
                            console.log(response.data);
                            if(response.data.status == 'error') {
                                swal('ผิดพลาด', response.data.message, 'error')
                                    .then(function() {
                                        window.location.href = '/admin/home';
                                    });
                            } else {

                                app.detail = response.data;
                                app.vendor = response.data.vendor;
                                app.type_fix = response.data.type_fix;
                                app.upSend.status = response.data.opaStatus;
                                app.transaction = response.data.transaction;
                                app.trans_all = response.data.trans_all;

                                app.images = response.data.images;

                                app.edit.code = response.data.code;

                                app.send.type_fix = response.data.tick_fix_type;
                                app.send.vendor = response.data.tick_vendor;

                                app.asm = response.data.asm;
                                app.asmImg = response.data.asm.img;
                                app.asmImgAll = response.data.asm.imgAll;
                                app.repair = response.data.asm.assetRepairs;

                                app.dept = response.data.dept;
                                app.edit.deptId = response.data.deptId;


                            }
                           

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
<?php } ?>