@extends('layouts.admin.main')

@section('title', 'Categories')

@push('styles')
<style>
    .addCategoryBtn {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }

    .searchBtn {
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
        line-clamp: 1;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Small screens */
    @media (max-width: 575.98px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .d-flex.align-items-center.justify-content-between.mb-1 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        h1 {
            font-size: 1.5rem;
        }

        .row.g-3 {
            flex-direction: column;
            gap: 0.75rem !important;
        }

        .row.g-3>div,
        .row.g-3>button {
            width: 100% !important;
        }

        .table {
            font-size: 0.85rem;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.25rem !important;
        }

        .btn {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.75rem !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .categoryImage {
            width: 35px;
            height: 35px;
        }

        .modal-body {
            padding: 1rem 0.75rem;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
        }
    }

    /* Medium screens */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .table {
            font-size: 0.9rem;
        }

        h1 {
            font-size: 1.75rem;
        }

        .row.g-3 {
            gap: 0.75rem !important;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-4 px-0">

    <div class="d-flex align-items-center justify-content-between mb-1">

        <div class="d-flex align-items-start">
            <h1>Categories</h1>
            <span class="badge text-success">{{ $categories->total() }}</span>
        </div>


        <!-- Search and Sort Section -->
        <div class="row g-2 w-100 w-md-auto">
            <div class="col-sm-3 col-lg-3 col-md-6 ms-auto">
                <form method="GET" action="{{ route('admin.categories') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control rounded-0" placeholder="Search categories by name or description..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'name_asc' }}">
                    <button type="submit" class="btn btn-outline-dark rounded-0 searchBtn">Search</button>
                    @if($search)
                    <a href="{{ route('admin.categories') }}" class="btn btn-secondary rounded-0">Clear</a>
                    @endif
                </form>
            </div>

            <div class="col-sm-3 col-lg-3 col-md-6 me-2">
                <form method="GET" action="{{ route('admin.categories') }}" class="d-flex gap-2">
                    <select name="sort" class="form-select rounded-0" onchange="this.form.submit()">
                        <option value="name_asc" {{ ($sort ?? 'name_asc') === 'name_asc' ? 'selected' : '' }}>Sort: Name (A-Z)</option>
                        <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Sort: Name (Z-A)</option>
                        <option value="newest" {{ ($sort ?? '') === 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Sort: Oldest First</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                </form>
            </div>

        </div>

        <button type="button" class="col-sm-3 col-lg-2 col-md-6 btn btn-outline-dark rounded-0 addCategoryBtn ms-auto" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
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

    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="viewCategoryImage" src="" alt="Category Image" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Category Name</strong></label>
                        <p id="viewCategoryName" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Slug</strong></label>
                        <p id="viewCategorySlug" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Description</strong></label>
                        <p id="viewCategoryDescription" class="form-control-plaintext"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('categories.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="editCategoryId" name="category_id">

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" id="editCategoryName" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="editCategoryDescription" name="description" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editCategoryImage" class="form-label">Category Image (Optional)</label>
                            <input type="file" class="form-control" id="editCategoryImage" name="category_image" accept="image/*">
                            <small class="form-text text-muted d-block mt-2">Leave empty to keep current image</small>
                            @if($errors->has('category_image'))
                            <small class="text-danger d-block mt-2">{{ $errors->first('category_image') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-warning">
                            Update Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteCategoryName"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCategoryForm" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" id="deleteCategoryId" name="category_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
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
                    <td>
                        <button type="button" class="btn rounded-0 btn-sm  view-category-btn" data-bs-toggle="modal" data-bs-target="#viewCategoryModal"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-slug="{{ $category->slug }}"
                            data-description="{{ $category->description }}"
                            data-image="{{ asset('storage/' . $category->category_image) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                            </svg>
                        </button>
                        <button type="button" class="btn rounded-0 btn-sm edit-category-btn" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-description="{{ $category->description }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                            </svg>
                        </button>
                        <button type="button" class="btn rounded-0 btn-sm delete-category-btn" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                            </svg>
                        </button>
                    </td>
                    @empty
                    <div class="text-center">
                        <h3>No Category Found.</h3>
                    </div>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 ms-auto">
        <nav>
            {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
        </nav>
    </div>

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View Category Button Handler
        document.querySelectorAll('.view-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const slug = this.getAttribute('data-slug');
                const description = this.getAttribute('data-description');
                const image = this.getAttribute('data-image');

                viewCategory(id, name, slug, description, image);
            });
        });

        // Edit Category Button Handler
        document.querySelectorAll('.edit-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');

                editCategory(id, name, description);
            });
        });

        // Delete Category Button Handler
        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                deleteCategory(id, name);
            });
        });
    });

    function viewCategory(id, name, slug, description, image) {
        document.getElementById('viewCategoryName').textContent = name;
        document.getElementById('viewCategorySlug').textContent = slug;
        document.getElementById('viewCategoryDescription').textContent = description;
        document.getElementById('viewCategoryImage').src = image;
    }

    function editCategory(id, name, description) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryDescription').value = description;
    }

    function deleteCategory(id, name) {
        document.getElementById('deleteCategoryId').value = id;
        document.getElementById('deleteCategoryName').textContent = name;
        document.getElementById('deleteCategoryForm').action = "{{ route('categories.delete') }}";
    }
</script>
@endpush