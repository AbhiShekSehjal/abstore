@extends('layouts.admin.main')

@section('title', 'Settings')

<!-- @push('styles')

@endpush -->

@section('content')

<div class="container py-4 rounded-5">

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
            <input type="file" class="form-control" id="sliderImage1" name="slider_image_1" accept="image/*">
            @if($errors->has('slider_image_1'))
            <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_1') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="sliderImage2" class="form-label">Slider Image 2</label>
            <input type="file" class="form-control" id="sliderImage2" name="slider_image_2" accept="image/*">
            @if($errors->has('slider_image_2'))
            <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_2') }}</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="sliderImage3" class="form-label">Slider Image 3</label>
            <input type="file" class="form-control" id="sliderImage3" name="slider_image_3" accept="image/*">
            @if($errors->has('slider_image_3'))
            <small class="text-danger d-block mt-2">{{ $errors->first('slider_image_3') }}</small>
            @endif
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
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            @if($errors->has('logo'))
            <small class="text-danger d-block mt-2">{{ $errors->first('logo') }}</small>
            @endif
        </div>

        <br>

        <h3><b>Section 3 Settings</b></h3>
        <div class="mb-3">
            <label for="Section3Image" class="form-label">Section 3 Image</label>
            <input type="file" class="form-control" id="Section3Image" name="Section_3_Image" accept="image/*">
            @if($errors->has('Section_3_Image'))
            <small class="text-danger d-block mt-2">{{ $errors->first('Section_3_Image') }}</small>
            @endif
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