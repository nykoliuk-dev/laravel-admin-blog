@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Edit Category Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit category #{{ $currentCategory->id }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.categories.update', ['category' => $currentCategory->slug->getValue()]) }}" method="POST" id="categoryForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Category name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="inputName"
                                        value="{{ old('name', $currentCategory->name) }}"
                                        placeholder="Enter category name"
                                        required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="parent-category-select">Select Parent Category</label>
                                    <select class="form-control" name="parent_id" id="parent-category-select">
                                        @foreach($categoryTree as $category)
                                            <option value="{{ $category->id }}" @selected($category->id == $currentCategory->parent_id)>
                                                {{ str_repeat('— ', $category->depth) . $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="editSlugCheckbox" name="editSlug">
                                        <label class="custom-control-label" for="editSlugCheckbox">Edit slug manually</label>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           id="editSlugInput"
                                           name="slug"
                                           value="{{ $currentCategory->slug->getValue() }}"
                                           disabled
                                    >
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#editSlugCheckbox').on('click', function () {
                if (this.checked) {
                    const result = confirm('⚠️ Changing the URL may break existing links');
                    if (!result) {
                        this.checked = false;
                        return;
                    }
                }

                $('#editSlugInput').prop('disabled', !this.checked);
            });
        });
    </script>
@endpush
