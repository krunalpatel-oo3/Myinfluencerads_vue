<div>

    <div class="email_wrapper">

        <h4 class="email_title">
            Hello, {{ $bannedUserFullName }}
        </h4>

        <p class="email_title">You were baned at <a href="{{ $site_home_url }}" target="_blank" class="a_link">{{ $site_name }}</a> site !</p>

        <p class="email_subtitle">Now you can not login under your credentials :<br>
            User's email : {{ $bannedUserEmail }}<br>
            User's full name : {{ $bannedUserFullName }}<br>
            Ban reason : {{ $ban_reason }}
        </p>

        <p class="email_footer">{!! $support_signature !!}</p>

    </div>

</div>
