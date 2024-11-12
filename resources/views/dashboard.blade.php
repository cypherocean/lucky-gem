@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('styles')
@endsection

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-8">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-md-6 order-2 order-md-1">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Congratulations <span class="fw-bold">John!</span> 🎉</h4>
                                <p class="mb-0">You have done 68% 😎 more sales today.</p>
                                <p>Check your new badge in your profile.</p>
                                <a href="javascript:;" class="btn btn-primary">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Gamification Card -->

        </div>
    </div>
    <!-- / Content -->



    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

@endsection