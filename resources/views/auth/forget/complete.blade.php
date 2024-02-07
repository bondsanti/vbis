<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} {{ env('APP_VERSION') }} | Change Password Complate</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }

        .gradient-red {
            background: linear-gradient(to right, #ff7a7a, #f52b2b);
        }

        .spinner-container {
            text-align: center important !;
        }
    </style>
</head>

<body class="gradient">
    @include('sweetalert::alert')


    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-lg">
            <h4 class="text-center text-xl font-bold text-gray-800 mb-4">เปลี่ยนรหัสผ่านสำเร็จ!!
            </h4>

            <div id="redirect-container" class="text-center spinner-container">

            </div>
            {{-- <div class="text-center mt-6">
                <button onclick="window.location.href='{{ route('login') }}'"
                    class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                    กลับไปยังหน้าล็อกอิน
                </button>
            </div> --}}
        </div>
    </div>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {

        const redirectTime = 5000;

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
