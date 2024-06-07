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
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/Loopple/loopple-public-assets@main/riva-dashboard-tailwind/riva-dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
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

        .sup-role {
            cursor: pointer;
        }

        .swal2-container .swal2-popup .swal2-html-container {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .swal2-container .swal2-popup .swal2-html-container input,
        .swal2-container .swal2-popup .swal2-html-container select {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>


<body class="gradient">

    @include('sweetalert::alert')

    <!-- component -->

    <div class="flex flex-wrap -mx-3 mb-5">
        <div class="w-full max-w-full px-3 mb-6  mx-auto">
            <div
                class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
                <div
                    class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
                    <!-- card header -->
                    <div
                        class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                        <h3
                            class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
                            <span class="mr-3 font-semibold text-dark">ผู้ใช้งานระบบทั้งหมด
                                <span
                                    class="align-baseline inline-flex px-4 py-3 mr-auto items-center font-semibold text-[.95rem] leading-none text-success bg-success-light rounded-lg">
                                    Active {{ $CountUserActive }} คน
                                </span>
                                <span
                                    class="align-baseline inline-flex px-4 py-3 mr-auto items-center font-semibold text-[.95rem] leading-none text-dark bg-dark-light rounded-lg">
                                    Disable {{ $CountUserUnActive }} คน
                                </span>
                            </span>

                            {{-- <span
                                class="mt-1 font-medium text-secondary-dark text-lg/normal">*ระบบไม่ได้เชื่อมต่อกับระบบ
                                HR</span> --}}
                        </h3>
                        <form method="GET" action="{{ route('users') }}">
                            <div class="relative flex flex-wrap items-center my-2 ml-n2">
                                <input type="text" name="code" id="code" class="mr-2" placeholder="code"
                                    autocomplete="">

                                <input type="text" name="email" id="email" class="mr-2" placeholder="email"
                                    autocomplete="">
                                <button
                                    class="mr-2 inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-light focus:bg-light">
                                    ค้นหา </button>
                                    <a href="{{route('users')}}"
                                    class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-light focus:bg-light">
                                    ยกเลิก </a>
                            </div>
                        </form>
                        <div class="relative flex flex-wrap items-center my-2">

                            <button id="Create"
                                class="mr-2 inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-green focus:bg-light">
                                เพิ่มผู้ใช้งานระบบ
                            </button>
                            <button
                            class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-green focus:bg-light">
                            พิมพ์
                        </button>

                        </div>
                    </div>
                    <!-- end card header -->

                    <!-- card body  -->
                    <div class="flex-auto block py-8 pt-6 px-9">
                        <div class="overflow-x-auto">
                            <table class="w-full my-0 align-middle text-dark border-neutral-200">
                                <thead class="align-bottom">
                                    <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                        <th class="pb-3 text-start min-w-[200px]">Email</th>
                                        <th class="pb-3 text-end min-w-[100px]">Agent</th>
                                        <th class="pb-3 text-end min-w-[100px]">Project</th>
                                        <th class="pb-3 text-end min-w-[100px]">Stock</th>
                                        <th class="pb-3 text-end min-w-[100px]">Report</th>
                                        <th class="pb-3 text-end min-w-[100px]">Assets</th>
                                        <th class="pb-3 text-end min-w-[100px]">VBLead</th>
                                        <th class="pb-3 text-end min-w-[100px]">Printer</th>
                                        <th class="pb-3 text-end min-w-[100px]">BrokerCons.</th>
                                        <th class="pb-3 text-end min-w-[100px]">Rental</th>
                                        <th class="pb-3 text-end min-w-[100px] text-red-500">Admin VBNext</th>
                                        <th class="pb-3 text-end min-w-[100px]">สถานะผู้ใช้งาน</th>
                                        <th class="pb-3 text-end min-w-[60px]">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="border-b border-dashed last:border-b-0">
                                            <td class="p-3 pl-0">
                                                <div class="flex items-center">
                                                    <div class="relative inline-block shrink-0 rounded-2xl me-3">
                                                        <img src="{{ url('uploads/logo/logo_gold.png') }}"
                                                            class="w-[50px] h-[50px] md:rounded-none rounded-full mx-auto"
                                                            alt="">
                                                    </div>
                                                    <div class="flex flex-col justify-start">
                                                        <span
                                                            class="text-center align-baseline inline-flex px-4 py-3 mr-auto items-center font-semibold text-[.95rem] leading-none text-primary bg-primary-light rounded-lg">
                                                            {{ $user->code }}</span>
                                                        {{-- <span
                                                            class="font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary">
                                                            {{ optional(optional($user->apiData)['data'])['name_th'] }}</span> --}}
                                                        <span
                                                            class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary">
                                                            {{ $user->email }} </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Agent -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value="" class="sr-only peer active-agent-checkbox" data-id="{{ $user->id }}"
                                                        {{ $user->active_agent == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_agent == 1)
                                                    <p
                                                        class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                                        Null
                                                    </p>
                                                @endif
                                            </td>
                                            <!-- VProject -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value="" class="sr-only peer active-vproject-checkbox" data-id="{{ $user->id }}"
                                                        {{ $user->active_vproject == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_vproject == 1)
                                                    <p
                                                        class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                                        Null
                                                    </p>
                                                @endif
                                            </td>
                                            <!-- Stock -->
                                            <td class="pb-3 pr-0 text-end">
                                                <p
                                                class="items-center gap-1 text-xs font-semibold mr-4">
                                                low | high
                                            </p>
                                                <label class="inline-flex items-center cursor-pointer mt-2">

                                                    <input type="checkbox" value="" class="mr-2 sr-only peer active-low_rise-checkbox"  data-id="{{ $user->id }}"
                                                    {{ $user->low_rise == 1 ? 'checked' : '' }}>

                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>



                                                </label>
                                                <label class="inline-flex items-center cursor-pointer mt-2">
                                                <input type="checkbox" value="" class="sr-only peer active-high_rise-checkbox"  data-id="{{ $user->id }}"
                                                {{ $user->high_rise == 1 ? 'checked' : '' }}>

                                                <div
                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                </div>
                                            </label>
                                                @if ($user->low_rise == 1 || $user->high_rise == 1)
                                                    <p
                                                        class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                                        Null
                                                    </p>
                                                @endif
                                            </td>
                                            <!-- Report -->
                                            <td class="pb-3 pr-0 text-end">

                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        data-id="{{ $user->id }}"
                                                        class="sr-only peer active-report-checkbox"
                                                        {{ $user->active_report == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_report == 1)
                                                    <p
                                                        class=" items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600">
                                                        {{ optional($user->role_report_ref)->level ? optional($user->role_report_ref)->level : 'Null' }}
                                                    </p>
                                                @endif
                                            </td>

                                            <!-- Asset -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-vbasset-checkbox"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->active_vbasset == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_vbasset == 1)
                                                <p
                                                    class=" items-center gap-1 rounded-full bg-yellow-50 px-2 py-1 text-xs font-semibold text-yellow-600">
                                                    Admin
                                                </p>
                                                @endif
                                            </td>
                                            <!-- Lead -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-vblead-checkbox"
                                                        {{ $user->active_vblead == 1 ? 'checked' : '' }}
                                                        data-id="{{ $user->id }}">
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_vblead == 1)
                                                    <p
                                                        class=" items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600">
                                                        Null
                                                    </p>
                                                @endif
                                            </td>

                                            <!-- Printer -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" data-id="{{ $user->id }}"
                                                        value="" class="sr-only peer active-printer-checkbox"
                                                        {{ $user->active_printer == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_printer == 1)
                                                    @foreach (['SuperAdmin' => 'red', 'Admin' => 'yellow', 'Staff' => 'blue', 'User' => 'purple'] as $role => $color)
                                                        @if (optional($user->role_printer_ref)->role_type == $role)
                                                            <p class="sup-role items-center gap-1 rounded-full bg-{{ $color }}-50 px-2 py-1 text-xs font-semibold text-{{ $color }}-600 role-type-printer"
                                                                data-id="{{ $user->id }}"
                                                                data-role-type="{{ $role }}">
                                                                {{ $role }}
                                                            </p>
                                                        @endif
                                                    @endforeach

                                                    @if (!in_array(optional($user->role_printer_ref)->role_type, ['SuperAdmin', 'Admin', 'Staff', 'User']))
                                                        <p class="sup-role items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600 role-type-printer"
                                                            data-id="{{ $user->id }}" data-role-type="Null">
                                                            Null
                                                        </p>
                                                    @endif
                                                @endif

                                            </td>
                                            <!-- Broker -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-broker-checkbox"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->active_broker == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_broker == 1)
                                                    @foreach (['SuperAdmin' => 'red', 'Admin' => 'yellow', 'Staff' => 'blue', 'User' => 'purple'] as $role => $color)
                                                        @if (optional($user->role_printer_ref)->role_type == $role)
                                                            <p class="sup-role items-center gap-1 rounded-full bg-{{ $color }}-50 px-2 py-1 text-xs font-semibold text-{{ $color }}-600 role-type-printer"
                                                                data-id="{{ $user->id }}"
                                                                data-role-type="{{ $role }}">
                                                                {{ $role }}
                                                            </p>
                                                        @endif
                                                    @endforeach

                                                    {{-- @if (!in_array(optional($user->role_printer_ref)->role_type, ['SuperAdmin', 'Admin', 'Staff', 'User']))
                                                    <p class="sup-role items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600 role-type-printer"
                                                        data-id="{{ $user->id }}" data-role-type="Null">
                                                        Null
                                                    </p>
                                                @endif --}}
                                                @endif
                                            </td>
                                            <!-- Rent -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-rental-checkbox"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->active_rental == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                                @if ($user->active_rental == 1)
                                                    @foreach (['SuperAdmin' => 'red', 'Admin' => 'yellow', 'Staff' => 'blue', 'User' => 'purple'] as $role => $color)
                                                        @if (optional($user->role_printer_ref)->role_type == $role)
                                                            <p class="sup-role items-center gap-1 rounded-full bg-{{ $color }}-50 px-2 py-1 text-xs font-semibold text-{{ $color }}-600 role-type-printer"
                                                                data-id="{{ $user->id }}"
                                                                data-role-type="{{ $role }}">
                                                                {{ $role }}
                                                            </p>
                                                        @endif
                                                    @endforeach

                                                    {{-- @if (!in_array(optional($user->role_printer_ref)->role_type, ['SuperAdmin', 'Admin', 'Staff', 'User']))
                                                    <p class="sup-role items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600 role-type-printer"
                                                        data-id="{{ $user->id }}" data-role-type="Null">
                                                        Null
                                                    </p>
                                                @endif --}}
                                                @endif
                                            </td>
                                            <!-- VBNext -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-vbis-checkbox"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->active_vbis == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>

                                            </td>
                                            <!-- Active -->
                                            <td class="pb-3 pr-0 text-end">
                                                <label class="inline-flex items-center cursor-pointer mt-4">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer active-user-checkbox"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->active == 1 ? 'checked' : '' }}>
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                    </div>

                                                </label>
                                            </td>
                                            <!-- Action -->
                                            <td class="pb-3 pr-0 text-end">
                                                <button
                                                    class="ml-auto relative text-secondary-dark bg-light-dark hover:text-primary flex items-center h-[25px] w-[25px] text-base font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-200 ease-in-out shadow-none border-0 justify-center">
                                                    <span
                                                        class="flex items-center justify-center p-0 m-0 leading-none shrink-0 ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                        </svg>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    $(document).ready(function() {
        localStorage.setItem('previousURL', window.location.href);

        $('.active-report-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "report",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-printer-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "printer",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-user-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "user",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-vbis-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "vbis",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-rental-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "rental",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-broker-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "broker",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-vbasset-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "vbasset",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-vblead-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "vblead",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-agent-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "agent",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-vproject-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "vproject",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-high_rise-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "stock_h",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        $('.active-low_rise-checkbox').on('change', function() {
            const userId = $(this).data('id');
            const isChecked = $(this).is(':checked');
            //console.log(userId);
            $.ajax({
                url: '{{ route('update.active') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    active_type: "stock_l",
                    user_id: userId,
                    active: isChecked ? 1 : 0
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success = true) {

                        if ($.isEmptyObject(data.error)) {

                            Swal.fire({
                                // toast: true,
                                icon: "success",
                                title: "Success",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Redirect ไปยัง URL ที่เก็บไว้
                                var previousURL = localStorage.getItem(
                                    'previousURL');
                                if (previousURL) {
                                    window.location.href = previousURL;
                                } else {
                                    window.location.href = '{{ route('users') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: `${data.message}`,
                                showConfirmButton: false,
                                timer: 1500
                            });


                        }

                    }
                },
                error: function() {
                    console.log('AJAX error');
                    Swal.fire({
                        icon: "error",
                        title: "AJAX error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.role-type-printer').on('click', function() {
            const userId = $(this).data('id');
            const currentRole = $(this).data('role-type');
            // console.log(currentRole);
            Swal.fire({
                title: 'Change Role Type',
                input: 'select',
                inputOptions: {
                    'SuperAdmin': 'SuperAdmin',
                    'Admin': 'Admin',
                    'Staff': 'Staff',
                    'User': 'User'
                },
                inputValue: currentRole,
                showCancelButton: true,
                confirmButtonText: 'Change',
                showLoaderOnConfirm: true,
                preConfirm: (newRole) => {
                    return $.ajax({
                        url: '{{ route('update.role') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId,
                            role_type: newRole,
                            role_system: "printer"
                        },
                        success: function(data) {
                            //console.log(data);
                            if (data.success = true) {

                                if ($.isEmptyObject(data.error)) {

                                    Swal.fire({
                                        // toast: true,
                                        icon: "success",
                                        title: "Success",
                                        html: `${data.message}`,
                                        timer: 1500
                                    }).then(function() {
                                        // Redirect ไปยัง URL ที่เก็บไว้
                                        var previousURL = localStorage
                                            .getItem(
                                                'previousURL');
                                        if (previousURL) {
                                            window.location.href =
                                                previousURL;
                                        } else {
                                            window.location.href =
                                                '{{ route('users') }}';
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        html: `${data.message}`,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });


                                }

                            }
                        },
                        error: function() {
                            console.log('AJAX error');
                            Swal.fire({
                                icon: "error",
                                title: "AJAX error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById('Create').addEventListener('click', function() {
        Swal.fire({
            title: 'เพิ่มผู้ใช้งานระบบ',
            html: `
                <select id="method">
                    <option value="" selected disabled>เลือกวิธีการเพิ่ม</option>
                    <option value="code">เพิ่มด้วย รหัสพนักงาน</option>
                    <option value="email">เพิ่มด้วย Email</option>
                </select>
                <input type="text" id="code" name="code" placeholder="รหัสพนักงาน" style="display: none;">
                <input type="email" id="email" name="email" placeholder="Email" style="display: none;">
            `,
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            didOpen: () => {
                const methodSelect = Swal.getPopup().querySelector('#method');
                const codeInput = Swal.getPopup().querySelector('#code');
                const emailInput = Swal.getPopup().querySelector('#email');

                methodSelect.addEventListener('change', (event) => {
                    const value = event.target.value;
                    if (value === 'code') {
                        emailInput.style.display = 'none';
                        codeInput.style.display = 'block';
                    } else if (value === 'email') {
                        emailInput.style.display = 'block';
                        codeInput.style.display = 'none';
                    } else {
                        emailInput.style.display = 'none';
                        codeInput.style.display = 'none';
                    }
                });
            },
            preConfirm: () => {
                const method = Swal.getPopup().querySelector('#method').value;
                if (!method) {
                    Swal.showValidationMessage('กรุณาเลือกวิธีการเพิ่ม');
                    return false;
                }

                if (method === 'code') {
                    const code = Swal.getPopup().querySelector('#code').value;
                    if (!code) {
                        Swal.showValidationMessage('กรุณากรอก รหัสพนักงาน');
                        return false;
                    }
                    return {
                        method: method,
                        code: code
                    };
                } else if (method === 'email') {
                    const email = Swal.getPopup().querySelector('#email').value;
                    if (!email) {
                        Swal.showValidationMessage('กรุณากรอกข้อมูลให้ครบถ้วน');
                        return false;
                    }
                    return {
                        method: method,
                        email: email
                    };
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Handle form submission
                console.log(result.value);
                // คุณสามารถใช้ AJAX เพื่อส่งข้อมูลนี้ไปยังเซิร์ฟเวอร์
                // หรือจัดการในวิธีที่คุณต้องการ
            }
        });
    });


    });
</script>
