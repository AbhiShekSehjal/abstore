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

    /* Responsive Media Queries */
    @media (max-width: 991px) {
        .container.py-4 {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        h1 {
            font-size: 1.5rem;
        }

        h3 {
            font-size: 1.25rem;
        }

        .form-control,
        .form-label {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .form-label {
            padding: 0;
            margin-bottom: 0.35rem;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem !important;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 input {
            width: 100%;
        }

        .sliderImage {
            width: 40px;
            height: 40px;
        }

        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .row {
            margin-left: -0.375rem;
            margin-right: -0.375rem;
        }

        .row > [class*='col-'] {
            padding-left: 0.375rem;
            padding-right: 0.375rem;
        }

        .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .alert {
            font-size: 0.875rem;
            padding: 0.75rem;
        }

        .alert ul {
            margin-bottom: 0;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        small {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 767px) {
        .container.py-4 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        h1 {
            font-size: 1.25rem;
        }

        h3 {
            font-size: 1rem;
        }

        .form-control,
        .form-label {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .form-label {
            padding: 0;
            margin-bottom: 0.25rem;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.75rem !important;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 input {
            width: 100%;
        }

        .sliderImage {
            width: 35px;
            height: 35px;
        }

        .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .row {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
        }

        .row > [class*='col-'] {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }

        .col-lg-4,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-sm-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .alert {
            font-size: 0.8rem;
            padding: 0.5rem;
        }

        .alert ul {
            margin-bottom: 0;
        }

        .alert li {
            margin-bottom: 0.15rem;
            font-size: 0.75rem;
        }

        small {
            font-size: 0.7rem;
        }

        br {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .container.py-4 {
            padding: 0.5rem !important;
        }

        h1 {
            font-size: 1.1rem;
        }

        h3 {
            font-size: 0.9rem;
        }

        .form-control,
        .form-label {
            font-size: 0.75rem;
            padding: 0.35rem 0.5rem;
        }

        .form-label {
            padding: 0;
            margin-bottom: 0.2rem;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem !important;
        }

        .d-flex.align-items-center.justify-content-center.gap-3 input {
            width: 100%;
        }

        .sliderImage {
            width: 30px;
            height: 30px;
        }

        .btn {
            font-size: 0.75rem;
            padding: 0.35rem 0.5rem;
        }

        .row {
            margin-left: -0.125rem;
            margin-right: -0.125rem;
        }

        .row > [class*='col-'] {
            padding-left: 0.125rem;
            padding-right: 0.125rem;
        }

        .col-lg-4,
        .col-md-4,
        .col-sm-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .mb-3 {
            margin-bottom: 0.5rem !important;
        }

        .mb-4 {
            margin-bottom: 0.75rem !important;
        }

        .alert {
            font-size: 0.75rem;
            padding: 0.4rem;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 1rem;
        }

        .alert li {
            margin-bottom: 0.1rem;
            font-size: 0.7rem;
        }

        small {
            font-size: 0.65rem;
        }

        br {
            display: none;
        }
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

        <h1 class="mb-4">Slider Settings</h1>

        <div class="mb-3">
            <label for="sliderImage1" class="form-label">Slider Image 1</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . ($settings->slider_image_1 ?? '')) }}" alt="slider_image_1" class="sliderImage"
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
                <img src="{{ asset('storage/' . ($settings->slider_image_2 ?? '')) }}" alt="slider_image_2" class="sliderImage"
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
                <img src="{{ asset('storage/' . ($settings->slider_image_3 ?? '')) }}" alt="slider_image_3" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="sliderImage3" name="slider_image_3" accept="image/*">
                @if($errors->has('slider_image_3'))
                <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_3') }}</small>
                @endif
            </div>
        </div>

        <br>

        <h3 class="mb-4">General Settings</h3>

        <div class="mb-3">
            <label for="mainHeading" class="form-label">Main Heading</label>
            <input type="text" class="form-control" id="mainHeading" name="main_heading" value="{{ $settings->main_heading ?? '' }}">
            @if($errors->has('main_heading'))
            <small class="text-danger d-block mt-2">{{ $errors->first('main_heading') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="mainPera" class="form-label">Main Peragraph</label>
            <input type="text" class="form-control" id="mainPera" name="main_pera" value="{{ $settings->main_pera ?? '' }}">
            @if($errors->has('main_pera'))
            <small class="text-danger d-block mt-2">{{ $errors->first('main_pera') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . ($settings->logo ?? '')) }}" alt="logo" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                @if($errors->has('logo'))
                <small class="text-danger d-block mt-2">{{ $errors->first('logo') }}</small>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-12 col-lg-4 col-md-4 col-sm-12">
                <label for="intsaLink" class="form-label">Instagram Link</label>
                <input type="text" class="form-control" id="intsaLink" name="intsaLink" value="{{ $settings->intsaLink ?? '' }}">
                @if($errors->has('intsaLink'))
                <small class="text-danger d-block mt-2">{{ $errors->first('intsaLink') }}</small>
                @endif
            </div>
            <div class="mb-3 col-12 col-lg-4 col-md-4 col-sm-12">
                <label for="fbLink" class="form-label">Facebook Link</label>
                <input type="text" class="form-control" id="fbLink" name="fbLink" value="{{ $settings->fbLink ?? '' }}">
                @if($errors->has('fbLink'))
                <small class="text-danger d-block mt-2">{{ $errors->first('fbLink') }}</small>
                @endif
            </div>
            <div class="mb-3 col-12 col-lg-4 col-md-4 col-sm-12">
                <label for="twitterLink" class="form-label">Twitter Link</label>
                <input type="text" class="form-control" id="twitterLink" name="twitterLink" value="{{ $settings->twitterLink ?? '' }}">
                @if($errors->has('twitterLink'))
                <small class="text-danger d-block mt-2">{{ $errors->first('twitterLink') }}</small>
                @endif
            </div>
        </div>

        <br>

        <h3 class="mb-4">Section 3 Settings</h3>
        <div class="mb-3">
            <label for="Section3Image" class="form-label">Section 3 Image</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . ($settings->Section_3_Image ?? '')) }}" alt="Section_3_Image" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="Section3Image" name="Section_3_Image" accept="image/*">
                @if($errors->has('Section_3_Image'))
                <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Image') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="Section3Text" class="form-label">Section 3 Text</label>
            <input type="text" class="form-control" id="Section3Text" name="Section_3_Text" value="{{ $settings->Section_3_Text ?? '' }}">
            @if($errors->has('Section_3_Text'))
            <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Text') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="Section3Text2" class="form-label">Section 3 Text</label>
            <input type="text" class="form-control" id="Section3Text2" name="Section_3_Text2" value="{{ $settings->Section_3_Text2 ?? '' }}">
            @if($errors->has('Section_3_Text2'))
            <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Text2') }}</small>
            @endif
        </div>

        <br>

        <!-- <h3 class="mb-4">Payment Settings</h3>
        <div class="mb-3">
            <label for="ORcode" class="form-label">OR Code</label>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <img src="{{ asset('storage/' . ($settings->ORcode ?? '')) }}" alt="ORcode" class="sliderImage"
                    data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)">
                <input type="file" class="form-control" id="ORcode" name="ORcode" accept="image/*">
                @if($errors->has('ORcode'))
                <small class="text-danger d-block mt-2">{{ $errors->first('ORcode') }}</small>
                @endif
            </div>
        </div> -->

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
