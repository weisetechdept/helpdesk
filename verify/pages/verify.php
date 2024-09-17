<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/theme.min.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif !important;
        }
        .thumb {
            width: 300px;
            height: auto;
            object-fit: cover;
            margin: 5px;
            border-radius: 5px;
        }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

</head>


<body class="bg-primary">

    
        <div class="container">
            <div class="row" id="app">
                <div class="col-12 col-md-6 offset-md-3">


                    <div class="d-flex align-items-center min-vh-50" v-if="detail.status == 'success'">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                            <div class="p-4">
                                <h1 class="h3 text-center mb-4">รายละเอียดคำขอซ่อม</h1>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>เลขที่คำขอ</td>
                                            <td>{{ detail.tick_id }}</td>
                                        </tr>
                                        <tr>
                                            <td>ประเภทการซ่อม</td>
                                            <td>{{ detail.tick_type }}</td> 
                                        </tr>
                                        <tr>
                                            <td>วันที่แจ้ง</td>
                                            <td>{{ detail.veri_datetime }}</td>
                                        </tr>
                                        <tr>
                                            <td>หัวข้อ</td>
                                            <td>{{ detail.tick_topic }}</td>
                                        </tr>
                                        <tr>
                                            <td>รายละเอียด</td>
                                            <td>{{ detail.tick_detail }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="center">
                                    <img :src="detail.tick_img" class="thumb">
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-md-6 offset-md-3 text-center">
                                        <button @click="approval" class="btn btn-block btn-success">อนุมัติคำขอซ่อม</button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 offset-md-3 text-center">
                                        <button @click="reject" class="btn btn-block btn-outline-danger">ไม่อนุมัติ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    

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
        var app = new Vue({
            el: '#app',
            data: {
                code: '<?php echo $id; ?>',
                detail: []
            },
            mounted() {
                axios.post('/verify/system/verify.api.php?get=detail', {
                    code: this.code
                }).then(function(response) {
                    if(response.data.detail.status == 'error'){
                        swal('ไม่พบข้อมูล', 'ไม่พบข้อมูล', 'error');
                    } else {
                        app.detail = response.data.detail;
                    }
                });
            },
            methods: {
                approval(e) {
                    axios.post('/verify/system/verify.api.php?get=approval', {
                        code: this.code
                    }).then(function(response) {
                        if(response.data.approval.status == 'success'){
                            swal('อนุมัติ', 'อนุมัติคำขอซ่อมเรียบร้อย', 'success').then(function(){
                                window.location.href = '/verifyApv';
                            });
                        } else {
                            swal('ไม่สามารถอนุมัติได้', 'ไม่สามารถอนุมัติคำขอซ่อม', 'error');
                        }
                    });
                },
                reject() {
                    swal({
                        title: 'ยกเลิกคำขอซ่อม',
                        text: 'คุณต้องการยกเลิกคำขอซ่อมใช่หรือไม่',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            this.rejectSubmit();
                        }
                    });
                    
                },
                rejectSubmit() {
                    axios.post('/verify/system/verify.api.php?get=reject', {
                        code: this.code
                    }).then(function(response) {
                        if(response.data.approval.status == 'success'){
                            swal('ยกเลิก', 'ยกเลิกคำขอซ่อมเรียบร้อย', 'warning').then(function(){
                                window.location.href = '/verifyApv';
                            });
                        } else {
                            swal('ไม่สามารถอนุมัติได้', 'ไม่สามารถอนุมัติคำขอซ่อม', 'error');
                        }
                    });
                }
            }
        });
    </script>

</body>
</html>