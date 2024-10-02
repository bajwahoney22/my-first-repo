<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Dear User,</p>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    {{-- <p><a href="{{ url('reset-password/'.$token) }}">Reset Password</a></p> --}}
    <p><a href="{{ $url }}">Reset Password</a></p>
    <p>If you did not request a password reset, please ignore this email.</p>
</body>
</html>
