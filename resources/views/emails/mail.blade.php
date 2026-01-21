<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contact Form Message</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 0;">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd; padding:40px; text-align:center;">
                            <img
                                src="https://res.cloudinary.com/dtotogjvb/image/upload/v1769003661/Group_1_rlhqbh_w4mlzl.png"
                                alt="abstore-logo" width='150'>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#333;">
                            <h1 style="margin-top:0;">Message from {{ $settings->site_name }}'s client</h1>

                            <h3><strong>Name:</strong> {{ $data['name'] }}</h3>
                            <h3><strong>Email:</strong> {{ $data['email'] }}</h3>

                            <h3><strong>Message:</strong></h3>
                            <h3 style="background:#f8f9fa; padding:15px; border-left:4px solid #0d6efd;">
                                {{ $data['message'] }}
                            </h3>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#666;">
                            © {{ date('Y') }} Your Website Name. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>