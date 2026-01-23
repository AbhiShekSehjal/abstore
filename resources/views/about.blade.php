@extends('layouts.main')

@section('title', 'About')

@push('styles')
<style>
    .aboutUsContainer {
        margin-top: 100px;
    }

    .heroContainer {
        background: #000;
        padding: 0 62px;
    }

    .aboutUsHeading {
        font-size: 120px;
        font-weight: 600;
        position: relative;
        top: -72px;
        right: -45px;
        mix-blend-mode: difference;
        color: white;
        margin-bottom: 0;
    }

    .aboutUsText {
        color: white;
        position: relative;
        top: -60px;
    }

    .abstoreMockup {
        width: 100%;
        height: 60vh;
        object-fit: cover;
    }

    /* Responsive Styles for Medium Screens (576px - 768px) */
    @media (min-width: 576px) and (max-width: 768px) {
        .aboutUsContainer {
            margin-top: 60px;
        }

        .heroContainer {
            padding: 0 30px;
        }

        .aboutUsHeading {
            font-size: 60px;
            top: -40px;
            right: 0;
        }

        .aboutUsText {
            font-size: 14px;
            top: -30px;
        }

        .abstoreMockup {
            height: 40vh;
        }
    }

    /* Responsive Styles for Small Screens (less than 576px) */
    @media (max-width: 576px) {
        .aboutUsContainer {
            margin-top: 30px;
        }

        .heroContainer {
            padding: 0 15px;
        }

        .aboutUsHeading {
            font-size: 36px;
            top: -20px;
            right: 0;
        }

        .aboutUsText {
            font-size: 13px;
            top: -15px;
            padding: 15px !important;
        }

        .abstoreMockup {
            height: 35vh;
            margin-top: 20px;
        }
    }
</style>
@endpush

@section('content')

<div class="aboutUsContainer">
    <div class="heroContainer">
        <h1 class='aboutUsHeading'>OUR STORY</h1>
        <p class='aboutUsText p-5'>At Abstore, our journey started with a simple idea — to make online shopping easy,
            affordable, and enjoyable for everyone.
            We noticed that people were spending too much time searching for quality products at reasonable prices. So
            we built a place where you can find everything you need in one store — from fashion and electronics to home
            essentials and daily-use items.

            Every product on Abstore is handpicked with care. We focus on quality, trust, and a smooth shopping
            experience. Whether you are looking for the latest trends, budget-friendly deals, or reliable everyday
            items, we make sure you get the best value for your money.

            What began as a small idea is now growing into a complete online marketplace — created for the people, and
            built on honesty, customer satisfaction, and continuous improvement.
            We believe that shopping should be simple and fun, and that's exactly what we work for every day.

            Welcome to Abstore — your one-stop shop for everything you love.</p>
    </div>

    <img src="https://res.cloudinary.com/djmmx0tri/image/upload/v1764673213/Group_2_2_nk43vf.jpg" alt="" class='abstoreMockup mt-5'>
</div>

@endsection