<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TwitterAPI環境</title>
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div>
    <form enctype="multipart/form-data" id="post-form" action="{{ action('TwitterController@store') }}" method="POST">
    @csrf

      <div>
      
      <div>
        <input type="file" name="file">
      </div>

      <div>
        <p class="txt">コメント</p>
        <textarea id="comment" name="comment" class="formtype-3 input-form" placeholder="">{{ old('comment') }}</textarea>
      </div>


      <button id="submit-btn" name="post-form" class="btn-0" type="submit">投稿</button>
      </div>
    </form>
  </div>
  
</body>
</html>