<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Break in attempt! New password</h2>

<div>
    This is you new password: {{$new_pass}}<br/>

    Click this link to confirm your account {{ URL::to('password/account_locked/' . $user_email) }}
    If you have problems, please paste the above URL into your web browser.

</div>

</body>
</html>