<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<div class="wrapper">

	<h4 class="email_title">
		Hello, {{ $to_username }}
	</h4>

	<p class="email_title">You were baned at <a href="{{ $site_home_url }}" target="_blank" class="a_link">{{ $site_name }}</a> site !</p>

	<p class="email_subtitle">Now you can not login under your credentials :<br>
		User's email : {{ $to_user_email }}<br>
        Ban reason : {{ $ban_reason }}
	</p>

	<p class="email_footer">{!! $support_signature !!}</p>

</div>
</body>
</html>
