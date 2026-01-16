@extends('layouts.admin.main')

@section('title', 'Products')

@push('styles')
<style>
    .addProductBtn {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }
    .productImage{
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }

    .productDescription {
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
        <h3><b>Products</b></h3>
        <button type="button" class="btn btn-outline-dark rounded-0 addProductBtn" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>
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

                        <button type="submit" class="btn btn-success">
                            Save Product
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
                <th scope="col">Price</th>
                <th scope="col">Discount</th>
                <th scope="col">Sale Price</th>
                <th scope="col">Stock</th>
            </tr>
        </thead>
        <tbody>

            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Section_3_Image" class="productImage"
                        data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                </td>
                <td>{{$product->name}}</td>
                <td>{{$product->slug}}</td>
                <td class="productDescription">{{$product->description}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->discount}}</td>
                <td>{{$product->sale_price}}</td>
                <td>{{$product->stock}}</td>
                @empty
                <div class="text-center">
                    <h3>No Product Found.</h3>
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

        function calculateSalePrice() {
            let price = parseFloat(document.getElementById('price').value) || 0;
            let discount = parseFloat(document.getElementById('discount').value) || 0;

            let discountAmount = (price * discount) / 100;
            let salePrice = price + discountAmount;

            document.getElementById('sale_price').value = salePrice.toFixed(2);
        }

        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount');

        if (priceInput && discountInput) {
            priceInput.addEventListener('input', calculateSalePrice);
            discountInput.addEventListener('input', calculateSalePrice);
        }
    });
</script>
@endpush