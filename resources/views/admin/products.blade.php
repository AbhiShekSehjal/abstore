@extends('layouts.admin.main')

@section('title', 'Products')

@push('styles')
<style>
    .addProductBtn {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }

    .searchBtn {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }

    .productImage {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }

    .productDescription {
        /* display: -webkit-box; */
        line-clamp: 1;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">

        <div class="d-flex align-items-start">
            <h1>Products</h1>
            <span class="badge text-success">{{ $products->total() }}</span>
        </div>


        <!-- Search and Sort Section -->
        <div class="row g-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.products') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control rounded-0" placeholder="Search products by name or description..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'name_asc' }}">
                    <button type="submit" class="btn btn-outline-dark rounded-0 searchBtn">Search</button>
                    @if($search)
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary rounded-0">Clear</a>
                    @endif
                </form>
            </div>

            <div class="col-md-3">
                <form method="GET" action="{{ route('admin.products') }}" class="d-flex gap-2">
                    <select name="sort" class="form-select rounded-0" onchange="this.form.submit()">
                        <option value="name_asc" {{ ($sort ?? 'name_asc') === 'name_asc' ? 'selected' : '' }}>Sort: Name (A-Z)</option>
                        <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Sort: Name (Z-A)</option>
                        <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>Sort: Price (Low to High)</option>
                        <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>Sort: Price (High to Low)</option>
                        <option value="stock_asc" {{ ($sort ?? '') === 'stock_asc' ? 'selected' : '' }}>Sort: Stock (Low to High)</option>
                        <option value="stock_desc" {{ ($sort ?? '') === 'stock_desc' ? 'selected' : '' }}>Sort: Stock (High to Low)</option>
                        <option value="newest" {{ ($sort ?? '') === 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Sort: Oldest First</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                </form>
            </div>
            <button type="button" class="col-md-3 btn btn-outline-dark rounded-0 addProductBtn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add Product
            </button>
        </div>
    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('products.add') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" placeholder="Product Name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" id="price" name="price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount (%)</label>
                            <input type="number" id="discount" name="discount" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="number" id="sale_price" name="sale_price" class="form-control" readonly>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            @if($errors->has('image'))
                            <small class="text-danger d-block mt-2">{{ $errors->first('image') }}</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="hoverProductImage" class="form-label">Hover Product Image</label>
                            <input type="file" class="form-control" id="hoverProductImage" name="hoverProductImage" accept="image/*" required>
                            @if($errors->has('hoverProductImage'))
                            <small class="text-danger d-block mt-2">{{ $errors->first('hoverProductImage') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success">
                            Save Product
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- View Product Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="viewProductImage" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Product Name</strong></label>
                        <p id="viewProductName" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Slug</strong></label>
                        <p id="viewProductSlug" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Description</strong></label>
                        <p id="viewProductDescription" class="form-control-plaintext"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Price</strong></label>
                            <p id="viewProductPrice" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Discount (%)</strong></label>
                            <p id="viewProductDiscount" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Sale Price</strong></label>
                            <p id="viewProductSalePrice" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Stock</strong></label>
                            <p id="viewProductStock" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('products.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="editProductId" name="product_id">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" id="editProductName" name="name" placeholder="Product Name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select id="editCategoryId" name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" id="editPrice" name="price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount (%)</label>
                            <input type="number" id="editDiscount" name="discount" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="number" id="editSalePrice" name="sale_price" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" id="editStock" name="stock" placeholder="Stock" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="editDescription" name="description" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editImage" class="form-label">Product Image (Optional)</label>
                            <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                            <small class="form-text text-muted d-block mt-2">Leave empty to keep current image</small>
                            @if($errors->has('image'))
                            <small class="text-danger d-block mt-2">{{ $errors->first('image') }}</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="editHoverProductImage" class="form-label">Hover Product Image (Optional)</label>
                            <input type="file" class="form-control" id="editHoverProductImage" name="hoverProductImage" accept="image/*">
                            <small class="form-text text-muted d-block mt-2">Leave empty to keep current Hover Product Image</small>
                            @if($errors->has('hoverProductImage'))
                            <small class="text-danger d-block mt-2">{{ $errors->first('hoverProductImage') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-warning">
                            Update Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteProductName"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteProductForm" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" id="deleteProductId" name="product_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Hover Image</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Discount</th>
                <th scope="col">Sale Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="productImage" class="productImage"
                        data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                </td>
                <td>
                    <img src="{{ asset('storage/' . $product->hoverProductImage) }}" alt="hoverProductImage" class="productImage"
                        data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                </td>
                <td>{{$product->name}}</td>
                <td>{{$product->slug}}</td>
                <td class="productDescription">{{$product->description}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->discount}}</td>
                <td>{{$product->sale_price}}</td>
                <td>{{$product->stock}}</td>
                <td>
                    <button type="button" class="btn rounded-0 btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#viewProductModal"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-slug="{{ $product->slug }}"
                        data-description="{{ $product->description }}"
                        data-price="{{ $product->price }}"
                        data-discount="{{ $product->discount }}"
                        data-sale-price="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock }}"
                        data-image="{{ asset('storage/' . $product->image) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                    <button type="button" class="btn rounded-0 btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-category="{{ $product->category_id }}"
                        data-price="{{ $product->price }}"
                        data-discount="{{ $product->discount }}"
                        data-sale-price="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock }}"
                        data-description="{{ $product->description }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                        </svg>
                    </button>
                    <button type="button" class="btn rounded-0 btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteProductModal"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                    </button>
                </td>
                @empty
                <div class="text-center">
                    <h3>No Product Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 ms-auto">
        <nav>
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </nav>
    </div>

</div>

@endsection

@push('scripts')
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(
            document.getElementById('addProductModal')
        );
        modal.show();
    });
</script>
@endif
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function calculateSalePrice(priceId = 'price', discountId = 'discount', salePriceId = 'sale_price') {
            let price = parseFloat(document.getElementById(priceId).value) || 0;
            let discount = parseFloat(document.getElementById(discountId).value) || 0;

            let discountAmount = (price * discount) / 100;
            let salePrice = price - discountAmount;

            document.getElementById(salePriceId).value = salePrice.toFixed(2);
        }

        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount');

        if (priceInput && discountInput) {
            priceInput.addEventListener('input', calculateSalePrice);
            discountInput.addEventListener('input', calculateSalePrice);
        }

        // Edit modal price calculations
        const editPriceInput = document.getElementById('editPrice');
        const editDiscountInput = document.getElementById('editDiscount');

        if (editPriceInput && editDiscountInput) {
            editPriceInput.addEventListener('input', function() {
                calculateSalePrice('editPrice', 'editDiscount', 'editSalePrice');
            });
            editDiscountInput.addEventListener('input', function() {
                calculateSalePrice('editPrice', 'editDiscount', 'editSalePrice');
            });
        }

        // View Product Button Handler
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const slug = this.getAttribute('data-slug');
                const description = this.getAttribute('data-description');
                const price = this.getAttribute('data-price');
                const discount = this.getAttribute('data-discount');
                const salePrice = this.getAttribute('data-sale-price');
                const stock = this.getAttribute('data-stock');
                const image = this.getAttribute('data-image');

                viewProduct(id, name, slug, description, price, discount, salePrice, stock, image);
            });
        });

        // Edit Product Button Handler
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const categoryId = this.getAttribute('data-category');
                const price = this.getAttribute('data-price');
                const discount = this.getAttribute('data-discount');
                const salePrice = this.getAttribute('data-sale-price');
                const stock = this.getAttribute('data-stock');
                const description = this.getAttribute('data-description');

                editProduct(id, name, categoryId, price, discount, salePrice, stock, description);
            });
        });

        // Delete Product Button Handler
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                deleteProduct(id, name);
            });
        });
    });

    function viewProduct(id, name, slug, description, price, discount, salePrice, stock, image) {
        document.getElementById('viewProductName').textContent = name;
        document.getElementById('viewProductSlug').textContent = slug;
        document.getElementById('viewProductDescription').textContent = description;
        document.getElementById('viewProductPrice').textContent = '₹' + price;
        document.getElementById('viewProductDiscount').textContent = discount + '%';
        document.getElementById('viewProductSalePrice').textContent = '₹' + salePrice;
        document.getElementById('viewProductStock').textContent = stock;
        document.getElementById('viewProductImage').src = image;
    }

    function editProduct(id, name, categoryId, price, discount, salePrice, stock, description) {
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editCategoryId').value = categoryId;
        document.getElementById('editPrice').value = price;
        document.getElementById('editDiscount').value = discount;
        document.getElementById('editSalePrice').value = salePrice;
        document.getElementById('editStock').value = stock;
        document.getElementById('editDescription').value = description;
    }

    function deleteProduct(id, name) {
        document.getElementById('deleteProductId').value = id;
        document.getElementById('deleteProductName').textContent = name;
        document.getElementById('deleteProductForm').action = "{{ route('products.delete') }}";
    }

    // Calculate sale price for Add Product Modal
    document.getElementById('price')?.addEventListener('input', calculateAddSalePrice);
    document.getElementById('discount')?.addEventListener('input', calculateAddSalePrice);

    function calculateAddSalePrice() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const discountValue = (price * discount) / 100;
        const salePrice = price - discountValue;
        document.getElementById('sale_price').value = salePrice.toFixed(2);
    }

    document.getElementById('editPrice')?.addEventListener('input', calculateEditSalePrice);
    document.getElementById('editDiscount')?.addEventListener('input', calculateEditSalePrice);

    function calculateEditSalePrice() {
        const price = parseFloat(document.getElementById('editPrice').value) || 0;
        const discount = parseFloat(document.getElementById('editDiscount').value) || 0;
        const discountValue = (price * discount) / 100;
        const salePrice = price - discountValue;
        document.getElementById('editSalePrice').value = salePrice.toFixed(2);
    }
</script>
@endpush