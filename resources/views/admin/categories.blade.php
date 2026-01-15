@extends('layouts.admin.main')

@section('title', 'Categories')

<!-- @push('styles')

@endpush -->

@section('content')

<h1 class='mt-4'>Categories page admin</h1>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    Add category
</button>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form method="POST" action="{{ route('categories.add') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_image" class="form-label">Category Image</label>
                        <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
                        @if($errors->has('category_image'))
                        <small class="text-danger d-block mt-2">{{ $errors->first('category_image') }}</small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">
                        Save Category
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


<table class="table table-hover table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>John</td>
            <td>Doe</td>
            <td>@social</td>
        </tr>
    </tbody>
</table>

@endsection