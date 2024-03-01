<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('APP_NAME')}} {{config('APP_VERSION')}}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">

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
    @include('sweetalert::alert')

    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

            <div class="flex justify-center">
                <img src="{{url('uploads/logo/logo_gold.png')}}" alt="Vbeyond Logo" class="w-64 h-64"> <!-- ปรับขนาดตามต้องการ -->
            </div>

            <form class="space-y-4 mt-2" id="loginForm" action="{{route('loginVbis')}}" method="POST">
                @csrf
                <div class="forminput">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">Code</label>
                    <input id="code" type="text" name="code" class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Code" autocomplete="off">
                </div>
                <div class="forminput">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="password">Password</label>
                    <input id="password" type="password" name="password" class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Password" autocomplete="off">
                </div>
                <div>
                    <a href="/forget" class="text-sm text-blue-600 hover:underline">ลืมรหัสผ่าน?</a>
                </div>
                <div>
                    <button type="submit" class="w-full p-3 rounded-lg text-white gradient">เข้าสู่ระบบ</button>


                </div>

                <hr>
                <div>
                    <button type="button" id="loginM356" class="w-full p-3 rounded-lg text-white microsoft-gradient flex items-center justify-center" onclick="window.location.href='{{ route('mssignin') }}'">
                        <img src="{{url('uploads/logo/Microsoft_logo.png')}}" alt="Microsoft" class="w-6 h-6 mr-2"> <!-- ปรับขนาดตามต้องการ -->
                        เข้าสู่ระบบด้วย Microsoft365
                    </button>

                </div>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                Version 2.0
            </p>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>


<script>
    $(function() {
        $('#loginForm').validate({
            rules: {
                code: {
                    required: true,
                },
                password: {
                    required: true,
                },
            },
            messages: {
                code: {
                    required: "กรุณาป้อนรหัสพนักงาน",
                },
                password: {
                    required: "กรุณาป้อนรหัสผ่าน",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('text-sm text-red-500'); // Use Tailwind CSS classes for error messages
                element.closest('.forminput').append(error); // Adjust this if your input is inside a different element
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('border-red-500'); // Use Tailwind CSS classes for highlighting errors
                $(element).removeClass('border-blue-300'); // Remove the valid class if you are using one
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('border-red-500'); // Use Tailwind CSS classes for unhighlighting errors
                $(element).addClass('border-blue-300'); // Re-add the valid class if you are using one
            }
        });
    });
</script>

