<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Email</title>
</head>
<body>
    <h2>You have recieved a contact email</h2>
    <p>Name :  {{ $emailData['name']}}</th>
    <p>Email : {{ $emailData['email']}}</p>
    <p>Subject : {{ $emailData['subject']}}</p>
    <p>Message : </p>
    <p> {{ $emailData['message']}}</p>

</body>
</html>
