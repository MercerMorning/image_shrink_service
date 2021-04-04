{{--<form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">--}}
{{--    @csrf--}}
{{--    <input type="file" name="image">--}}
{{--    <input target="__blank" type="submit" value="Отправить"></p>--}}
{{--    <input type="submit" value="Отправить"></p>--}}
{{--    <input type="radio" name="archiveType" value="zip"> zip--}}
{{--    <input type="radio" name="archiveType" value="rar"> rar--}}
{{--</form>--}}

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
            <label for="archiveType">Zip</label>
            <input type="radio" name="archiveType" id="archiveType" value="zip">

        </div>
        <input type="submit" value="Отправить">
    </form>
</div>

{{--{{ $errors }}--}}
