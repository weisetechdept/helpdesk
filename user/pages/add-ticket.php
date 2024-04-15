<?php 
    session_start();

    if(!isset($_SESSION['hd_login'])) {
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
                               
                            <div class="form-group">
                                <label>ประเภทการซ่อม</label>
                                <select class="form-control" v-model="ticket.type">
                                    <option value="0">= เลือกประเภทการซ่อม =</option>
                                    <option value="1">อุปกรณ์ IT / Software</option>
                                    <option value="2">อาคารสถานที่ / เครื่องใช้สำนักงาน</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>หัวข้อการซ่อม</label>
                                <input type="text" v-model="ticket.topic" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>อาการเสีย / ชำรุด</label>
                                <textarea class="form-control" v-model="ticket.detail" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>ชื่อผู้แจ้ง</label>
                                <input type="text" v-model="ticket.owner" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>สาขา</label>
                                <select class="form-control" v-model="ticket.branch">
                                    <option value="0">= เลือกสาขา =</option>
                                    <option value="1">สำนักงานใหญ่</option>
                                    <option value="2">สาขาตลาดไท</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>แผนก / ฝ่าย</label>
                                <select class="form-control" v-model="ticket.division">
                                    <option value="0">= เลือกแผนก / ฝ่าย =</option>
                                    <option value="1">ฝ่ายขาย</option>
                                    <option value="2">ฝ่ายการตลาด</option>
                                </select>
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
                            2019 © Scoxe.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Design & Develop by Myra
                            </div>
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
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        var ticket = new Vue ({
            el: '#app',
            data()  { 
                return {
                    ticket: {
                        type: '0',
                        topic: '',
                        detail: '',
                        owner: '',
                        branch: '0',
                        division: '0'
                    }
                }
            },
            methods: {
                checkForm() {
                    if(ticket.ticket.type == '0' || ticket.ticket.topic == '' || ticket.ticket.detail == '') {
                        swal("แจ้งเตือน", "กรุณาเลือก และกรอกข้อมูลให้ครบถ้วน", "warning");
                    } else {
                        axios.post('/user/system/add-ticket.api.php', this.ticket)
                        .then(function (response) {
                            if(response.data.status == 'success') {
                                swal("สำเร็จ", "แจ้งซ่อมเรียบร้อย", "success").then(function() {
                                    window.location.href = '/user/list';
                                });
                            } else {
                                swal("เกิดข้อผิดพลาด", "กรุณาลองใหม่อีกครั้ง", "error");
                            }
                        })
                    }
                }
            }
        })
    </script>

</body>

</html>