@csrf
<div class="form-group">
    <label for="title">title : </label>
    <input class="form-control"  id="title" name="title" type="text" value="{{old('title' , $post->title ?? null)}}" />
</div>

<div class="form-group">
    <label for="content">content : </label>
    <input class="form-control"  id="content" name="content" type="text" value="{{old('content' , $post->content ?? null)}}" />
</div>
<div class="form-group">
    <label for="picture">picture :</label>
    <input type="file" name="picture" id="picture" class="form-control-file" />
</div>
<x-errors my-class="warning"></x-errors>
