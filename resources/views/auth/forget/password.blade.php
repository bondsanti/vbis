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

        .alert svg {
            flex-shrink: 0;
            /* ป้องกันไม่ให้ SVG หดตัว */
        }

        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            color: #fff;
        }

        .alert-blue {
            background-color: #007BFF;
        }

        .alert-pink {
            background-color: #FFC0CB;
        }

        .alert-info {
            background-color: #17A2B8;
        }

        .alert-danger {
            background-color: #DC3545;
        }
    </style>
</head>

<body class="gradient">
    @include('sweetalert::alert')

    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

            <div class="flex justify-center">
                <img src="{{ url('uploads/logo/logo_gold.png') }}" alt="Vbeyond Logo" class="w-64 h-64">
                <!-- ปรับขนาดตามต้องการ -->
            </div>
            <h1 class="text-center font-extrabold mb-3 pt-n5">กรุณาสร้างรหัสผ่านใหม่</h1>
            <div class="alert alert-info" role="alert">
                รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร
            </div>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก,พิมพ์ใหญ่,ตัวเลขและอักษรพิเศษอย่างละ 1 ตัว
            </div>
            <form class="space-y-4 mt-2" id="fogetForm" action="{{ route('update.password') }}" method="POST">
                @csrf
                <div class="forminput">
                    {{-- <input type="hidden" class="form-control" name="user_id" autocomplete="off"
                        value="{{ $user->id }}"> --}}
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">รหัสผ่านใหม่*</label>
                    <input id="password" type="password" name="password" value="{{ old('password') }}"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Password"
                        autocomplete="off">
                    <small class="text-red-600 mt-1">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="forminput">

                    <label class="block mb-2 text-sm font-medium text-gray-600"
                        for="email">ยืนยันรหัสผ่านใหม่*</label>
                    <input id="confrimpassword" type="password" name="confrimpassword"
                        value="{{ old('confrimpassword') }}"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Password"
                        autocomplete="off">
                    <small class="text-red-600 mt-1">
                        @error('confrimpassword')
                            {{ $message }}
                        @enderror
                    </small>
                </div>


                <div>
                    <button type="submit"
                        class="w-full p-3 rounded-lg text-white gradient">เปลี่ยนรหัสผ่าน</button>

                </div>


            </form>

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
                password: {
                    required: true,
                },
                confrimpassword: {
                    required: true,
                },

            },
            messages: {
                password: {
                    required: "กรุณาป้อนรหัสผ่านใหม่ของคุณ",
                },
                confrimpassword: {
                    required: "กรุณาป้อนรหัสผ่านใหม่ของคุณ",
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
