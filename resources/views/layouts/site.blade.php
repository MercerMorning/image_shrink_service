<html>
<head>
    <link  href="{{ 'css/cropper.css' }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
@yield('content')
<script src="{!! mix('js/app.js') !!}"></script>
@livewireScripts
@livewireStyles
</body>
</html>
