<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VBNext Login {{ env('APP_VERSION') }} </title>

    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }

        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }



        .microsoft-gradient {
            background: linear-gradient(90deg, #0078D4 0%, #00397A 100%);
        }

        .my-event {
            cursor: pointer;
        }

        .click {
            cursor: pointer;
        }
    </style>
            <script language=JavaScript>
                function clickIE() {if (document.all) {alert(message);return false;}}
                function clickNS(e) {if
                (document.layers||(document.getElementById&&!document.all)) {
                if (e.which==2||e.which==3) {alert(message);return false;}}}
                if (document.layers)
                {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
                else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
                document.oncontextmenu=new Function("return false")
          </script>

</head>

<body class="gradient">

    @include('sweetalert::alert')
    <div class="bg-white rounded-2xl shadow-lg p-5 max-w-xl mx-auto mt-10">


        <!-- Profile section -->
        <div class="text-center">
            <div class="relative inline-block mb-2 rounded-full mt-4 w-48 h-48">
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-yellow-400 via-red-500 to-blue-600 p-1">
                    <div class="w-full h-full rounded-full bg-cover bg-white"
                        style="background-image: url('{{ $data->fileExists ? $data->remoteFile : url('uploads/logo/Logo-Vbeyond.png') }}');">
                    </div>
                </div>
            </div>


            <h2 class="text-2xl font-semibold">{{ optional(optional($data->apiData)['data'])['name_eng'] }} </h2>
            <p class="text-gray-600">{{ optional(optional($data->apiData)['data'])['position'] }} </p>

            <button
                class="mt-4 px-6 py-2 bg-red-500 text-white rounded-full focus:outline-none hover:bg-red-600 transition"
                onclick="window.location.href='{{ route('logoutUser') }}'"> <i class="fas fa-sign-out-alt mr-1"></i>
                ออกจากระบบ</button>

        </div>


        <!-- Menu -->
        <div class="h-full w-full justify-center items-center dark:bg-gray-800 p-2 mt-5">

            <div class="grid gap-2 grid-cols-2 md:grid-cols-3 gap-6">

                <!-- card checkin  -->
                <a href="{{route('checkin')}}"
                    class="click relative bg-white border rounded-lg shadow-md bg-green-200 dark:bg-gray-800 dark:border-gray-700 transform transition duration-500 hover:scale-105">

                    <div class="p-2 flex justify-center mt-2">

                        <svg width="45" height="45" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M597.678 480.76L390.797 333.998c-22.209-15.766-53-10.532-68.762 11.687l-2.04 2.871c-15.753 22.214-10.526 53 11.691 68.762l206.876 146.771c22.218 15.757 53 10.527 68.766-11.687l2.035-2.876c15.768-22.218 10.529-53.005-11.685-68.766z"
                                fill="#F39A2B" />
                            <path
                                d="M585.066 423.392l-2.871-2.034c-22.218-15.763-53.004-10.527-68.766 11.687L279.007 763.472c-15.762 22.214-10.527 53.005 11.69 68.763l2.871 2.04c22.218 15.762 53.004 10.53 68.762-11.688l234.423-330.428c15.767-22.22 10.531-53.001-11.687-68.767z"
                                fill="#E5594F" />
                            <path
                                d="M891.662 525.126c-0.363 50.106-8.104 91.767-27.502 142.522-13.232 34.625-44.231 82.177-70.529 111.108-62.993 69.31-152.478 113.292-240.772 121.615-100.773 9.501-189.621-17.478-271.287-78.551 7.65 5.723-7.536-6.408-7.061-6.009-4.562-3.821-8.967-7.82-13.369-11.824-8.803-8.003-17.105-16.535-25.225-25.224-18.148-19.432-26.188-30.526-41.439-54.866-27.11-43.264-40.704-80.283-51.007-132.536-4.015-20.354-5.395-39.803-5.586-66.233-0.531-73.33-114.29-73.381-113.758 0 1.607 222.487 154.098 420.146 370.093 475.715 216.482 55.697 449.039-49.258 553.91-245.54 37.754-70.664 56.715-150.224 57.293-230.179 0.526-73.379-113.231-73.328-113.761 0.002z"
                                fill="#4A5699" />
                            <path
                                d="M137.884 501.467c0.362-50.104 8.103-91.762 27.502-142.52 13.233-34.621 44.233-82.173 70.53-111.108 62.993-69.309 152.472-113.29 240.768-121.615 100.773-9.5 189.626 17.479 271.292 78.554-7.652-5.721 7.532 6.408 7.057 6.01 4.563 3.819 8.968 7.821 13.371 11.823 8.803 8 17.108 16.535 25.228 25.225 18.147 19.43 26.187 30.526 41.438 54.866 27.111 43.264 40.709 80.28 51.009 132.533 4.014 20.352 5.396 39.804 5.586 66.232 0.529 73.33 114.287 73.384 113.76 0-1.608-222.489-154.107-420.144-370.099-475.715-216.482-55.7-449.036 49.26-553.905 245.541-37.753 70.664-56.715 150.219-57.292 230.174-0.534 73.384 113.225 73.33 113.755 0z"
                                fill="#C45FA0" />

                        </svg>

                    </div>

                    <div class="px-4 mt-2 text-center">


                        <h6
                            class="text-md font-semibold tracking-tight hover:text-violet-800 dark:hover:text-violet-300 text-gray-900 dark:text-white">
                            Checkin
                        </h6>
                        <span class="inline-flex text-sm font-medium text-gray-500 rounded dark:text-gray-400 mb-3">ลงเวลา เข้า-ออก</span>

                    </div>

                </a>


                <!-- card HR -->
                <div onclick="window.open(`{{ env('APP_HR') }}/login.php?token={{ $data->token }}&CuM8r2zUE3GMBPpG76hmaZPHavmgyxWHNDhewqDtMvQgy9aB1iCRn1KN9Dr32wdm08GpEAqVjTd0CfAa4eaEd5yHJqgkXvPw8KBKJZpbypv8v5RBUS22Qxv2&id={{ $data->user_id }}`, '_blank')"
                    class="click relative bg-white border rounded-lg shadow-md bg-green-200 dark:bg-gray-800 dark:border-gray-700 transform transition duration-500 hover:scale-105">
                    {{-- <div class="absolute top-3 right-3 rounded-full bg-violet-600 text-gray-200  w-6 h-6 text-center">
                        24
                    </div> --}}
                    <div class="p-2 flex justify-center mt-2">

                        <svg width="45" height="45" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M691.573 338.89c-1.282 109.275-89.055 197.047-198.33 198.331-109.292 1.282-197.065-90.984-198.325-198.331-0.809-68.918-107.758-68.998-106.948 0 1.968 167.591 137.681 303.31 305.272 305.278C660.85 646.136 796.587 503.52 798.521 338.89c0.811-68.998-106.136-68.918-106.948 0z"
                                fill="#4A5699" />
                            <path
                                d="M294.918 325.158c1.283-109.272 89.051-197.047 198.325-198.33 109.292-1.283 197.068 90.983 198.33 198.33 0.812 68.919 107.759 68.998 106.948 0C796.555 157.567 660.839 21.842 493.243 19.88c-167.604-1.963-303.341 140.65-305.272 305.278-0.811 68.998 106.139 68.919 106.947 0z"
                                fill="#C45FA0" />
                            <path
                                d="M222.324 959.994c0.65-74.688 29.145-144.534 80.868-197.979 53.219-54.995 126.117-84.134 201.904-84.794 74.199-0.646 145.202 29.791 197.979 80.867 54.995 53.219 84.13 126.119 84.79 201.905 0.603 68.932 107.549 68.99 106.947 0-1.857-213.527-176.184-387.865-389.716-389.721-213.551-1.854-387.885 178.986-389.721 389.721-0.601 68.991 106.349 68.933 106.949 0.001z"
                                fill="#E5594F" />
                        </svg>

                    </div>

                    <div class="px-4 mt-2 text-center">


                        <h6
                            class="text-md font-semibold tracking-tight hover:text-violet-800 dark:hover:text-violet-300 text-gray-900 dark:text-white ">
                            HR System
                        </h6>

                        <span
                            class="inline-flex text-sm font-medium text-gray-500 rounded dark:text-gray-400">ทรัพยากรบุคคล</span>
                    </div>

                </div>



            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Version {{ env('APP_VERSION') }}
        </p>

    </div>

    <br><br>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function toggleDropdown() {
        var element = document.getElementById("dropdownMenu");
        element.classList.toggle("hidden");
    }
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-button')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('hidden')) {
                    openDropdown.classList.add('hidden');
                }
            }
        }
    }
</script>
