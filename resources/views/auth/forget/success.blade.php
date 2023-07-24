<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #00416A, #E4E5E6);
            background: -webkit-linear-gradient(to right, #00416A, #E4E5E6);
            /* Chrome 10-25, Safari 5.1-6 */
        }

        .btn-login {
            background: #00416A;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #00416A, #00416A);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #00416A, #00416A);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,
        Safari 7+ */
            color: #fff;
            /* border: 3px solid #eee; */
        }

        .spinner-container {
            text-align: center important !;
        }

        .btn-rounded {
            border-radius: 35px;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-sm-9 col-md-5 col-lg-6 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h4 class="mt-6 mb-3 text-center">ระบบจะส่งอีเมลถึงคุณเพื่อทำการ Reset Password
                        </h4>
                        <p class="text-center text-danger">หากไม่ได้รับอีเมล ให้ตรวจดูโฟลเดอร์จดหมายขยะ (Junk Email)</p>
                        <p class="text-center">อาจใช้เวลา 1-2 นาที *หากยังไม่ได้รับอีเมล์ กรุณาติดต่อ IT</p>

                        <div id="redirect-container" class="text-center spinner-container">

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {

        const redirectTime = 10000;

        const redirectContainerId = 'redirect-container';

        // สร้างองค์ประกอบ HTML สำหรับแสดงสถานะหมุน
        const spinnerElement = document.createElement('div');
        spinnerElement.classList.add('spinner-border', 'text-primary');
        spinnerElement.setAttribute('role', 'status');

        // สร้างองค์ประกอบ HTML สำหรับแสดงเวลาถอยหลัง
        const countdownElement = document.createElement('div');
        countdownElement.classList.add('text-center', 'mt-3');
        countdownElement.style.fontSize = '1.2rem';

        // เพิ่มสถานะหมุนและเวลาถอยหลังลงในองค์ประกอบที่กำหนด
        const redirectContainer = document.getElementById(redirectContainerId);
        redirectContainer.innerHTML = '';
        redirectContainer.appendChild(spinnerElement);
        redirectContainer.appendChild(countdownElement);

        // นับถอยหลังและเปลี่ยนเส้นทางหลังจากเวลาที่กำหนด
        let countdown = redirectTime / 1000;
        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ route('main') }}";
            }
        }, 1000);

    });
</script>

</body>

</html>
