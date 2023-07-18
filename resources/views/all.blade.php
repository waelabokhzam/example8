<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <table style="border: 1px;">
        <thead>
            <tr>
        <th>image</th>
            </tr>
    </thead>
        <tbody>
            @foreach ($image as $item)
                <tr>
                    <td>
                        <img src="image/{{$item->image}}" /></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
