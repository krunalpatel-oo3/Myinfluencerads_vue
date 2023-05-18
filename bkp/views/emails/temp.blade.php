<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <style>
            *{
                font-family: Arial, Helvetica, sans-serif;
            }
            body{
                margin: 0; padding: 0;background-color: #fcfcfc;font-size: 16px;font-weight: 400;
                font-family: Arial, Helvetica, sans-serif;
            }
            .email_main_body{padding: 20px 0 30px 0;}
            .main_table{
                background: #FFF;border-collapse: collapse;
            }
            .header_tr{
                height: 80px;background-color: rgba(56,56,56,0.8);text-align: center;
            }
            .header_tr img{
                width: 220px;max-width:80%;padding-top: 8px;
            }
            .email_body{
                padding: 40px 40px 0px 40px;border-radius: 2px;border:1px solid #bbbbbb47;
            }
            .heading1{
                font-size:20px;margin-bottom: 15px;font-weight:600;
            }
            .text_tag{
                line-height: 25px;margin-top: 0;
            }
            .footer{
                text-align: center;float: left;width: 100%;
                margin-top: 20px;
                color: #828282;
            }
            .btn{
                margin-top: 30px;width:500px;
                max-width: 100%;
                font-size: 16px;
                letter-spacing: 1px;
                text-align: center;
                color: #ffffff !important;
                padding: 18px 10px;
                background-color: rgba(56,56,56,0.8);
                border-radius: 2px;
                text-decoration: none;
                float: left;
            }
            .clearfix{
                clear: both;
            }
            @media (max-width: 767px){
                body{
                    height: 100vh;
                }
            }
        </style>
    </head>
    <body>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="email_main_body">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" class="main_table">
                        <tr class="header_tr">
                            <td><img src="/uploads/logo.png"></td>
{{--                            <td><img src="http://localhost/laravel/2021/stream_geeks_spa_v2/public/uploads/logo.png"></td>--}}
                        </tr>
                        <tr>
                            <td class="email_body">
                                <h4 class="heading1">Hi, User!</h4>

                                <p class="text_tag">
                                    Thank you for signing up.To complete email verification, please press the button below
                                </p>
                                <div class="clearfix"></div>

                                <a href="" class="btn">Verify Email</a>

                                <div class="footer">
                                    <p>&COPY; Stream Geeks</p>
                                </div>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>
