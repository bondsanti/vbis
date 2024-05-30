<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VBNext Login 2.0 </title>

            <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;600&display=swap" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

            <style>
                /* body{
            font-family: 'Sarabun', sans-serif;
        } */
                .gradient {
                    background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
                }

                .microsoft-gradient {
                    background: linear-gradient(90deg, #0078D4 0%, #00397A 100%);
                }

                .my-event {
                    cursor: pointer;
                }

                li {
                    cursor: pointer;
                }
            </style>
</head>
@php
    // $remoteFile = "https://hr.vbeyond.co.th/imageUser/employee/{$data->img_check}";
    // $ch = curl_init($remoteFile);
    // curl_setopt($ch, CURLOPT_NOBODY, true);
    // curl_exec($ch);
    // $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close($ch);
@endphp

<body class="gradient">

    @include('sweetalert::alert')
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl mx-auto mt-10">
        {{-- <div class="relative">
            <button id="adminButton"
                class="absolute top-0 right-0 p-2 bg-gray-500 text-white rounded-full hover:bg-gray-600 focus:outline-none">
                <i class="fas fa-cogs"></i>
            </button>
            <!-- Dropdown menu -->
            <div id="adminDropdown" class="hidden absolute right-0 mt-2 bg-white border rounded-md shadow-md">
                <a onclick="window.open(`{{route('users.list')}}`, '_blank')"
                    class="block px-4 py-2 text-gray-800 hover:bg-green-500 hover:text-white">จัดการสิทธิ์ผู้ใช้งานระบบ</a>
                <a href=""
                    class="block px-4 py-2 text-gray-800 hover:bg-green-500 hover:text-white">รายงานผู้ใช้งานระบบ</a>
            </div>
        </div> --}}
        <!-- Profile section -->
        <div class="text-center">

            {{-- @if ($responseCode != 200)
                <img class="border-solid border-4 border-green-500 inline-block mb-2 bg-cover rounded-full mt-4 w-48 h-48"
                    style="https://hr.vbeyond.co.th/imageUser/noImage.jpg">

            @else
                <div class="border-solid border-4 border-green-500 inline-block mb-2 bg-cover rounded-full mt-4 w-48 h-48"
                    style="background-image: url('https://hr.vbeyond.co.th/imageUser/employee/{{ $data->img_check }}');">
                </div>
            @endif --}}

            <img class="border-solid border-4 border-green-500 inline-block mb-2 bg-cover rounded-full mt-4 w-48 h-48"
                style="background-image: url('{{ url('uploads/logo/logo_gold.png') }}');">

            <h2 class="text-2xl font-semibold">Email {{ $data->email }} </h2>
            {{-- <p class="text-gray-600">{{ $data->department_ref->name ?? '' }}</p> --}}
            {{-- <p class="text-gray-600">{{ $data->position_ref->name ?? '' }}</p> --}}


            <button
                class="mt-4 px-6 py-2 bg-red-500 text-white rounded-full focus:outline-none hover:bg-red-600 transition"
                onclick="window.location.href='{{ route('logoutUser') }}'">ออกจากระบบ</button>

        </div>

        <!-- Info section -->
        <div class="mt-6 text-center grid grid-cols-3 divide-x divide-green-500 divide-dashed">

            <div>
                <span onclick="toggleDropdown()"
                    class="cursor-pointer inline-block bg-blue-200 rounded-full px-3 py-1 text-xs font-semibold text-blue-700 mr-2 mb-2">
                    <i class="fas fa-download mr-1"></i>โหลดแบบฟอร์ม
                </span>
                <div id="dropdownMenu"
                    class="hidden absolute mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <a href="{{ url('uploads/form-it-02-email.pdf') }}" target="_blank"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem">แบบฟอร์มขอสิทธิ์เข้าระบบ / ขอเปิด
                        Email</a>
                    <a href="{{ url('uploads/form-it-05-Internet.pdf') }}" target="_blank"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">แบบฟอร์มขอใช้งาน
                        Internet</a>

                </div>
            </div>



            <div>
                <span
                    class="inline-block bg-green-200 rounded-full px-3 py-1 text-xs font-semibold text-green-700 mr-2 mb-2">
                    <i class="fas fa-check mr-1"></i>มีสิทธิ์ใช้งานระบบ
                </span>
            </div>
            <div>
                <span
                    class="inline-block bg-red-200 rounded-full px-3 py-1 text-xs font-semibold text-red-700 mr-2 mb-2">
                    <i class="fas fa-times mr-1"></i>ไม่มีสิทธิ์ใช้งานระบบ
                </span>
            </div>
        </div>

        <!-- Menu section -->
        <div class="mt-3 space-y-2">
            <ul class="my-4 space-y-3">

                {{-- <li onclick="window.open(`{{ route('powerapp.it', ['user' => $data->code]) }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                    <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M899.984 19.873h-3.452c-26.123 0-47.296 21.172-47.296 47.296v888.508c0 26.127 21.173 47.298 47.296 47.298h3.452c26.119 0 47.297-21.171 47.297-47.298V67.169c0-26.124-21.177-47.296-47.297-47.296z"
                            fill="#4A5699" />
                        <path
                            d="M132.643 19.873h-3.449c-26.12 0-47.296 21.172-47.296 47.296v888.508c0 26.127 21.177 47.298 47.296 47.298h3.449c26.123 0 47.299-21.171 47.299-47.298V67.169c0-26.124-21.176-47.296-47.299-47.296z"
                            fill="#C45FA0" />
                        <path
                            d="M899.463 19.873H129.194c-26.12 0-47.296 21.172-47.296 47.296v3.377c0 26.12 21.177 47.299 47.296 47.299h770.269c26.123 0 47.296-21.179 47.296-47.299v-3.377c0-26.124-21.173-47.296-47.296-47.296z"
                            fill="#6277BA" />
                        <path
                            d="M899.463 905.006H129.194c-26.12 0-47.296 21.17-47.296 47.29v3.381c0 26.127 21.177 47.298 47.296 47.298h770.269c26.123 0 47.296-21.171 47.296-47.298v-3.381c0-26.12-21.173-47.29-47.296-47.29z"
                            fill="#C45FA0" />
                        <path
                            d="M717.962 543.153H542.047c-26.121 0-47.298 21.175-47.298 47.297v3.724c0 26.123 21.177 47.293 47.298 47.293h175.915c26.121 0 47.297-21.17 47.297-47.293v-3.724c0-26.122-21.176-47.297-47.297-47.297z"
                            fill="#E5594F" />
                        <path
                            d="M689.268 198.849H513.355c-26.122 0-47.298 21.175-47.298 47.297v3.722c0 26.12 21.176 47.297 47.298 47.297h175.912c26.122 0 47.298-21.177 47.298-47.297v-3.722c0-26.122-21.175-47.297-47.297-47.297z"
                            fill="#F0D043" />
                        <path
                            d="M757.789 353.081H261.17c-26.121 0-47.297 21.172-47.297 47.296v3.377c0 26.121 21.177 47.299 47.297 47.299h496.619c26.121 0 47.296-21.178 47.296-47.299v-3.377c0-26.125-21.175-47.296-47.296-47.296z"
                            fill="#E5594F" />
                        <path
                            d="M762.638 726.225h-496.62c-26.12 0-47.294 21.18-47.294 47.301v3.377c0 26.12 21.174 47.3 47.294 47.3h496.62c26.122 0 47.296-21.18 47.296-47.3v-3.377c0-26.122-21.174-47.301-47.296-47.301z"
                            fill="#6277BA" />
                        <path
                            d="M355.734 543.328H281.41c-26.122 0-47.297 21.17-47.297 47.293v3.378c0 26.118 21.175 47.297 47.297 47.297h74.324c26.123 0 47.296-21.179 47.296-47.297v-3.378c0-26.123-21.174-47.293-47.296-47.293z"
                            fill="#F39A2B" />
                        <path d="M334.85 248.006m-48.986 0a48.986 48.986 0 1 0 97.972 0 48.986 48.986 0 1 0-97.972 0Z"
                            fill="#F39A2B" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">ระบบ ทะเบียนคุมสัญญา</span>

                </li> --}}
                {{-- <li onclick="window.open(`{{ config('app.url2') }}?token={{ $data->token }}&aOpmIGGnsdhj_R88qlFJMn_ajam9977ADmndMLKjgs&id={{ session()->get('loginId') }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                <li onclick="window.open(`{{ config('app.url2') }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                    <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
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
                    <span class="flex-1 ml-3 whitespace-nowrap">ระบบ HR</span>

                </li>

                @if ($data->active_report == 1)
                    {{-- <li onclick="window.open(`{{ config('app.url3') }}?WAdk_ask7821djYYsadcqqpdf_)atooyjnnZ5654xzA&user={{ $data->code }}&token={{ $data->token }}&act=loginconect&r=1`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
            hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                    <li onclick="window.open(`{{ config('app.url3') }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M466.63 332.141l-2.949-2.286c-22.823-17.687-55.664-13.527-73.352 9.296L168.406 625.474c-17.691 22.821-13.529 55.66 9.297 73.354l2.949 2.29c22.826 17.683 55.666 13.528 73.352-9.299l221.922-286.32c17.694-22.824 13.53-55.669-9.296-73.358z"
                                fill="#E5594F" />
                            <path
                                d="M700.612 619.811L475.887 335.684c-17.915-22.648-50.795-26.486-73.444-8.571l-2.925 2.315c-22.649 17.915-26.489 50.793-8.574 73.442l224.724 284.125c17.91 22.649 50.796 26.488 73.445 8.573l2.925-2.317c22.65-17.911 26.489-50.797 8.574-73.44z"
                                fill="#F39A2B" />
                            <path
                                d="M970.613 897.67H55.454c-25.734 0-46.588 23.407-46.588 52.283v3.736c0 28.876 20.854 52.284 46.588 52.284h915.16c25.734 0 46.59-23.408 46.59-52.284v-3.736c-0.001-28.876-20.856-52.283-46.591-52.283z"
                                fill="#C45FA0" />
                            <path
                                d="M66.425 15.049h-3.736c-28.876 0-52.284 20.551-52.284 45.901v901.601c0 25.353 23.407 45.9 52.284 45.9h3.736c28.876 0 52.284-20.548 52.284-45.9V60.95c0-25.35-23.408-45.901-52.284-45.901z"
                                fill="#4A5699" />
                            <path
                                d="M914.9 334.433l-2.91-2.346c-22.489-18.107-55.408-14.549-73.51 7.94L611.312 622.201c-18.113 22.491-14.556 55.41 7.938 73.517l2.905 2.347c22.494 18.107 55.408 14.546 73.52-7.941l227.169-282.18c18.106-22.49 14.546-55.403-7.944-73.511z"
                                fill="#F0D043" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Report</span>

                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M466.63 332.141l-2.949-2.286c-22.823-17.687-55.664-13.527-73.352 9.296L168.406 625.474c-17.691 22.821-13.529 55.66 9.297 73.354l2.949 2.29c22.826 17.683 55.666 13.528 73.352-9.299l221.922-286.32c17.694-22.824 13.53-55.669-9.296-73.358z"
                                    fill="#E5594F" />
                                <path
                                    d="M700.612 619.811L475.887 335.684c-17.915-22.648-50.795-26.486-73.444-8.571l-2.925 2.315c-22.649 17.915-26.489 50.793-8.574 73.442l224.724 284.125c17.91 22.649 50.796 26.488 73.445 8.573l2.925-2.317c22.65-17.911 26.489-50.797 8.574-73.44z"
                                    fill="#F39A2B" />
                                <path
                                    d="M970.613 897.67H55.454c-25.734 0-46.588 23.407-46.588 52.283v3.736c0 28.876 20.854 52.284 46.588 52.284h915.16c25.734 0 46.59-23.408 46.59-52.284v-3.736c-0.001-28.876-20.856-52.283-46.591-52.283z"
                                    fill="#C45FA0" />
                                <path
                                    d="M66.425 15.049h-3.736c-28.876 0-52.284 20.551-52.284 45.901v901.601c0 25.353 23.407 45.9 52.284 45.9h3.736c28.876 0 52.284-20.548 52.284-45.9V60.95c0-25.35-23.408-45.901-52.284-45.901z"
                                    fill="#4A5699" />
                                <path
                                    d="M914.9 334.433l-2.91-2.346c-22.489-18.107-55.408-14.549-73.51 7.94L611.312 622.201c-18.113 22.491-14.556 55.41 7.938 73.517l2.905 2.347c22.494 18.107 55.408 14.546 73.52-7.941l227.169-282.18c18.106-22.49 14.546-55.403-7.944-73.511z"
                                    fill="#F0D043" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Report</span>
                        </a>
                    </li>
                @endif


                @if ($dataProject)
                {{-- <li onclick="window.open(`{{ config('app.url4') }}/_997744Isfnj)asdjknjZqwnmPOdfk_HHHGsfbp7AscaYjsn_asj20Ssdszf96GH645G1as41s_sdfnjozz/{{ $data->code }}&{{ $data->token }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                    <li onclick="window.open(`{{ config('app.url4') }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                    hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M91.89 238.457c-29.899 0-54.133 24.239-54.133 54.134 0 29.899 24.234 54.137 54.133 54.137s54.138-24.238 54.138-54.137c0-29.896-24.239-54.134-54.138-54.134z"
                                fill="#E5594F" />
                            <path
                                d="M91.89 462.463c-29.899 0-54.133 24.239-54.133 54.139 0 29.895 24.234 54.133 54.133 54.133s54.138-24.238 54.138-54.133c0-29.9-24.239-54.139-54.138-54.139z"
                                fill="#C45FA0" />
                            <path
                                d="M91.89 686.475c-29.899 0-54.133 24.237-54.133 54.133 0 29.899 24.234 54.138 54.133 54.138s54.138-24.238 54.138-54.138c0-29.896-24.239-54.133-54.138-54.133z"
                                fill="#F39A2B" />
                            <path
                                d="M941.26 234.723H328.964c-28.867 0-52.263 23.4-52.263 52.268v3.734c0 28.868 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.401 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"
                                fill="#F0D043" />
                            <path
                                d="M941.26 682.74H328.964c-28.867 0-52.263 23.399-52.263 52.268v3.734c0 28.863 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.405 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"
                                fill="#4A5699" />
                            <path
                                d="M709.781 458.729H328.964c-28.867 0-52.263 23.4-52.263 52.269v3.734c0 28.873 23.396 52.269 52.263 52.269h380.817c28.866 0 52.271-23.396 52.271-52.269v-3.734c0.001-28.869-23.405-52.269-52.271-52.269z"
                                fill="#E5594F" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ โครงการ (Stock)</span>

                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon"
                                version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M91.89 238.457c-29.899 0-54.133 24.239-54.133 54.134 0 29.899 24.234 54.137 54.133 54.137s54.138-24.238 54.138-54.137c0-29.896-24.239-54.134-54.138-54.134z"
                                    fill="#E5594F" />
                                <path
                                    d="M91.89 462.463c-29.899 0-54.133 24.239-54.133 54.139 0 29.895 24.234 54.133 54.133 54.133s54.138-24.238 54.138-54.133c0-29.9-24.239-54.139-54.138-54.139z"
                                    fill="#C45FA0" />
                                <path
                                    d="M91.89 686.475c-29.899 0-54.133 24.237-54.133 54.133 0 29.899 24.234 54.138 54.133 54.138s54.138-24.238 54.138-54.138c0-29.896-24.239-54.133-54.138-54.133z"
                                    fill="#F39A2B" />
                                <path
                                    d="M941.26 234.723H328.964c-28.867 0-52.263 23.4-52.263 52.268v3.734c0 28.868 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.401 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"
                                    fill="#F0D043" />
                                <path
                                    d="M941.26 682.74H328.964c-28.867 0-52.263 23.399-52.263 52.268v3.734c0 28.863 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.405 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"
                                    fill="#4A5699" />
                                <path
                                    d="M709.781 458.729H328.964c-28.867 0-52.263 23.4-52.263 52.269v3.734c0 28.873 23.396 52.269 52.263 52.269h380.817c28.866 0 52.271-23.396 52.271-52.269v-3.734c0.001-28.869-23.405-52.269-52.271-52.269z"
                                    fill="#E5594F" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ โครงการ (Stock)</span>
                        </a>
                    </li>
                @endif

                @if ($data->active_vbasset == 1)
                <li onclick="window.open(`{{ config('app.url5') }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                    hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">
                    {{-- <li onclick="window.open(`{{ config('app.url5') }}/44Ad852asdbp7AscaYjsn_asj2041Otyko_s_Asdklolkl98741pwrja0a1zz/{{ $data->code }}&{{ $data->token }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                        hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M964.751 210.302H61.963c-25.57 0-46.296 20.727-46.296 46.296v6.518c0 25.57 20.727 46.297 46.296 46.297h902.788c25.569 0 46.297-20.727 46.297-46.297v-6.518c0-25.57-20.728-46.296-46.297-46.296z"
                                fill="#4A5699" />
                            <path
                                d="M964.751 828.887H61.963c-25.57 0-46.296 20.728-46.296 46.297v6.52c0 25.565 20.727 46.297 46.296 46.297h902.788c25.569 0 46.297-20.731 46.297-46.297v-6.52c0-25.57-20.728-46.297-46.297-46.297z"
                                fill="#C45FA0" />
                            <path
                                d="M68.564 210.302h-6.601c-25.57 0-46.296 20.727-46.296 46.296v625.105c0 25.565 20.727 46.297 46.296 46.297h6.601c25.571 0 46.296-20.731 46.296-46.297V256.598c0-25.57-20.725-46.296-46.296-46.296zM964.751 210.302h-6.604c-25.569 0-46.292 20.727-46.292 46.296v625.105c0 25.565 20.723 46.297 46.292 46.297h6.604c25.569 0 46.297-20.731 46.297-46.297V256.598c0-25.57-20.728-46.296-46.297-46.296z"
                                fill="#6277BA" />
                            <path d="M155.907 396.561a49.6 49.555 0 1 0 99.2 0 49.6 49.555 0 1 0-99.2 0Z"
                                fill="#F0D043" />
                            <path
                                d="M739.108 111.191H284.412c-25.567 0-46.296 20.727-46.296 46.296v6.518c0 25.568 20.729 46.297 46.296 46.297h454.696c25.569 0 46.293-20.729 46.293-46.297v-6.518c0-25.569-20.723-46.296-46.293-46.296z"
                                fill="#F39A2B" />
                            <path
                                d="M607.586 569.65c0.037 55.423-41.429 99.896-95.959 102.036-55.394 2.173-99.965-43.03-102.043-95.958-1.141-29.074-23.423-53.393-53.392-53.393-28.241 0-54.535 24.293-53.392 53.393 4.438 113.048 94.812 202.82 208.826 202.742 113.141-0.08 202.821-98.092 202.742-208.82-0.049-68.858-106.832-68.862-106.782 0z"
                                fill="#F39A2B" />
                            <path
                                d="M411.073 564.357c1.049-54.399 44.634-97.98 99.036-99.029 54.426-1.049 98.01 46.207 99.028 99.029 1.326 68.771 108.109 68.9 106.783 0-2.19-113.543-92.271-203.625-205.812-205.813-113.539-2.188-203.694 95.569-205.819 205.813-1.328 68.901 105.458 68.771 106.784 0z"
                                fill="#E5594F" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ สินทรัพย์ (Asset) </span>

                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon"
                                version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M899.984 19.873h-3.452c-26.123 0-47.296 21.172-47.296 47.296v888.508c0 26.127 21.173 47.298 47.296 47.298h3.452c26.119 0 47.297-21.171 47.297-47.298V67.169c0-26.124-21.177-47.296-47.297-47.296z"
                                    fill="#4A5699" />
                                <path
                                    d="M132.643 19.873h-3.449c-26.12 0-47.296 21.172-47.296 47.296v888.508c0 26.127 21.177 47.298 47.296 47.298h3.449c26.123 0 47.299-21.171 47.299-47.298V67.169c0-26.124-21.176-47.296-47.299-47.296z"
                                    fill="#C45FA0" />
                                <path
                                    d="M899.463 19.873H129.194c-26.12 0-47.296 21.172-47.296 47.296v3.377c0 26.12 21.177 47.299 47.296 47.299h770.269c26.123 0 47.296-21.179 47.296-47.299v-3.377c0-26.124-21.173-47.296-47.296-47.296z"
                                    fill="#6277BA" />
                                <path
                                    d="M899.463 905.006H129.194c-26.12 0-47.296 21.17-47.296 47.29v3.381c0 26.127 21.177 47.298 47.296 47.298h770.269c26.123 0 47.296-21.171 47.296-47.298v-3.381c0-26.12-21.173-47.29-47.296-47.29z"
                                    fill="#C45FA0" />
                                <path
                                    d="M717.962 543.153H542.047c-26.121 0-47.298 21.175-47.298 47.297v3.724c0 26.123 21.177 47.293 47.298 47.293h175.915c26.121 0 47.297-21.17 47.297-47.293v-3.724c0-26.122-21.176-47.297-47.297-47.297z"
                                    fill="#E5594F" />
                                <path
                                    d="M689.268 198.849H513.355c-26.122 0-47.298 21.175-47.298 47.297v3.722c0 26.12 21.176 47.297 47.298 47.297h175.912c26.122 0 47.298-21.177 47.298-47.297v-3.722c0-26.122-21.175-47.297-47.297-47.297z"
                                    fill="#F0D043" />
                                <path
                                    d="M757.789 353.081H261.17c-26.121 0-47.297 21.172-47.297 47.296v3.377c0 26.121 21.177 47.299 47.297 47.299h496.619c26.121 0 47.296-21.178 47.296-47.299v-3.377c0-26.125-21.175-47.296-47.296-47.296z"
                                    fill="#E5594F" />
                                <path
                                    d="M762.638 726.225h-496.62c-26.12 0-47.294 21.18-47.294 47.301v3.377c0 26.12 21.174 47.3 47.294 47.3h496.62c26.122 0 47.296-21.18 47.296-47.3v-3.377c0-26.122-21.174-47.301-47.296-47.301z"
                                    fill="#6277BA" />
                                <path
                                    d="M355.734 543.328H281.41c-26.122 0-47.297 21.17-47.297 47.293v3.378c0 26.118 21.175 47.297 47.297 47.297h74.324c26.123 0 47.296-21.179 47.296-47.297v-3.378c0-26.123-21.174-47.293-47.296-47.293z"
                                    fill="#F39A2B" />
                                <path
                                    d="M334.85 248.006m-48.986 0a48.986 48.986 0 1 0 97.972 0 48.986 48.986 0 1 0-97.972 0Z"
                                    fill="#F39A2B" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ สินทรัพย์ (Asset) </span>
                        </a>
                    </li>
                @endif


                @if ($dataVconex == 1)
                {{-- <li onclick="window.open(`{{ config('app.url6') }}/992PowrmkfrK45lksmdjdl_rruins878Dasddlfjk792sj_sadAkZXQQew/{{ $data->code }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                    hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                    <li onclick="window.open(`{{ config('app.url6') }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                        hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M877.387 523.945c-1.663 198.958-163.571 360.868-362.532 362.531-198.991 1.661-360.885-166.07-362.526-362.531-0.697-83.354-130.015-83.42-129.318 0 1.064 127.401 49.851 247.752 136.97 340.531 86.427 92.047 208.144 143.457 333.116 150.77 127.267 7.454 251.374-40.885 347.279-122.774 96.086-82.04 150.659-201.304 164.166-325.296 1.565-14.352 2.04-28.805 2.16-43.23 0.697-83.421-128.618-83.355-129.315-0.001z"
                                fill="#4A5699" />
                            <path
                                d="M152.329 500.646c1.662-198.965 163.563-360.875 362.526-362.537 83.354-0.697 83.419-130.013 0-129.317-129.524 1.081-252.396 51.567-345.385 141.68C75.465 241.564 24.097 370.538 23.011 500.646c-0.697 83.421 128.62 83.349 129.318 0z"
                                fill="#C45FA0" />
                            <path
                                d="M400.998 617.112c-54.167-72.265-46.168-154.096 21.221-212.268 63.03-54.412 156.255-33.802 209.578 32.46 22.13 27.497 68.54 22.901 91.441 0 26.914-26.917 22.073-64.009 0-91.44-89.215-110.859-259.653-132.629-373.618-47.204-118.817 89.062-151.202 262.422-60.284 383.718 21.095 28.142 55.432 42.548 88.465 23.196 27.799-16.282 44.387-60.192 23.197-88.462z"
                                fill="#E5594F" />
                            <path
                                d="M628.723 433.281c30.673 40.924 38.604 71.548 34.179 119.265 0.715-5.845 0.408-4.79-0.924 3.173-1.3 6.769-3.259 13.386-5.207 19.983-4.113 13.896-2.982 9.9-9.75 22.736-11.978 22.716-23.474 34.203-45.271 51.746-27.499 22.131-22.904 68.538 0 91.441 26.914 26.913 64.011 22.075 91.439 0 110.85-89.224 132.613-259.649 47.193-373.614-21.092-28.142-55.431-42.546-88.466-23.196-27.799 16.287-44.384 60.193-23.193 88.466z"
                                fill="#F39A2B" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ VBLead (Call Center)</span>
                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon"
                                version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M877.387 523.945c-1.663 198.958-163.571 360.868-362.532 362.531-198.991 1.661-360.885-166.07-362.526-362.531-0.697-83.354-130.015-83.42-129.318 0 1.064 127.401 49.851 247.752 136.97 340.531 86.427 92.047 208.144 143.457 333.116 150.77 127.267 7.454 251.374-40.885 347.279-122.774 96.086-82.04 150.659-201.304 164.166-325.296 1.565-14.352 2.04-28.805 2.16-43.23 0.697-83.421-128.618-83.355-129.315-0.001z"
                                    fill="#4A5699" />
                                <path
                                    d="M152.329 500.646c1.662-198.965 163.563-360.875 362.526-362.537 83.354-0.697 83.419-130.013 0-129.317-129.524 1.081-252.396 51.567-345.385 141.68C75.465 241.564 24.097 370.538 23.011 500.646c-0.697 83.421 128.62 83.349 129.318 0z"
                                    fill="#C45FA0" />
                                <path
                                    d="M400.998 617.112c-54.167-72.265-46.168-154.096 21.221-212.268 63.03-54.412 156.255-33.802 209.578 32.46 22.13 27.497 68.54 22.901 91.441 0 26.914-26.917 22.073-64.009 0-91.44-89.215-110.859-259.653-132.629-373.618-47.204-118.817 89.062-151.202 262.422-60.284 383.718 21.095 28.142 55.432 42.548 88.465 23.196 27.799-16.282 44.387-60.192 23.197-88.462z"
                                    fill="#E5594F" />
                                <path
                                    d="M628.723 433.281c30.673 40.924 38.604 71.548 34.179 119.265 0.715-5.845 0.408-4.79-0.924 3.173-1.3 6.769-3.259 13.386-5.207 19.983-4.113 13.896-2.982 9.9-9.75 22.736-11.978 22.716-23.474 34.203-45.271 51.746-27.499 22.131-22.904 68.538 0 91.441 26.914 26.913 64.011 22.075 91.439 0 110.85-89.224 132.613-259.649 47.193-373.614-21.092-28.142-55.431-42.546-88.466-23.196-27.799 16.287-44.384 60.193-23.193 88.466z"
                                    fill="#F39A2B" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ VBLead (Call Center)</span>
                        </a>
                    </li>
                @endif

                @if ($data->active_agent == 1)
                {{-- <li onclick="window.open(`{{ config('app.url7') }}/Zx00faff00048s2zxwormRqvBNsddsf098r/{{ $data->code }}&{{ $data->token }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                    <li onclick="window.open(`{{ config('app.url7') }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                    hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M330.147 727.583l-3.105-2.113c-23.995-16.366-56.736-10.206-73.12 13.753L120.381 934.43c-16.389 23.958-10.22 56.646 13.779 73.002l3.1 2.118c24 16.366 56.741 10.206 73.125-13.752l133.542-195.207c16.388-23.959 10.219-56.642-13.78-73.008z"
                                fill="#E5594F" />
                            <path
                                d="M457.934 727.583l-3.1-2.113c-23.999-16.366-56.74-10.206-73.129 13.753L248.168 934.43c-16.388 23.958-10.22 56.646 13.775 73.002l3.109 2.118c23.995 16.366 56.736 10.206 73.12-13.752l133.537-195.207c16.394-23.959 10.225-56.642-13.775-73.008z"
                                fill="#F0D043" />
                            <path
                                d="M895.09 934.213L761.813 740.007c-16.353-23.837-49.03-29.961-72.979-13.689l-3.101 2.108c-23.949 16.28-30.104 48.796-13.748 72.629L805.26 995.261c16.357 23.838 49.031 29.971 72.98 13.686l3.101-2.1c23.95-16.282 30.105-48.797 13.749-72.634z"
                                fill="#E5594F" />
                            <path
                                d="M767.555 934.213L634.279 740.007c-16.357-23.837-49.031-29.961-72.985-13.689l-3.096 2.108c-23.954 16.28-30.109 48.796-13.752 72.629l133.275 194.206c16.357 23.838 49.03 29.971 72.984 13.686l3.096-2.1c23.955-16.282 30.11-48.797 13.754-72.634z"
                                fill="#F0D043" />
                            <path
                                d="M712.252 364.688L577.453 338.78l-66.275-120.278-66.28 120.278-134.794 25.908 93.834 100.25-17.037 136.291 124.277-58.327 124.272 58.327-17.037-136.291z"
                                fill="#F39A2B" />
                            <path
                                d="M803.625 434.496c-1.459 160.596-131.855 290.993-292.452 292.453-76.346 0.693-150.076-30.799-204.647-83.529-56.995-55.073-87.084-130.821-87.796-208.923-0.676-74.35-116.033-74.415-115.355 0 2.034 223.497 184.3 405.775 407.798 407.807 223.519 2.032 405.803-187.375 407.808-407.807 0.675-74.416-114.679-74.351-115.356-0.001z"
                                fill="#4A5699" />
                            <path
                                d="M218.73 415.399c1.462-160.594 131.845-290.992 292.443-292.455 76.347-0.696 150.079 30.801 204.647 83.531 56.997 55.075 87.093 130.822 87.805 208.923 0.677 74.35 116.031 74.416 115.355 0C916.948 191.905 734.669 9.624 511.173 7.589c-223.518-2.035-405.793 187.38-407.798 407.81-0.678 74.415 114.679 74.35 115.355 0z"
                                fill="#C45FA0" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Sale/Agent</span>

                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon"
                                version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M330.147 727.583l-3.105-2.113c-23.995-16.366-56.736-10.206-73.12 13.753L120.381 934.43c-16.389 23.958-10.22 56.646 13.779 73.002l3.1 2.118c24 16.366 56.741 10.206 73.125-13.752l133.542-195.207c16.388-23.959 10.219-56.642-13.78-73.008z"
                                    fill="#E5594F" />
                                <path
                                    d="M457.934 727.583l-3.1-2.113c-23.999-16.366-56.74-10.206-73.129 13.753L248.168 934.43c-16.388 23.958-10.22 56.646 13.775 73.002l3.109 2.118c23.995 16.366 56.736 10.206 73.12-13.752l133.537-195.207c16.394-23.959 10.225-56.642-13.775-73.008z"
                                    fill="#F0D043" />
                                <path
                                    d="M895.09 934.213L761.813 740.007c-16.353-23.837-49.03-29.961-72.979-13.689l-3.101 2.108c-23.949 16.28-30.104 48.796-13.748 72.629L805.26 995.261c16.357 23.838 49.031 29.971 72.98 13.686l3.101-2.1c23.95-16.282 30.105-48.797 13.749-72.634z"
                                    fill="#E5594F" />
                                <path
                                    d="M767.555 934.213L634.279 740.007c-16.357-23.837-49.031-29.961-72.985-13.689l-3.096 2.108c-23.954 16.28-30.109 48.796-13.752 72.629l133.275 194.206c16.357 23.838 49.03 29.971 72.984 13.686l3.096-2.1c23.955-16.282 30.11-48.797 13.754-72.634z"
                                    fill="#F0D043" />
                                <path
                                    d="M712.252 364.688L577.453 338.78l-66.275-120.278-66.28 120.278-134.794 25.908 93.834 100.25-17.037 136.291 124.277-58.327 124.272 58.327-17.037-136.291z"
                                    fill="#F39A2B" />
                                <path
                                    d="M803.625 434.496c-1.459 160.596-131.855 290.993-292.452 292.453-76.346 0.693-150.076-30.799-204.647-83.529-56.995-55.073-87.084-130.821-87.796-208.923-0.676-74.35-116.033-74.415-115.355 0 2.034 223.497 184.3 405.775 407.798 407.807 223.519 2.032 405.803-187.375 407.808-407.807 0.675-74.416-114.679-74.351-115.356-0.001z"
                                    fill="#4A5699" />
                                <path
                                    d="M218.73 415.399c1.462-160.594 131.845-290.992 292.443-292.455 76.347-0.696 150.079 30.801 204.647 83.531 56.997 55.075 87.093 130.822 87.805 208.923 0.677 74.35 116.031 74.416 115.355 0C916.948 191.905 734.669 9.624 511.173 7.589c-223.518-2.035-405.793 187.38-407.798 407.81-0.678 74.415 114.679 74.35 115.355 0z"
                                    fill="#C45FA0" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Sale/Agent</span>
                        </a>
                    </li>
                @endif

                @if ($data->active_vproject == 1)
                {{-- <li onclick="window.open(`{{ config('app.url8') }}/PY0A3A9$G55KlasS90xxQwA9FvvLkiIQdZxpO09s1A/{{ $data->code }}&{{ $data->token }}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white"> --}}
                    <li onclick="window.open(`{{ config('app.url8') }}`, '_blank')"
                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-400 group
                    hover:shadow dark:bg-green-400 dark:hover:bg-green-400 dark:text-white">

                        <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M965.282 186.746H62.449c-25.477 0-46.129 21.177-46.129 47.298v7.139c0 26.121 20.652 47.296 46.129 47.296h902.833c25.48 0 46.131-21.175 46.131-47.296v-7.139c0-26.121-20.65-47.298-46.131-47.298z"
                                fill="#4A5699" />
                            <path
                                d="M965.282 821.697H62.449c-25.477 0-46.129 21.173-46.129 47.296v7.141c0 26.119 20.652 47.297 46.129 47.297h902.833c25.48 0 46.131-21.178 46.131-47.297v-7.141c0-26.123-20.65-47.296-46.131-47.296z"
                                fill="#C45FA0" />
                            <path
                                d="M69.412 186.746H62.33c-26.121 0-47.294 21.177-47.294 47.298v642.09c0 26.119 21.173 47.297 47.294 47.297h7.082c26.121 0 47.294-21.178 47.294-47.297v-642.09c0.001-26.121-21.173-47.298-47.294-47.298zM964.117 186.746h-7.082c-26.119 0-47.296 21.177-47.296 47.298v642.09c0 26.119 21.177 47.297 47.296 47.297h7.082c26.122 0 47.296-21.178 47.296-47.297v-642.09c0-26.121-21.174-47.298-47.296-47.298z"
                                fill="#F39A2B" />
                            <path
                                d="M426.617 435.818h-7.082c-26.121 0-47.296 21.171-47.296 47.294v38.715c0 26.119 21.175 47.296 47.296 47.296h7.082c26.121 0 47.298-21.177 47.298-47.296v-38.715c0-26.122-21.177-47.294-47.298-47.294zM601.912 435.818h-7.082c-26.118 0-47.292 21.171-47.292 47.294v38.715c0 26.119 21.174 47.296 47.292 47.296h7.082c26.119 0 47.3-21.177 47.3-47.296v-38.715c0-26.122-21.181-47.294-47.3-47.294zM777.211 435.818h-7.082c-26.122 0-47.296 21.171-47.296 47.294v38.715c0 26.119 21.174 47.296 47.296 47.296h7.082c26.119 0 47.292-21.177 47.292-47.296v-38.715c0-26.122-21.173-47.294-47.292-47.294zM777.211 611.22h-7.082c-26.122 0-47.296 21.17-47.296 47.293v38.716c0 26.115 21.174 47.293 47.296 47.293h7.082c26.119 0 47.292-21.178 47.292-47.293v-38.716c0-26.123-21.173-47.293-47.292-47.293zM601.912 611.22h-7.082c-26.118 0-47.292 21.17-47.292 47.293v38.716c0 26.115 21.174 47.293 47.292 47.293h7.082c26.119 0 47.3-21.178 47.3-47.293v-38.716c0-26.123-21.181-47.293-47.3-47.293zM426.617 611.22h-7.082c-26.121 0-47.296 21.17-47.296 47.293v38.716c0 26.115 21.175 47.293 47.296 47.293h7.082c26.121 0 47.298-21.178 47.298-47.293v-38.716c0-26.123-21.177-47.293-47.298-47.293zM251.32 611.22h-7.08c-26.123 0-47.294 21.17-47.294 47.293v38.716c0 26.115 21.171 47.293 47.294 47.293h7.08c26.123 0 47.294-21.178 47.294-47.293v-38.716c0-26.123-21.171-47.293-47.294-47.293z"
                                fill="#E5594F" />
                            <path
                                d="M299.245 91.914h-7.435c-26.125 0-47.296 19.988-47.296 44.649V312.24c0 24.657 21.171 44.649 47.296 44.649h7.435c26.125 0 47.296-19.992 47.296-44.649V136.563c0-24.661-21.172-44.649-47.296-44.649zM719.956 91.914h-7.438c-26.118 0-47.292 19.988-47.292 44.649V312.24c0 24.657 21.174 44.649 47.292 44.649h7.438c26.123 0 47.296-19.992 47.296-44.649V136.563c0-24.661-21.173-44.649-47.296-44.649z"
                                fill="#6277BA" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ระบบ นัดชมโครงการ</span>

                    </li>
                @else
                    <li>
                        <a href=""
                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-400 group
                    hover:shadow dark:bg-red-400 dark:hover:bg-red-400 dark:text-white">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" class="icon"
                                version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M965.282 186.746H62.449c-25.477 0-46.129 21.177-46.129 47.298v7.139c0 26.121 20.652 47.296 46.129 47.296h902.833c25.48 0 46.131-21.175 46.131-47.296v-7.139c0-26.121-20.65-47.298-46.131-47.298z"
                                    fill="#4A5699" />
                                <path
                                    d="M965.282 821.697H62.449c-25.477 0-46.129 21.173-46.129 47.296v7.141c0 26.119 20.652 47.297 46.129 47.297h902.833c25.48 0 46.131-21.178 46.131-47.297v-7.141c0-26.123-20.65-47.296-46.131-47.296z"
                                    fill="#C45FA0" />
                                <path
                                    d="M69.412 186.746H62.33c-26.121 0-47.294 21.177-47.294 47.298v642.09c0 26.119 21.173 47.297 47.294 47.297h7.082c26.121 0 47.294-21.178 47.294-47.297v-642.09c0.001-26.121-21.173-47.298-47.294-47.298zM964.117 186.746h-7.082c-26.119 0-47.296 21.177-47.296 47.298v642.09c0 26.119 21.177 47.297 47.296 47.297h7.082c26.122 0 47.296-21.178 47.296-47.297v-642.09c0-26.121-21.174-47.298-47.296-47.298z"
                                    fill="#F39A2B" />
                                <path
                                    d="M426.617 435.818h-7.082c-26.121 0-47.296 21.171-47.296 47.294v38.715c0 26.119 21.175 47.296 47.296 47.296h7.082c26.121 0 47.298-21.177 47.298-47.296v-38.715c0-26.122-21.177-47.294-47.298-47.294zM601.912 435.818h-7.082c-26.118 0-47.292 21.171-47.292 47.294v38.715c0 26.119 21.174 47.296 47.292 47.296h7.082c26.119 0 47.3-21.177 47.3-47.296v-38.715c0-26.122-21.181-47.294-47.3-47.294zM777.211 435.818h-7.082c-26.122 0-47.296 21.171-47.296 47.294v38.715c0 26.119 21.174 47.296 47.296 47.296h7.082c26.119 0 47.292-21.177 47.292-47.296v-38.715c0-26.122-21.173-47.294-47.292-47.294zM777.211 611.22h-7.082c-26.122 0-47.296 21.17-47.296 47.293v38.716c0 26.115 21.174 47.293 47.296 47.293h7.082c26.119 0 47.292-21.178 47.292-47.293v-38.716c0-26.123-21.173-47.293-47.292-47.293zM601.912 611.22h-7.082c-26.118 0-47.292 21.17-47.292 47.293v38.716c0 26.115 21.174 47.293 47.292 47.293h7.082c26.119 0 47.3-21.178 47.3-47.293v-38.716c0-26.123-21.181-47.293-47.3-47.293zM426.617 611.22h-7.082c-26.121 0-47.296 21.17-47.296 47.293v38.716c0 26.115 21.175 47.293 47.296 47.293h7.082c26.121 0 47.298-21.178 47.298-47.293v-38.716c0-26.123-21.177-47.293-47.298-47.293zM251.32 611.22h-7.08c-26.123 0-47.294 21.17-47.294 47.293v38.716c0 26.115 21.171 47.293 47.294 47.293h7.08c26.123 0 47.294-21.178 47.294-47.293v-38.716c0-26.123-21.171-47.293-47.294-47.293z"
                                    fill="#E5594F" />
                                <path
                                    d="M299.245 91.914h-7.435c-26.125 0-47.296 19.988-47.296 44.649V312.24c0 24.657 21.171 44.649 47.296 44.649h7.435c26.125 0 47.296-19.992 47.296-44.649V136.563c0-24.661-21.172-44.649-47.296-44.649zM719.956 91.914h-7.438c-26.118 0-47.292 19.988-47.292 44.649V312.24c0 24.657 21.174 44.649 47.292 44.649h7.438c26.123 0 47.296-19.992 47.296-44.649V136.563c0-24.661-21.173-44.649-47.296-44.649z"
                                    fill="#6277BA" />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ นัดชมโครงการ</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>


        <!-- Repeat for other menu items -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Version 2.0
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
    document.addEventListener('DOMContentLoaded', () => {
        const adminButton = document.getElementById('adminButton');
        const adminDropdown = document.getElementById('adminDropdown');

        // Toggle dropdown menu visibility
        adminButton.addEventListener('click', () => {
            adminDropdown.classList.toggle('hidden');
        });

        // Close dropdown menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!adminButton.contains(event.target) && !adminDropdown.contains(event.target)) {
                adminDropdown.classList.add('hidden');
            }
        });
    });
</script>
