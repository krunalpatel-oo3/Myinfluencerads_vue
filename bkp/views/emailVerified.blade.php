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
                position: relative;
                background: #202C54;
                height: 100vh;
                display: block;
                
            }
            .email_main_body{
                padding: 20px 0 30px 0;
                z-index: 10;
            }
            .logo {
                margin-top: 40px;
            }
            .main_table{
                background: #FFF;border-collapse: collapse;max-width: 1000px;width: 100%;box-shadow: 0px 4px 26px rgb(0 0 0 / 8%);
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
                color: #202C54;
                font-size: 42px;
                line-height: 54px;
                font-weight: 700;
                text-align: center;
                margin-bottom: 18px;
                margin-top: 36px;
            }
            .text_tag{
                text-align: center;
                font-weight: 400;
                font-size: 21px;
                line-height: 29px;
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
            .hi-block {
                width: 200px;
                height: 200px;
                background: #F2A91C;
                border-radius: 50%;
                margin: auto;
                margin-top: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .email_verify_body{ padding-bottom: 20px; }
            .follow { font-weight: 500;font-size: 14px;color: #fff; }
            .addr, .copy { color: #F8F9FA; }
            .addr { font-size: 12px;margin-top: 10px; }
            .copy { font-size: 14px; }
            #main { position: relative;     background: #202c54;}
            .failed-block {
                text-align: center;
            }

            @media all and (max-width:1024px){
                .main_table{
                    width: 90%;
                }
            }

            @media (max-width: 767px){
                body{ height: 100vh; }
                .email_body{ padding: 32px 24px; }
                .heading1{
                    font-size: 32px;
                    line-height: 40px;
                }
                .text_tag{
                    font-size: 18px;
                    line-height: 24px;
                }
                .hi-block{
                    width: 120px;
                    height: 120px;
                }
                .hi-block svg {
                    width: 70px;
                    height: 70px;
                }
            }
        </style>
        <!-- <script type="text/javascript">
            @if($status == 1)
                setTimeout(function(){
                    window.location.href = "{{env('FRONT_END_SITE_URL')}}email-verified";
                }, 1);
            @endif            
        </script> -->
    </head>
    <body>
    <center>
        <img class="logo" src="{{ asset('images/email_logo.png') }}" alt="">
        <table id="main" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="email_main_body">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="main_table">
                        <tr class="header_image">
                            <td>
                                @if($status == 1)
                                    <div class="hi-block">
                                        <svg width="120" height="122" viewBox="0 0 120 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M24.8712 51.459L13.1675 82.6768V82.6792C16.0315 94.1208 22.3265 104.235 31.2377 111.865L45.9221 106.358C30.3249 92.3884 22.6265 71.8402 24.8712 51.459Z" fill="white"/>
                                            <path d="M9.20501 93.2437L0.234235 117.163C-0.837969 120.02 1.95691 122.846 4.83518 121.764L23.7608 114.669C17.4128 108.508 12.4886 101.165 9.20501 93.2437Z" fill="white"/>
                                            <path d="M49.9607 48.5471L36.6201 35.2065C25.8037 59.6056 33.1984 87.4937 53.6062 103.477L67.8451 98.1378C55.3399 85.2237 48.5762 67.198 49.9607 48.5471Z" fill="white"/>
                                            <path d="M56.9395 55.5259C57.4875 70.6916 64.0922 85.0234 75.267 95.3523H75.2694L85.7055 91.4399C88.143 90.525 88.8101 87.3965 86.9778 85.5643L56.9395 55.5259Z" fill="white"/>
                                            <path d="M83.0437 66.7542C84.4395 68.1499 86.7023 68.1499 88.0981 66.7542C101.544 53.3082 114.637 57.4653 114.767 57.5087C116.64 58.1327 118.664 57.1208 119.288 55.2482C119.913 53.3761 118.9 51.3516 117.028 50.7273C116.323 50.4926 99.579 45.1645 83.044 61.6998C81.6479 63.0953 81.6477 65.3586 83.0437 66.7542Z" fill="white"/>
                                            <path d="M60.299 38.9543C76.8348 22.4209 71.5048 5.6755 71.2713 4.97022C70.647 3.09744 68.6217 2.08719 66.7489 2.71145C64.8785 3.33571 63.8659 5.3586 64.4902 7.23138C64.5331 7.36243 68.6908 20.4552 55.243 33.9007C53.856 35.2876 53.842 37.549 55.243 38.9543C56.6462 40.3573 58.9071 40.3463 60.299 38.9543Z" fill="white"/>
                                            <path d="M67.8803 46.5369C66.4846 47.9326 66.4846 50.1955 67.8803 51.5912C69.2632 52.9744 71.5103 52.9925 72.9135 51.6124C74.7598 50.6925 80.4906 54.1431 83.6756 50.9594C86.8262 47.8085 83.4787 42.1942 84.3148 40.2266C86.2851 39.3884 91.8972 42.7375 95.0478 39.5871C98.1992 36.4362 94.8515 30.8219 95.6876 28.8541C97.6607 28.0156 103.27 31.3652 106.42 28.2146C109.572 25.0637 106.224 19.4494 107.06 17.4816C109.022 16.6474 114.645 19.9893 117.793 16.8418C120.977 13.6579 117.533 7.9168 118.446 6.07999C119.821 4.68279 119.813 2.43569 118.425 1.04683C117.029 -0.348943 114.766 -0.348943 113.37 1.04683C110.553 3.86387 111.104 7.84079 111.635 10.684C108.792 10.1534 104.815 9.6023 101.998 12.4191C99.1811 15.2361 99.7322 19.2131 100.263 22.0563C97.4195 21.5259 93.4424 20.9743 90.6256 23.7916C87.8085 26.6086 88.3599 30.5856 88.8905 33.4288C86.0468 32.8982 82.0701 32.3468 79.2533 35.1639C76.4363 37.9809 76.9874 41.9578 77.518 44.8011C74.6745 44.271 70.6971 43.7198 67.8803 46.5369Z" fill="white"/>
                                            <path d="M88.098 16.2101C89.4938 14.8143 89.4938 12.5515 88.098 11.1557C86.7023 9.75994 84.4394 9.75994 83.0437 11.1557C81.6479 12.5515 81.6479 14.8143 83.0437 16.2101C84.4394 17.6059 86.7023 17.6059 88.098 16.2101Z" fill="white"/>
                                            <path d="M110.843 42.5294C112.817 42.5294 114.417 40.9292 114.417 38.9554C114.417 36.9815 112.817 35.3813 110.843 35.3813C108.869 35.3813 107.269 36.9815 107.269 38.9554C107.269 40.9292 108.869 42.5294 110.843 42.5294Z" fill="white"/>
                                            <path d="M103.261 71.809C101.865 73.2048 101.865 75.4676 103.261 76.8634C104.657 78.2592 106.92 78.2592 108.316 76.8634C109.711 75.4676 109.711 73.2048 108.316 71.809C106.92 70.4133 104.657 70.4133 103.261 71.809Z" fill="white"/>
                                            <path d="M52.7169 21.2643C54.1127 19.8685 54.1127 17.6057 52.7169 16.2099C51.3211 14.8141 49.0583 14.8141 47.6626 16.2099C46.2668 17.6054 46.2668 19.8685 47.6626 21.2643C49.0583 22.6601 51.3214 22.6601 52.7169 21.2643Z" fill="white"/>
                                        </svg>                                        
                                    </div>
                                @else
                                    <div class="failed-block">
                                        <img src="{{ asset("$image") }}" id="h-img" alt="">
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="email_verify_body">
                                @if($status == 1)
                                    <h4 class="heading1">Congratulations!</h4>
                                @endif
                                <p class="text_tag">
                                    {{$msg}}
                                </p>
                                <!-- <p class="text_tag">
                                    If not redirected in 5 seconds, please click <a href="{{env('FRONT_END_SITE_URL')}}">here</a>
                                </p> -->
                                <!-- <div class="clearfix"></div> -->
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

