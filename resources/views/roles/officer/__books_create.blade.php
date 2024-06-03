<div class="container-fluid p-4">
    <a href="{{ route('officer.data_buku') }}" class="d-flex align-items-center gap-2 py-2 px-3 "
        style="width: fit-content; border: 1px solid gray; border-radius: 100px;">
        <svg style="rotate: -90deg" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="m6 10l10-8l10 8M16 2v28" />
        </svg>
        <span style="font-weight: 700; font-size: 12px;">Back</span>
    </a>
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="book_code" class="form-label">Book Code</label>
            <input required autocomplete="off" type="text"
                class="form-control @error('book_code') is-invalid @enderror" id="book_code" name="book_code"
                value="{{ old('book_code') }}">
            @error('book_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="title_book" class="form-label">Title Book</label>
            <input required autocomplete="off" type="text"
                class="form-control @error('title_book') is-invalid @enderror" id="title_book" name="title_book"
                value="{{ old('title_book') }}">
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
                class="form-control @error('language') is-invalid @enderror" id="language" name="language"
                value="{{ old('language') }}">
            @error('language')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="stock" class="form-label">Stock</label>
            <input required autocomplete="off" type="number" class="form-control @error('stock') is-invalid @enderror"
                id="stock" name="stock" value="{{ old('stock') }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="price" class="form-label">Unit Price</label>
            <input required autocomplete="off" type="number" class="form-control @error('price') is-invalid @enderror"
                id="price" name="price" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="categories" class="form-label">Categories</label>
            <select name="categories[]" id="categories" multiple>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
            <label for="authors" class="form-label">Authors</label>
            <select name="authors[]" id="authors" multiple>
                @foreach ($authors as $a)
                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                @endforeach
            </select>
            <label for="cover" class="form-label">Cover</label>
            <input class="form-control" name="cover" type="file" id="cover">
        </div>
        <div class="">
            <button type="reset" class="btn bg-gradient-danger" id="resetBtn">Reset</button>
            <button type="submit" class="btn bg-gradient-primary">Create Book</button>
        </div>
    </form>
</div>

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
<script>
    // Inisialisasi multiselect
    new MultiSelectTag('categories', {
        rounded: true,
        placeholder: 'Search',
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        }
    });

    new MultiSelectTag('authors', {
        rounded: true,
        placeholder: 'Search',
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        }
    });
</script>
