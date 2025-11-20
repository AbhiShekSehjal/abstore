@extends('layouts.main')

@section('title', 'Products')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Description</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Sale Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>
                {{ $product->name }}
            </td>
            <td>
                {{ $product->slug }}
            </td>
            <td>
                {{ $product->description }}
            </td>
            <td>
                {{ $product->category->name }}
            </td>
            <td>
                {{ $product->price }}
            </td>
            <td>
                {{ $product->sale_price }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection