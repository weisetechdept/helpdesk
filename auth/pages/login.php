<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HelpDesk Auth</title>
		<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
		<style>
			.swal-text {
				text-align: center;
				font-family: 'Kanit', sans-serif;
			}
			.swal-button {
				background-color: #e03131;
				font-family: 'Kanit', sans-serif;
				border-radius: 20px;
			}
			.swal-footer {
    			text-align: center;
			}
			.swal-modal {
    			border-radius: 20px;
			}
		</style>
	</head>
	<body>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script src="https://static.line-scdn.net/liff/edge/versions/2.9.0/sdk.js"></script>
        <script>
            liff.init({ liffId: "1654391121-n3xgD6Aw" }, () => {
                if (liff.isLoggedIn()) {
                        liff.getProfile().then(profile => {
                            axios.post('/auth/system/auth.api.php', {
                                userId: profile.userId,
                            }).then(response => {
                                if(response.data.status == 'error') {
                                    swal('เกิดข้อผิดพลาด', 'ไม่พบข้อมูลผู้ใช้งาน', 'error',{
                                            button: "สมัครสมาชิก"
                                    }).then(() => {
                                        window.location.href = '/register';
                                    });
                                } else if(response.data.status == 'success') {
                                    swal('เข้าสู่ระบบสำเร็จ', 'ยินดีต้อนรับ', 'success',
                                        {
                                            button: "ตกลง",
                                        }
                                    ).then(() => {
                                        window.location.href = '/emp/home';
                                    });
                                }
                            });

                        }).catch(err => console.error(err));
                } else {
                    liff.login();
                }
            }, err => console.error(err.code, error.message));
            
        </script>
	</body>
</html>