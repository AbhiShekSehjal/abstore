@extends('layouts.admin.main')

@section('title', 'Settings')

@push('styles')
<style>
    .sliderImage {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid transparent;
        transition: 0.5s all ease;
        cursor: pointer;
    }

    .sliderImage:hover {
        border: 2px solid grey;
    }
</style>
@endpush

@section('content')

<div class="container py-4">


    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content bg-transparent border-0">
                <button type="button" class="btn-close mb-3 ms-auto" data-bs-dismiss="modal"></button>
                <img id="popupImage" class="img-fluid shadow">
            </div>
        </div>
    </div>


    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{route('settings.update')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <h3><b>Slider Settings</b></h3>

        <div class="mb-3">
            <label for="sliderImage1" class="form-label">Slider Image 1</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . $settings->slider_image_1) }}" alt="slider_image_1" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="sliderImage1" name="slider_image_1" accept="image/*">
                @if($errors->has('slider_image_1'))
                <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_1') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="sliderImage2" class="form-label">Slider Image 2</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . $settings->slider_image_2) }}" alt="slider_image_2" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="sliderImage2" name="slider_image_2" accept="image/*">
                @if($errors->has('slider_image_2'))
                <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_2') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="sliderImage3" class="form-label">Slider Image 3</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . $settings->slider_image_3) }}" alt="slider_image_3" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="sliderImage3" name="slider_image_3" accept="image/*">
                @if($errors->has('slider_image_3'))
                <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_3') }}</small>
                @endif
            </div>
        </div>

        <br>

        <h3><b>General Settings</b></h3>

        <div class="mb-3">
            <label for="mainHeading" class="form-label">Main Heading</label>
            <input type="text" class="form-control" id="mainHeading" name="main_heading" value="@if($settings->main_heading){{$settings->main_heading}}@endif">
            @if($errors->has('main_heading'))
            <small class="text-danger d-block mt-2">{{ $errors->first('main_heading') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="mainPera" class="form-label">Main Peragraph</label>
            <input type="text" class="form-control" id="mainPera" name="main_pera" value="@if($settings->main_pera){{$settings->main_pera}}@endif">
            @if($errors->has('main_pera'))
            <small class="text-danger d-block mt-2">{{ $errors->first('main_pera') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="logo" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                @if($errors->has('logo'))
                <small class="text-danger d-block mt-2">{{ $errors->first('logo') }}</small>
                @endif
            </div>
        </div>

        <br>

        <h3><b>Section 3 Settings</b></h3>
        <div class="mb-3">
            <label for="Section3Image" class="form-label">Section 3 Image</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . $settings->Section_3_Image) }}" alt="Section_3_Image" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="Section3Image" name="Section_3_Image" accept="image/*">
                @if($errors->has('Section_3_Image'))
                <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Image') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="Section3Text" class="form-label">Section 3 Text</label>
            <input type="text" class="form-control" id="Section3Text" name="Section_3_Text" value="@if($settings->Section_3_Text){{$settings->Section_3_Text}}@endif">
            @if($errors->has('Section_3_Text'))
            <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Text') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="Section3Text2" class="form-label">Section 3 Text</label>
            <input type="text" class="form-control" id="Section3Text2" name="Section_3_Text2" value="@if($settings->Section_3_Text){{$settings->Section_3_Text2}}@endif">
            @if($errors->has('Section_3_Text2'))
            <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Text2') }}</small>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function showImage(src) {
        document.getElementById('popupImage').src = src;
    }
</script>
@endpush