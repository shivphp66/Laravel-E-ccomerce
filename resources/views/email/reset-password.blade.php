<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>
   <h2>You have requested to reset password.</h2>
  <p>Please click blow kink for reset password.</p>
  <p>Hellow, {{ $formData['user']->name }}
  <a href="{{ route('account.processResetPassword',$formData['token'])}}">Click here</a>
  <p>Thanks</p>
</body>
</html>
