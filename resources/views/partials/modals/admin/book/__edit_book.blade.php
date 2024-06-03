<!-- Modal -->
<div class="modal fade" id="editBook_{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="editBookLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookLabel">Edit Book</h5>
                <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body container-fluid">
                        <label for="book_code" class="form-label">Book Code</label>
                        <input autocomplete="off" type="text" autofocus
                            class="form-control @error('book_code') is-invalid @enderror" id="book_code"
                            name="book_code" value="{{ $book->book_code }}">
                        @error('book_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="title_book" class="form-label">Title Book</label>
                        <input autocomplete="off" type="text" autofocus
                            class="form-control @error('title_book') is-invalid @enderror" id="title_book"
                            name="title_book" value="{{ $book->title_book }}">
                        @error('title_book')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="cover" class="form-label">Cover</label>
                        <br>
                        <div class="position-relative">
                            <a class="d-block blur-shadow-image">
                                <img src="{{ $book->cover_url }}" alt="img-blur-shadow" class="shadow border-radius-lg"
                                    style="width: 100%;">
                            </a>
                        </div>
                        <div class="mt-3">
                            <input autocomplete="off" type="file"
                                class="form-control @error('cover') is-invalid @enderror" id="cover" name="cover"
                                value="{{ $book->cover }}">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <label for="language" class="form-label">Language</label>
                        <input autocomplete="off" type="text"
                            class="form-control @error('language') is-invalid @enderror" id="language" name="language"
                            value="{{ $book->language }}">
                        @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="stock" class="form-label">Stock</label>
                        <input autocomplete="off" type="number"
                            class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock"
                            value="{{ $book->stock }}">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="price" class="form-label">Unit Price</label>
                        <input autocomplete="off" type="number"
                            class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ $book->price }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="categories" class="form-label">Categories</label>
                        <select name="categories[]" id="categories_{{ $book->id }}" multiple class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($book->categories->contains($category->id)) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="authors" class="form-label">Authors</label>
                        <select name="authors[]" id="authors_{{ $book->id }}" multiple class="form-control">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @if ($book->authors->contains($author->id)) selected @endif>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="synopsis" class="form-label">Synopsis</label>
                        <textarea required autocomplete="off" cols="20" rows="10" type="text"
                            class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis">{{ $book->synopsis }}</textarea>
                        @error('synopsis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new MultiSelectTag('categories_{{ $book->id }}', {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log('Categories for book {{ $book->id }}:', values);
            }
        });

        new MultiSelectTag('authors_{{ $book->id }}', {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log('Authors for book {{ $book->id }}:', values);
            }
        });
    });
</script>
