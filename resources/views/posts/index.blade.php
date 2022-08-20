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
        <a href="{{ route('posts.create') }}" class=" btn btn-primary">Add Post</a>
        <div class="row mt-5">
            @foreach ($posts as $post)
            <div class="col-4 position-relative" >
                <a  class="btn btn-danger position-absolute top-0 m-2" style="right: 0; z-index:2">
                    <form action="{{route('posts.destroy', $post->id)}}" method="post">
                    <button class="btn btn-danger" type="submit">
                        @csrf @method('DELETE') Remove
                    </button>
                    </form>
                </a>

                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title"> {{ $post->title }}</h5>
                      <p class="card-text"> {{ $post->content }}</p>
                      <p class="card-text"> {{ $post->slug }}</p>
                      <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</body>
</html>

