@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="row pt-5">
                <!-- Retail Module Card -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('retail.index') }}" class="counter-link">
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-store"></i>
                            </div>                       
                            <h3>Retail Module</h3>
                        </div>
                    </a>
                </div>
                <!-- HSSEQ Module Card -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('hsseq.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-shield"></i>
                            </div>                       
                            <h3>HSSEQ Module</h3>
                        </div>
                    </a>
                </div>
                 <!-- Customer Feedback Module Card -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('feedback.dashboard') }}" class="counter-link">
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-comments"></i>
                            </div>                       
                            <h3>Customer Feedback</h3>
                        </div>
                    </a>
                </div>
                <!-- Feedback Module Card -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('suggestions.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-lightbulb"></i>
                            </div>                       
                            <h3>Staff Suggestions</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>       
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
 
@endsection
