<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once 'db-conn.php';
    
    if(!empty($id)){
        $find_user = $db->where('user_code',$id)->getOne('user');
        if(!empty($find_user['user_id'])){
            $_SESSION['hd_login'] = true;
            $_SESSION['hd_permission'] = 'officer';
            $_SESSION['hd_code'] = $id;
        } else {
            header('Location: /404');
        }
    } else {
        header('Location: /404');
    }

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
        .assets-code {
            display: none;
        }
    </style>

</head>

<body>

    <div id="layout-wrapper">

        <?php include 'user/inc-pages/nav.inc.php'; ?>
        <?php include 'user/inc-pages/sidebar.inc.php'; ?>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">แจ้งซ่อม</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">ช่วยเหลือ</a></li>
                                        <li class="breadcrumb-item active">แจ้งซ่อม</li>
                                    </ol>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row" id="app">
                        <div class="col-12 col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                <p style="text-align:right;"> *จำเป็นต้องใส่ข้อมูล</p>
                                <div class="form-group">
                                    <label>ประเภทการซ่อม*</label>
                                    <select class="form-control" @change="typeTicket" v-model="ticket.type">
                                        <option value="0">= เลือกประเภทการซ่อม =</option>
                                        <option value="1">อุปกรณ์ IT / Software</option>
                                        <option value="2">เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (มีรหัสทรัพยสิน)</option>
                                        <option value="3">เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (ไม่มีรหัสทรัพยสิน)</option>
                                        <option value="4">อาคารสถานที่ (มีรหัสทรัพยสิน)</option>
                                        <option value="5">อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>หัวข้อการซ่อม*</label>
                                    <input type="text" v-model="ticket.topic" class="form-control">
                                </div>

                                <div class="form-group assets-code">
                                    <label>รหัสทรัพย์สิน*</label>
                                    <input type="text" v-model="ticket.code" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>อาการเสีย / ชำรุด*</label>
                                    <textarea class="form-control" v-model="ticket.detail" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>เบอร์ติดต่อภายใน</label>
                                    <input type="number" v-model="ticket.tel" class="form-control" maxlength="10">
                                </div>

                                <div class="row">
                                    <div class="col form-group mt-2">
                                        <label>อัพโหลดรูปแจ้งซ่อม</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input file-upload" id="uploadfiles" ref="uploadfiles" name="file_upload">
                                            <label class="custom-file-label" for="uploadfiles">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label>ชื่อผู้แจ้ง</label>
                                    <p class="pl-2">{{ display.name }}</p>
                                </div>

                                <div class="form-group">
                                    <label>สาขา</label>
                                    <p class="pl-2">{{ display.branch }}</p>
                                </div>

                                <div class="form-group">
                                    <label>แผนก / ฝ่าย</label>
                                    <p class="pl-2">{{ display.department }}</p>
                                </div>

                                <button @click="checkForm" class="btn btn-primary waves-effect waves-light">แจ้งซ่อม</button>
                        
            
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        var ticket = new Vue ({
            el: '#app',
            data()  { 
                return {
                    ticket: {
                        type: '0',
                        topic: '',
                        detail: '',
                        code: '',
                        tel:'',
                        owner: <?php echo $_SESSION['hd_code']; ?>
                    },
                    display: []
                }
            },
            mounted() {
                axios.get('/user/system/add-ticket.api.php ')
                .then(function (response) {
                    ticket.display = response.data;
                })
            },
            methods: {
                typeTicket() {
                    if(ticket.ticket.type == '2' || ticket.ticket.type == '4') {
                        $('.assets-code').show();
                    } else {
                        $('.assets-code').hide();
                        this.ticket.code = '';
                    }
                },
                checkForm() {
                    if(ticket.ticket.type == '0' || ticket.ticket.topic == '' || ticket.ticket.detail == '') {

                        swal("แจ้งเตือน", "กรุณาเลือก และกรอกข้อมูลให้ครบถ้วน", "warning");
                        
                    } else if(this.ticket.type == '2' || this.ticket.type == '4') {

                        if(this.ticket.code == '') {

                            swal("แจ้งเตือน", "กรุณากรอกรหัสทรัพย์สิน", "warning");
                            return false;

                        } else {
                            this.addTicket();
                        }
                    } else {
                        this.addTicket();
                    }
                },
                addTicket() {
                    swal("ยืนยันการแจ้งซ่อม", "คุณต้องการแจ้งซ่อมใช่หรือไม่", "info", {
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
                            formData.append('type', ticket.ticket.type);
                            formData.append('topic', ticket.ticket.topic);
                            formData.append('detail', ticket.ticket.detail);
                            formData.append('code', ticket.ticket.code);
                            formData.append('owner', ticket.ticket.owner);
                            formData.append('tel', ticket.ticket.tel);

                            axios.post('/user/system/add-ticket.ins.php', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }).then(function(response){

                                if(response.data.status == 'success') {
                                    swal("สำเร็จ", "แจ้งซ่อมเรียบร้อยแล้ว", "success").then((value) => {
                                        window.location.href = '/user/list/<?php echo $_SESSION['hd_code']; ?>';
                                    });
                                } else {
                                    swal("เกิดข้อผิดพลาด", response.data.message , "error");
                                }
                                    
                            });
                        }
                    });
                }
            }
        })
    </script>

</body>

</html>