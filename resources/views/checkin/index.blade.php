<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }} {{ env('APP_VERSION') }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                class="mt-4 px-6 py-2 bg-green-500 text-white rounded-full focus:outline-none hover:bg-green-600 transition"
                onclick="window.location.href='{{ route('main') }}'"> <i class="fas fa-arrow-left"></i>
                กลับหน้าหลัก</button>

            <button
                class="mt-4 px-6 py-2 bg-red-500 text-white rounded-full focus:outline-none hover:bg-red-600 transition"
                onclick="window.location.href='{{ route('logoutUser') }}'"> <i class="fas fa-sign-out-alt mr-1"></i>
                ออกจากระบบ</button>

        </div>


        <!-- Menu -->
        <div class="h-full w-full justify-center items-center dark:bg-gray-800 p-2 mt-5">

            <h1 class="mt-4 text-5xl font-bold tracking-tight text-gray-900 sm:text-5xl text-center">
                <span id="current-time"></span>
            </h1>
            <p id="current-date" class="text-base font-semibold text-indigo-600 text-center mt-2"></p>

            <br>

        </div>
        <div class="self-center text-center">



            @if (!$checkIn)
                <button onclick="showCheckInPopup()"
                    class="bg-blue-300 hover:bg-blue-400 text-gray-800 font-bold py-10 px-10 rounded inline-flex">
                    <svg class="fill-current w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>ลงเวลา เข้างาน</span>
                </button>
            @elseif ($checkIn && !$checkOut)
                <button onclick="showCheckOutPopup()"
                    class="bg-yellow-300 hover:bg-yellow-400 text-gray-800 font-bold py-10 px-10 rounded inline-flex">
                    <svg class="fill-current w-4 h-4 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>ลงเวลา ออกงาน</span>
                </button>
            @endif


        </div>

        @php
            use Carbon\Carbon;
        @endphp

        <ul class="my-4 space-y-3">
            @foreach ($dataCheckIn as $items)
                <li
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 grouphover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">
                    <svg class="h-6 w-6" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                        class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet">
                        <circle cx="32" cy="32" r="30" fill="#4bd37b"></circle>
                        <path fill="#ffffff" d="M46 14L25 35.6l-7-7.2l-7 7.2L25 50l28-28.8z"></path>
                    </svg>

                    @php
                        $timeStm = Carbon::parse($items->timeStm);
                        $formattedTime = $timeStm->addYears(543)->format('d/m/y H:i:s');
                    @endphp

                    @if ($items->action == 1)
                        <span class="flex-1 ml-3 whitespace-nowrap">เข้างาน {{ $formattedTime }}</span>
                        @if ($timeStm->hour >= 9)
                            <span
                                class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-sm font-medium text-white bg-red-500 rounded dark:bg-red-900 dark:text-white">สาย</span>
                        @endif
                    @else
                        <span class="flex-1 ml-3 whitespace-nowrap">ออกงาน {{ $formattedTime }}</span>
                    @endif
                </li>
            @endforeach
        </ul>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Version {{ env('APP_VERSION') }}
        </p>

    </div>

    <br><br>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateTime() {
        const currentTime = new Date();
        let hours = currentTime.getHours();
        let minutes = currentTime.getMinutes();
        let seconds = currentTime.getSeconds();

        // เพิ่มเลข 0 ด้านหน้าถ้าน้อยกว่า 10
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        const timeString = hours + ':' + minutes + ':' + seconds;
        document.getElementById('current-time').textContent = timeString;

        // แสดงวันที่
        const thaiDays = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"];
        const thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        const day = thaiDays[currentTime.getDay()];
        const date = currentTime.getDate();
        const month = thaiMonths[currentTime.getMonth()];
        const year = currentTime.getFullYear() + 543; // เปลี่ยนปีเป็น พ.ศ.
        const dateString = day + ' ' + date + ' ' + month + ' ' + year;
        document.getElementById('current-date').textContent = dateString;
    }
    // เรียกใช้งานฟังก์ชัน updateTime() ทุกๆ 1 วินาที
    setInterval(updateTime, 1000);
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function showCheckInPopup() {
        let currentDate = new Date();
        let formattedDate = currentDate.getFullYear() + '-' +
            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
            ('0' + currentDate.getDate()).slice(-2) + ' ' +
            ('0' + currentDate.getHours()).slice(-2) + ':' +
            ('0' + currentDate.getMinutes()).slice(-2) + ':' +
            ('0' + currentDate.getSeconds()).slice(-2);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    Swal.fire({
                        title: 'ลงเวลาเข้างาน',
                        html: `

                            <input type="hidden" id="datetime" class="swal2-input" value="${formattedDate}" readonly>
                            <input type="hidden" id="lat" class="swal2-input" value="${latitude}" readonly>
                            <input type="hidden" id="long" class="swal2-input" value="${longitude}" readonly>

                            <p>วันเวลา: ${formattedDate}</p>
                            <p>ละติจูด: ${latitude}</p>
                            <p>ลองจิจูด: ${longitude}</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            popup: 'swal2-popup'
                        },
                        preConfirm: () => {
                            return {
                                datetime: document.getElementById('datetime').value,
                                lat: document.getElementById('lat').value,
                                long: document.getElementById('long').value
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const data = result.value;

                            // ส่งข้อมูลไปยังเซิร์ฟเวอร์ด้วย AJAX
                            $.ajax({
                                url: "{{ route('saveCheckIn') }}",
                                method: "POST",
                                data: JSON.stringify(data),
                                contentType: "application/json",
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Success', 'ลงเวลาเข้างานสำเร็จ', 'success');
                                        window.location.href = '/checkin';
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error:", error);
                                    Swal.fire('Error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                                        'error');
                                }
                            });
                        }
                    });
                },
                function(error) {
                    console.error("Error getting location:", error);
                    Swal.fire('Error', 'ไม่สามารถดึงตำแหน่งที่ตั้งได้', 'error');
                }
            );
        } else {
            console.error("Geolocation is not supported by this browser.");
            Swal.fire('Error', 'Geolocation is not supported by this browser.', 'error');
        }
    }

    function showCheckOutPopup() {
        let currentDate = new Date();
        let formattedDate = currentDate.getFullYear() + '-' +
            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
            ('0' + currentDate.getDate()).slice(-2) + ' ' +
            ('0' + currentDate.getHours()).slice(-2) + ':' +
            ('0' + currentDate.getMinutes()).slice(-2) + ':' +
            ('0' + currentDate.getSeconds()).slice(-2);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    Swal.fire({
                        title: 'ลงเวลาออกงาน',
                        html: `
                                <input type="hidden" id="datetime" class="swal2-input" value="${formattedDate}" readonly>
                                <input type="hidden" id="lat" class="swal2-input" value="${latitude}" readonly>
                                <input type="hidden" id="long" class="swal2-input" value="${longitude}" readonly>

                                <p>วันเวลา: ${formattedDate}</p>
                                <p>ละติจูด: ${latitude}</p>
                                <p>ลองจิจูด: ${longitude}</p>
                                `,
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            popup: 'swal2-popup'
                        },
                        preConfirm: () => {
                            return {
                                datetime: document.getElementById('datetime').value,
                                lat: document.getElementById('lat').value,
                                long: document.getElementById('long').value
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const data = result.value;

                            // ส่งข้อมูลไปยังเซิร์ฟเวอร์ด้วย AJAX
                            $.ajax({
                                url: "{{ route('saveCheckOut') }}",
                                method: "POST",
                                data: JSON.stringify(data),
                                contentType: "application/json",
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Success', 'ลงเวลาออกงานสำเร็จ', 'success');
                                        window.location.href = '/checkin';
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error:", error);
                                    Swal.fire('Error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                                        'error');
                                }
                            });
                        }
                    });
                },
                function(error) {
                    console.error("Error getting location:", error);
                    Swal.fire('Error', 'ไม่สามารถดึงตำแหน่งที่ตั้งได้', 'error');
                }
            );
        } else {
            console.error("Geolocation is not supported by this browser.");
            Swal.fire('Error', 'Geolocation is not supported by this browser.', 'error');
        }
    }
</script>
