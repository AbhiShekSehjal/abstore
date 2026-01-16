@extends('layouts.admin.main')

@section('title', 'Categories')

@push('styles')
<style>
    .addCategoryBtn {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }

    .categoryImage {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }

    .categoryDescription {
        /* display: -webkit-box; */
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">
        <h3><b>Categories</b></h3>
        <button type="button" class="btn btn-outline-dark rounded-0 addCategoryBtn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Add category
        </button>
    </div>



    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

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
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category_image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*" required>
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
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <tbody>

            @forelse($categories as $category)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $category->category_image) }}" alt="Section_3_Image" class="categoryImage"
                        data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                </td>
                <td>{{$category->name}}</td>
                <td>{{$category->slug}}</td>
                <td class="categoryDescription">{{$category->description}}</td>
                @empty
                <div class="text-center">
                    <h3>No Category Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>


</div>


@endsection

@push('scripts')
@if($errors->any())
<script>
    const modal = new bootstrap.Modal(
        document.getElementById('addCategoryModal')
    );
    modal.show();
</script>
@endif
@endpush