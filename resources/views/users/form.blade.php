<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('users.store') }}" method="post">
        @csrf

        @if(Session::has('errors'))
            @foreach ($errors->all() as $error)
                <div>
                    <p>{{ $error }}</p>
                </div>
            @endforeach

       @endif

       @if(Session::has('message'))
            <div>
            <p>{{ session()->get('message') }}</p>
            </div>
       @endif

        <input type="text" name="first_name" placeholder="first name">
        <br>
        <input type="text" name="second_name" placeholder="Second name">
        <br>
        <input type="text" name="third_name" placeholder="Third name">
        <br>
        <input type="text" name="last_name" placeholder="Last name">
        <br>
        <input type="number" name="grades" placeholder="Grades">
        <br>
        <input type="number" name="seating_numbers" placeholder="seating Number">
        <br>

        <button type="submit">save</button>

    </form>
</body>
</html>
