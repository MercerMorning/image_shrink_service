<form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" name="image">
{{--    <input target="__blank" type="submit" value="Отправить"></p>--}}
    <input type="submit" value="Отправить"></p>
    <input type="radio" name="archiveType" value="zip"> zip
    <input type="radio" name="archiveType" value="rar"> rar
</form>
{{ $errors }}
