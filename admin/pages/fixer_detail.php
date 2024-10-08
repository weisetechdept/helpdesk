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
        .thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
        }
        .images-fix {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid;
        }
        #img-loading {
            min-height: 165px;
        }
        .assetImg {
            width: 100%;
            height: auto;
            padding: 5px;
        }
        .card-body {
            padding: 1.25rem 0.75rem;
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

        .page-content {
            padding: calc(5px + 24px) calc(0px / 2) 70px calc(0px / 2);
        }
        .container {
            padding-right: 0px;
            padding-left: 0px;
        }
        
    </style>

</head>

<body>

    <div id="layout-wrapper">


        <div class="container" id="app">

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
                                                <td>{{ detail.division }} ({{ detail.branch }})</td>
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
                                        <div class="col-4 mb-3" v-for="i in images">
                                            <a :href="i.link" target="_blank">
                                                <img :src="i.link" class="images-fix">
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
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">เขียนบันทึก</h4>

                                        <div class="row">
                                            <div class="col form-group mt-2">
                                                <div class="form-group">
                                                    <label>เรื่อง</label>
                                                    <select class="form-control" v-model="upComment.type">
                                                        <option value="0">= เลือกเรื่องที่ต้องการบันทึก =</option>
                                                        <option value="2">บันทึกเรื่องทั่วไป</option>
                                                        <option value="3">ปัญหาเกี่ยวกับต้นสังกัดที่แจ้ง</option>
                                                        <option value="4">ปัญหาเกี่ยวกับการสื่อสาร</option>
                                                        <option value="5">ปัญหาเกี่ยวกับอุปกรณ์</option>
                                                        <option value="6">ปัญหาเกี่ยวการเบิกจ่ายเงิน</option>
                                                        <option value="7">เรื่องอื่นๆ</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>รายละเอียด</label>
                                                    <textarea class="form-control" v-model="upComment.detail"></textarea>
                                                </div>
                                                <button class="btn btn-primary mt-2" @click="upComm">บันทึก</button>

                                            </div>
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
                id: <?php echo base64_decode($id); ?>,
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
                    code: ''
                },
                repair: [],
                upComment: {
                    type: '0',
                    detail: ''
                }
            },
            mounted() {
                this.getDetail();
            },
            methods: {
                upComm(){

                    if(this.upComment.type == '0') {
                        swal('ผิดพลาด', 'กรุณาเลือกเรื่องที่ต้องการบันทึก', 'error');
                        return;
                    } else if(this.upComment.type == ''){
                        swal('ผิดพลาด', 'กรุณาพิมพ์ข้อความ', 'error');
                        return;
                    } else {
                        axios.post('/admin/system/upTicket.api.php?po=upComment', {
                            id: app.detail.id,
                            type: app.upComment.type,
                            detail: app.upComment.detail
                        }).then(function(response){
                            if(response.data.status == 'success') {
                                swal('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success')
                                    .then(function() {
                                        window.location.reload();
                                    });
                            } else {
                                swal('ผิดพลาด', response.data.message, 'error');
                            }
                        });
                    }

                },
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
                takeCancel(){
                    swal({
                        title: 'กำลังดำเนินการ',
                        text: 'ตรวจสอบข้อมูล และทำการยกเลิกการแจ้งซ่อมใช่หรือไม่',
                        icon: 'info',
                        buttons: {
                            cancel: 'ยกเลิก',
                            confirm: 'ยืนยัน'
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false

                    }).then(function () {

                        axios.post('/admin/system/upTicket.api.php?po=cancel', {
                            id: app.id,
                            status: '10'
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
                takeFinish(){
                    swal({
                        title: 'กำลังดำเนินการ',
                        text: 'ตรวจสอบข้อมูล และทำการเสร็จสิ้นการแจ้งซ่อมใช่หรือไม่',
                        icon: 'info',
                        buttons: {
                            cancel: 'ยกเลิก',
                            confirm: 'ยืนยัน'
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false

                    }).then(function () {

                        swal("รายการนี้มีค่าใช้จ่ายหรือไม่","หากมีค่าใช้จ่าย ให้กรอกค่าใช้จ่ายรวมทั้งหมดของการซ่อมนี้ลงในช่อง หากไม่มีให้ใส่ 0", {
                            content: "input",
                            buttons: {
                                cancel: "ยกเลิก",
                                submit: "ยืนยัน",
                            },
                        }).then(cost => {
                        
                            axios.post('/admin/system/upTicket.api.php?po=finish', {
                                id: app.id,
                                status: '3',
                                fixed_cost: '0'

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
                    axios.get('/admin/system/fix-detail.api.php?id=<?php echo base64_decode($id); ?>')
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