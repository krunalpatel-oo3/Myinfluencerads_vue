<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <style>

            *{
                font-family: 'Poppins', sans-serif;
            }

            body{
                margin: 0; padding: 0;font-size: 16px;font-weight: 400;
                font-family: Arial, Helvetica, sans-serif;
            }

            center {
                position: relative;background: #202C54;
            }
            .email_main_body{
                padding: 20px 0 30px 0;
                z-index: 10;
            }

            .logo {
                margin-top: 40px;
            }

            .main_table{
                background: #FFF;border-collapse: collapse;max-width: 600px;
            }

            .header_tr{
                height: 80px;text-align: center;background: rgba(242, 169, 28, .2);
            }

            .header_tr img{
                width: 220px;max-width:80%;padding-top: 8px;
            }

            .email_body{
                padding: 64px 124px;
            }

            .heading1{
                color: #202C54;font-size: 44px;line-height: 54px;font-weight: 500;
                text-align: center;
                margin-bottom: 24px;
                margin-top: 0;
            }

            .text_tag{
                font-size: 16px;color: #202C54;line-height: 24px;text-align: center;
            }
            a { text-decoration: none }
            .btn{
                max-width: 241px;
                font-weight: 600;
                font-size: 16px;
                color: #ffffff !important;
                background: #F2A91C;
                border-radius: 100px;
                text-decoration: none;
                display: block;
                margin: 30px auto 0;
                text-align: center;
                padding: 16px 0;
                cursor: pointer;
            }
            .btn:hover {
                filter: brightness(1.2);
            }
            .soc-logo {
                margin: 0 7px;
                text-decoration: none;
            }

            #h-img {
                object-fit: contain;height: 80px;margin: 20px 0;
            }
            .clearfix{
                clear: both;
            }
            .web-link {
                font-size: 15px;color: #F2A91C;
            }

            @media (max-width: 767px){
                body{
                    height: 100vh;
                }
                .email_body{
                    padding: 32px 24px;
                }
            }

            .follow {
                font-weight: 500;font-size: 14px;color: #FFFFFF;
            }
            .addr, .copy {
                color: #F8F9FA;
            }
            .addr { font-size: 12px;margin-top: 30px; }
            .copy { font-size: 14px; }
            #main {
                position: relative;
            }
        </style>
        <script type="text/javascript">        
            setTimeout(function(){
                window.location.href = "{{env('FRONT_END_SITE_URL')}}"+"membership-plans";
            }, 3);
        </script>
    </head>
    <body>
    <center>
        <img class="logo" src="{{ asset('images/email_logo.png') }}" alt="">
        <table id="main" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="email_main_body">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="main_table">
                        <tr class="header_tr">
                            <td>
                                <img src="{{ asset('images/failed.png') }}" id="h-img" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td class="email_body">
                                <h4 class="heading1">Payment Failed</h4>
                                <p class="text_tag">
                                    Payment failed due to some reason, please try again!!!
                                </p>
                                <p class="text_tag">
                                    If not redirected in 5 seconds, please click <a href="{{env('FRONT_END_SITE_URL')}}membership-plans">here</a>
                                </p>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr align="center">
                <td>
                    <p class="follow">Follow us on</p>
                </td>
            </tr>
            <tr align="center">
                <td>
                    <a href="https://www.facebook.com/streamgeeks/" class="soc-logo" target="_blank">
                        <img src="{{ asset('images/fb-logo.png') }}" alt="">
                    </a>
                    <a href="https://www.instagram.com/streamgeeks/" class="soc-logo" target="_blank">
                        <img src="{{ asset('images/insta-logo.png') }}" alt="">
                    </a>
                    <a href="https://twitter.com/streamgeeks/" class="soc-logo" target="_blank">
                        <img src="{{ asset('images/twitter-logo.png') }}" alt="">
                    </a>
                </td>
            </tr>
            <tr align="center">
                <td>
                    <a href="" class="web-link">www.StreamGeeks.com</a>
                    <p class="addr">152 Robbins Rd, Downingtown, PA 19335 USA</p>
                    <p class="copy">Copyrights Streamgeeks 2022.</p>
                </td>
            </tr>
        </table>
    </center>
    </body>
</html>

