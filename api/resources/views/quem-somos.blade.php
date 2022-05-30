@extends('template.layout')

@section('content')

<div class="custom-page-section">
    <div class="container">
        <div class="row">
            <!-- contact info -->
            <div class="col-lg-8">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>

@endsection