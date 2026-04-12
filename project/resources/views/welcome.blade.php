@extends('layouts.main')

@section('content')
<div id="carouselExampleIndicators" class="carousel slide carousel-custom" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <picture>
                <source srcset="/assets/images/hero-bg.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">
                <h5>Lorem ipsum</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
        </div>

        <div class="carousel-item">
            <picture>
                <source srcset="/assets/images/hero-bg.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">
                <h5>Lorem ipsum</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
        </div>

        <div class="carousel-item">
            <picture>
                <source srcset="/assets/images/doctor.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">
                <h5>Lorem ipsum</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container">
    <h5>Artikel Kesehatan Terkini untuk Anda</h5>
</div>