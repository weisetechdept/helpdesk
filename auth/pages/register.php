
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>HelpDesk - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="HelpDesk onLine System" name="description" />
    <meta content="Weise Admin" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/theme.min.css" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        @media(min-width: 768px) {
            .container {
                max-width: 678px;
            }
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        body {
            font-family: 'Sarabun', sans-serif;
        }
        .heading > h1 {
            font-size: 1.5rem;
            font-weight: 500;
        }
        .center {
            margin: auto;
        }
        .swal-text {
            text-align: center;
        }
        .dept {
            display: none;
        }
        .head-des {
            text-align: center;
        }
    </style>

</head>

<body>

    <div>
        <div class="container">
            <div class="row" id="register">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                            <div class="row">
                                <div class="col-lg-7 center">
                                    <div class="p-5">
                                        <div class="text-center heading mb-2">
                                            <h1>สมัครสมาชิก</h1>
                                        </div>

                                           
                                            <p class="text-muted head-des mb-4">เพื่อเข้าใช้งานระบบของ โตโยต้า พาราก้อน</p>
                                            

                                            <div class="form-group row">
                                                <div class="col-12 mb-3">
                                                    <input type="text" class="form-control form-control-user" v-model="send.f_name" placeholder="ชื่อ">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <input type="text" class="form-control form-control-user" v-model="send.l_name" placeholder="นามสกุล">
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control form-control-user" v-model="send.code" placeholder="รหัสพนักงาน">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <select class="form-control form-control-user" @change="branch">
                                                    <option value="0">= เลือกสาขา =</option>
                                                    <option value="1">สำนักงานใหญ่</option>
                                                    <option value="2">สาขาตลาดไท</option>
                                                </select>
                                            </div>

                                            <div class="form-group dept">
                                                <select class="form-control form-control-user" v-model="send.department">
                                                    <option value="0">= เลือกแผนกที่สังกัด =</option>
                                                    <option v-for="de in department" :value="de.id" >{{ de.name }}</option>
                                                </select>
                                            </div>
                                            <button @click="register" class="btn btn-success btn-block waves-effect waves-light"> สมัครใช้งาน </button>
                                 
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div>
       
    </div>
    
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metismenu.min.js"></script>
    <script src="/assets/js/waves.js"></script>
    <script src="/assets/js/simplebar.min.js"></script>
    <script src="/assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="https://static.line-scdn.net/liff/edge/versions/2.9.0/sdk.js"></script>
    <script>
  
        var register = new Vue({
            el: '#register',
            data: {
                send: {
                    f_name: '',
                    l_name: '',
                    department: '0',
                    uid: '',
                    code: ''
                },
                department: []
            },
            mounted() {
                /*
                    liff.init({ liffId: "1654391121-baZ6dK7M" }, () => {
                        if (liff.isLoggedIn()) {
                                liff.getProfile().then(profile => {
                                    this.send.uid = profile.userId
                                }).catch(err => console.error(err));
                        } else {
                            liff.login();
                        }
                    }, err => console.error(err.code, error.message));
                */
            },
            methods: {
                branch(e) {
                    if(e.target.value == '0') {
                        document.querySelector('.dept').style.display = 'none',
                        this.send.department = '0'
                        return
                    } else {
                        axios.post('/auth/system/register.api.php', { branch: e.target.value })
                        .then(response => {
                            this.department = response.data,
                            document.querySelector('.dept').style.display = 'block'
                        })
                    }
                },
                register() {
                    if(this.send.f_name == '' || this.send.l_name == '' || this.send.department == '0') {
                        swal('โปรดตรวจสอบ', 'คุณยังไม่ได้กรอกข้อมูลชื่อ นามสกุล หรือ แผนกที่คุณสังกัด', 'warning')
                        return
                    } else {
                        axios.post('/auth/system/register.ins.php', this.send)
                            .then(response => {
                                if(response.data.status == 'error') {
                                    swal('เกิดข้อผิดพลาด', response.data.message, 'error')
                                    return
                                } else if(response.data.status == 'success') {
                                    swal('สมัครสมาชิกสำเร็จ', response.data.message, 'success',
                                        {
                                            button: "ตกลง",
                                        }
                                    ).then(() => {
                                        window.location.href = '/login';
                                    });
                                    this.send.f_name = '';
                                    this.send.l_name = '';
                                    this.send.department = '0';
                                }
                                
                            })
                    }
                }
            },
        })
    </script>

</body>

</html>