<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VBIS Login</title>
    <!-- นำเข้า Tailwind CSS ผ่าน CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>

        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }
    </style>
</head>
<body class="gradient">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <!-- ส่วนของฟอร์มล็อกอินที่มีรูปภาพอยู่ด้านบน -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <!-- รูปภาพโลโก้ที่อยู่ตรงกลาง -->
            <div class="flex justify-center">
                <img src="{{url('uploads/logo/logo_gold.png')}}" alt="Vbeyond Logo" class="w-64 h-64"> <!-- ปรับขนาดตามต้องการ -->
            </div>
            <!-- ฟอร์มล็อกอิน -->
            <form class="space-y-4 mt-2" action="#" method="POST">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">Code</label>
                    <input id="email" type="text" name="email" required class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Code" autocomplete="off">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="password">Password</label>
                    <input id="password" type="password" name="password" required class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Password" autocomplete="off">
                </div>
                <div>
                    <a href="#" class="text-sm text-blue-600 hover:underline">ลืมรหัสผ่าน?</a>
                </div>
                <div>
                    <button type="submit" class="w-full p-3 rounded-lg text-white gradient">เข้าสู่ระบบ</button>
                    <button type="submit" class="w-full p-3 mt-2 rounded-lg text-white gradient">เข้าสู่ระบบ Microsoft</button>
                </div>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                Version 2.0
            </p>
        </div>
    </div>
</body>
</html>
