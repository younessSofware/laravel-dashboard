<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <div class="p-5">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf


            <div class="form-group">
              <label for="title">title</label>
              <input type="text" class="form-control" id="title" name="title"  placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="content">content</label>
                <input type="text" class="form-control" id="content" name="content"  placeholder="Enter content">
            </div>
            <div class="form-group">
                <label for="slug">slug</label>
                <textarea class="form-control" id="slug" name="slug"  placeholder="Enter slug"></textarea>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="image" id="formFile">
            </div>

            <button type="submit" class="btn btn-primary my-3">Submit</button>
          </form>
    </div>
</body>
</html>

