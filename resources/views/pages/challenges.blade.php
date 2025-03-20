<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges</title>
</head>
<body>
    <h1>Challenges List</h1>

    @foreach($challenges as $category => $items)
        <h2>{{ $category }}</h2>
        <ul>
            @foreach($items as $challenge)
                <li>
                    <strong>{{ $challenge['name'] }}</strong><br>
                    Points: {{ $challenge['points'] }}<br>
                    Description: {{ $challenge['description'] }}<br>
                    <a href="{{ $challenge['link'] }}" target="_blank">Link</a><br>
                    Answer: {{ $challenge['answer'] }}
                </li>
            @endforeach
        </ul>
    @endforeach

</body>
</html>
