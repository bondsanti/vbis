<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME')}} {{env('APP_VERSION')}}</title>
    <!-- นำเข้า Tailwind CSS ผ่าน CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>

        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }

        .microsoft-gradient {
            background: linear-gradient(90deg, #0078D4 0%, #00397A 100%);
        }

    </style>
</head>
<body class="gradient">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md mx-auto mt-10">
        <!-- Profile section -->
        <div class="text-center">
          <div class="inline-block p-2 bg-red-100 rounded-full mb-4">
            <img class="rounded-full w-32 h-32" src="path_to_profile_image.jpg" alt="Profile image">
          </div>
          <h2 class="text-2xl font-semibold">ชื่อผู้ใช้งาน</h2>
          <p class="text-gray-600">Assistant Programmer Manager</p>
          <button class="mt-4 px-6 py-2 bg-red-500 text-white rounded-full focus:outline-none hover:bg-red-600 transition">ออกจากระบบ</button>
        </div>

        <!-- Info section -->
        <div class="mt-6">
          <p class="text-sm text-gray-600">สิทธิ์เข้าใช้งานระบบ :</p>
          <p class="text-sm text-gray-600 mt-2">โหลดฟอร์ม IT :</p>
        </div>

        <!-- Menu section -->
        <div class="mt-6 space-y-2">
          <!-- Each row is a menu item -->
          <div class="flex items-center space-x-4 p-2 bg-green-200 rounded-lg">
            <img class="w-6 h-6" src="path_to_icon1.svg" alt="icon1">
            <span>ระบบ HR</span>
          </div>
          <!-- Repeat for other menu items -->
        </div>
      </div>

</body>
</html>
