<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} {{ env('APP_VERSION') }} | Forget Password</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }

        .gradient-red {
            background: linear-gradient(to right, #ff7a7a, #f52b2b);
            /* สีแดง gradient */
        }

    </style>
</head>

<body class="gradient">
    @include('sweetalert::alert')

    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

            <div class="flex justify-center">
                <img src="{{ url('uploads/logo/Logo-Vbeyond.png') }}" alt="Vbeyond Logo" class="w-64 h-64">
                <!-- ปรับขนาดตามต้องการ -->
            </div>
            <h2 class="text-center font-extrabold mb-3 pt-n5">Forget password?</h2>
            <form class="space-y-4 mt-2" id="fogetForm" action="{{ route('forget.email') }}" method="POST">
                @csrf
                <div class="forminput">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">Email </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Email"
                        autocomplete="off">
                </div>


                <div>
                    <button type="submit" class="w-full p-3 rounded-lg text-white gradient-red">Reset Password</button>
                    <button type="button" onclick="window.location.href='{{ url('/') }}'"
                        class="w-full p-3 rounded-lg text-white gradient mt-2">กลับ หน้าหลัก</button>

                </div>
                <hr>
                <div>

                    <a href="{{ url('uploads/RESETPASSWORD.png') }}" type="button" target="_blank"
                        class="w-full p-3 rounded-lg text-white gradient flex items-center justify-center">

                        คู่มือ(Reset Password)
                    </a>

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
        $('#fogetForm').validate({
            rules: {
                email: {
                    required: true,
                },

            },
            messages: {
                email: {
                    required: "กรุณาป้อนอีเมล์ @vbeyond.co.th",
                },

            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass(
                    'text-sm text-red-500'); // Use Tailwind CSS classes for error messages
                element.closest('.forminput').append(
                    error); // Adjust this if your input is inside a different element
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(
                    'border-red-500'); // Use Tailwind CSS classes for highlighting errors
                $(element).removeClass(
                    'border-blue-300'); // Remove the valid class if you are using one
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(
                    'border-red-500'); // Use Tailwind CSS classes for unhighlighting errors
                $(element).addClass(
                    'border-blue-300'); // Re-add the valid class if you are using one
            }
        });
    });
</script>
