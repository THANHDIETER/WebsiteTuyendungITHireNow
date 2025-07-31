<div>
    <label>Tiêu đề</label><br>
    <input type="text" name="title" value="{{ old('title', $blog->title ?? '') }}" required><br><br>

    <label>Nội dung</label><br>
    <textarea name="content" rows="5" required>{{ old('content', $blog->content ?? '') }}</textarea><br><br>

    <label>Ảnh (link)</label><br>
    <input type="text" name="image" value="{{ old('image', $blog->image ?? '') }}"><br><br>

    <label>Tác giả</label><br>
    <input type="text" name="author" value="{{ old('author', $blog->author ?? '') }}"><br><br>
</div>

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
