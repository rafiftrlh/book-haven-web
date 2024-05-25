<!-- Modal -->
<div class="modal fade" id="createBook" tabindex="-1" role="dialog" aria-labelledby="createBookLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBookLabel">Create Book</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="book_code" class="form-label">Book Code</label>
                            <input required autocomplete="off" type="text"
                                class="form-control @error('book_code') is-invalid @enderror" id="book_code"
                                name="book_code" value="{{ old('book_code') }}">
                            @error('book_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="title_book" class="form-label">Title Book</label>
                            <input required autocomplete="off" type="text"
                                class="form-control @error('title_book') is-invalid @enderror" id="title_book"
                                name="title_book" value="{{ old('title_book') }}">
                            @error('title_book')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="synopsis" class="form-label">Synopsis</label>
                            <textarea required autocomplete="off" cols="20" rows="10" type="text"
                                class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis"
                                value="{{ old('synopsis') }}"></textarea>
                            @error('synopsis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            {{-- @dd($categories) --}}
                            <label for="language" class="form-label">Language</label>
                            <input required autocomplete="off" type="text"
                                class="form-control @error('language') is-invalid @enderror" id="language"
                                name="language" value="{{ old('language') }}">
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <label for="stock" class="form-label">Stock</label>
                            <input required autocomplete="off" type="number"
                                class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock"
                                value="{{ old('stock') }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <label for="categories" class="form-label">Categories</label>
                            <select name="categories" id="categories" multiple>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <label for="authors" class="form-label">Authors</label>
                            <select name="authors" id="authors" multiple>
                                @foreach ($authors as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                            <div class="mb-3">
                                <label for="cover" class="form-label">Cover</label>
                                <input class="form-control" name="cover" type="file" id="cover">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn bg-gradient-danger">Reset</button>
                        <button type="submit" class="btn bg-gradient-primary">Create User</button>
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
    new MultiSelectTag('categories', {
        rounded: true, // default true
        placeholder: 'Search', // default Search...
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        },
        onChange: function(values) {
            console.log(values)
        }
    })

    new MultiSelectTag('authors', {
        rounded: true, // default true
        placeholder: 'Search', // default Search...
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        },
        onChange: function(values) {
            console.log(values.length);
        }
    })
</script>
