{{--<form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">--}}
{{--    @csrf--}}
{{--    <input type="file" name="image">--}}
{{--    <input target="__blank" type="submit" value="Отправить"></p>--}}
{{--    <input type="submit" value="Отправить"></p>--}}
{{--    <input type="radio" name="archiveType" value="zip"> zip--}}
{{--    <input type="radio" name="archiveType" value="rar"> rar--}}
{{--</form>--}}


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container" id="app">
    <form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">
        @csrf
            <prop-component></prop-component>
    </form>
</div>
<script src="js/app.js"></script>
{{--{{ $errors }}--}}
