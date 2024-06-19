<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VBNext Login 2.0</title>
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
                <img src="{{ url('uploads/logo/logo_gold.png') }}" alt="Vbeyond Logo" class="w-64 h-64">
            </div>

            <form class="space-y-4 mt-2" id="loginForm" action="{{ route('loginVbis') }}" method="POST">
                @csrf
                {{-- <div class="forminput">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">Code</label>
                    <input id="code" type="text" name="code"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Code"
                        autocomplete="off">
                </div>
                <div class="forminput">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="password">Password</label>
                    <input id="password" type="password" name="password"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-blue-300" placeholder="Password"
                        autocomplete="off">
                </div>
                <div>
                    <a href="/forget" class="text-sm text-blue-600 hover:underline">ลืมรหัสผ่าน?</a>
                </div>
                <div>
                    <button type="submit" id="submitButton"
                        class="w-full p-3 rounded-lg text-white gradient flex items-center justify-center">
                        เข้าสู่ระบบ
                    </button>
                </div> --}}

                <hr>
                <div>
                    <button type="button" id="loginM356"
                        class="w-full p-3 rounded-lg text-white microsoft-gradient flex items-center justify-center"
                        onclick="window.location.href='{{ route('mssignin') }}'">
                        <img src="{{ url('uploads/logo/Microsoft_logo.png') }}" alt="Microsoft" class="w-6 h-6 mr-2">
                        <!-- ปรับขนาดตามต้องการ -->
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
                error.addClass('text-sm text-red-500');
                element.closest('.forminput').append(error);
                t
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('border-red-500');
                $(element).removeClass('border-blue-300');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('border-red-500');
                $(element).addClass('border-blue-300');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#loginForm').submit(function() {
            $('#submitButton').prop('disabled', true);
            $('#submitButton').html(
                '<svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="10" height="10" x="1" y="1" fill="white" rx="1"><animate id="svgSpinnersBlocksShuffle30" fill="freeze" attributeName="x" begin="0;svgSpinnersBlocksShuffle3b.end" dur="0.15s" values="1;13"/><animate id="svgSpinnersBlocksShuffle31" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle38.end" dur="0.15s" values="1;13"/><animate id="svgSpinnersBlocksShuffle32" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle39.end" dur="0.15s" values="13;1"/><animate id="svgSpinnersBlocksShuffle33" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle3a.end" dur="0.15s" values="13;1"/></rect><rect width="10" height="10" x="1" y="13" fill="white" rx="1"><animate id="svgSpinnersBlocksShuffle34" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle30.end" dur="0.15s" values="13;1"/><animate id="svgSpinnersBlocksShuffle35" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle31.end" dur="0.15s" values="1;13"/><animate id="svgSpinnersBlocksShuffle36" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle32.end" dur="0.15s" values="1;13"/><animate id="svgSpinnersBlocksShuffle37" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle33.end" dur="0.15s" values="13;1"/></rect><rect width="10" height="10" x="13" y="13" fill="white" rx="1"><animate id="svgSpinnersBlocksShuffle38" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle34.end" dur="0.15s" values="13;1"/><animate id="svgSpinnersBlocksShuffle39" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle35.end" dur="0.15s" values="13;1"/><animate id="svgSpinnersBlocksShuffle3a" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle36.end" dur="0.15s" values="1;13"/><animate id="svgSpinnersBlocksShuffle3b" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle37.end" dur="0.15s" values="1;13"/></rect></svg>  รอสักครู่...'
                );
            return true;
        });
    });
</script>
