<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งสิทธิใช้งานระบบ VBNext </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body style="background-color: #f3f4f6; font-family: Arial, sans-serif; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">
        <p style="font-size: 1.2rem; font-weight: bold;">Hello, @php
            $email = $user->email;
            $strEmail = explode('@', $email)[0];
            $strEmail = ucfirst(strtolower($strEmail));
        @endphp

            {{ $strEmail }}</p>
        <p style="margin-top: 20px; color: #4b5563;">ทางฝ่ายเทคโนโลยีสารสนเทศ ได้เปิดสิทธิใช้งานระบบ VBNext
            ให้กับคุณแล้ว!!</p>
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid #e2e8f0;">
            <thead style="background-color: #edf2f7;">
                <tr>
                    <th
                        style="padding: 10px; text-align: left; font-size: 0.75rem; font-weight: bold; color: #4a5568; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                        ระบบ (System)</th>
                    <th
                        style="padding: 10px; text-align: left; font-size: 0.75rem; font-weight: bold; color: #4a5568; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                        สิทธิ์ใช้งาน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">วีบียอนด์เอเจนท์ Agent System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_agent == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">นัดเยี่ยมชมโครงการ Project System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_vproject == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">สต๊อกโครงการ Stock System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->low_rise == 1 || $user->high_rise == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">วิเคราะห์ Report System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_report == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">สินทรัพย์ Assets System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">

                        @if ($user->active_vbasset == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">วีบียอนด์ลิด VBLead System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_vblead == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">รายงานเครื่องพิมพ์ Printer System</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_printer == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">ก่อสร้าง Broker-Construction</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                        @if ($user->active_broker == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;">ห้องเช่า Rental System</td>
                    <td style="padding: 10px;">
                        @if ($user->active_rental == 1)
                        <p style="margin-top: 20px ;color: #31ce31; text-decoration: none; font-weight: bold;">มีสิทธิ์ใช้งาน</p>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 20px;">ลิงค์เข้าสู่ระบบ <a href="https://vbhr.vbeyond.co.th"
                style="color: #3182ce; text-decoration: none; font-weight: bold;">คลิกที่นี่</a></p>
    </div>
</body>

</html>
