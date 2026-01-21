@extends('layouts.main')

@section('title', 'Contact')

@push('styles')
<style>

</style>
@endpush

@section('content')

<div class="container py-4">

    <h1 class='text-center mb-2 mt-2'>Contact us </h1>
    <p class="mt-2 mb-4 text-center">Have questions or need more information? Fill out the contact form below and one of our team members will respond shortly. We aim to provide prompt and helpful support to all inquiries.</p>

    @if(session('success'))
    <div class=" alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; border-left: 4px solid #28a745;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">

        <div class="col-lg-6 p-0">
            <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="img-fluid">
        </div>
        <div class="col-lg-6 px-5 py-4 bg-primary text-white">

            <form action="{{ route('contact.submit') }}" method="POST" class="row">
                @csrf

                <div class="mb-2 mt-2 col-12 p-0">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control rounded-0" required>
                </div>

                <div class="mb-2 col-12 p-0">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-0" required>
                </div>

                <div class="mb-4 col-12 p-0">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="4" class="form-control rounded-0" required></textarea>
                </div>

                <button type="submit" class="btn btn-light rounded-0 p-2">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <!-- <div class="row">

        <div class="col-lg-6 p-0 bg-success">

        </div>
        <div class="col-lg-6 p-0">
            <img src="https://images.unsplash.com/photo-1768696082704-c4e5593d9f27?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="img-fluid">
        </div>
    </div> -->
</div>
@endsection