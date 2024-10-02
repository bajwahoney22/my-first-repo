<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password | {{ config('app.name') }}</title>
</head>

<body>
    <form action="{{ route('reset.password') }}" method="POST">
        @csrf
        <input type="hidden" name="email"value="{{ $email }}" placeholder="email" required>
        <input type="hidden" value="{{ $token }}" name="token" required>
        <input type="password" name="password" required>
        @error('password')
            {{ $message }}
            @enderror
        <input type="password" name="password_confirmation" placeholder="password" required>
        <button type="submit">Send</button>
    </form>
</body>

</html>
