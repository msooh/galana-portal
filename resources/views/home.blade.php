@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="text-center">                          
        <img class="" width="300" height="auto" src="{{ asset('assets/img/New logo-01.png') }}" alt="Galana Logo">   
        <h2 class="mb-2">Welcome to Your Portal Dashboard</h2>   
        <p>Explore your authorized modules by clicking on the cards below. Each card navigates to a specific dashboard.</p>          
    </div>
    <div class="row">
        <div class="container">
            <div class="d-flex flex-wrap pt-5 justify-content-start">
                <!-- Retail Module Card -->               
                @can('Retail Module')
                <div class="module-card">
                    <a href="{{ route('retail.index') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-store"></i>
                            </div>                       
                            <h3>Retail Module</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!-- Finance Module Card -->
                @can('Finance Module')
                <div class="module-card">
                    <a href="{{ route('suggestions.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-file-invoice-dollar"></i>                                
                            </div>                       
                            <h3>Finance Module</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!-- Maintenance Module Card -->
                @can('Maintenance Module')
                <div class="module-card">
                    <a href="#" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fas fa-wrench"></i>                              
                            </div>                       
                            <h3>Maintenance Module</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!-- HSSEQ Module Card -->
                @can('HSSEQ Module')
                <div class="module-card">
                    <a href="{{ route('hsseq.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-shield"></i>
                            </div>                       
                            <h3>HSSEQ Module</h3>
                        </div>
                    </a>
                </div>
                @endcan
                
                <!--Land and leases Registry -->
                @can('Finance Module')
                <div class="module-card">
                    <a href="{{ route('hsseq.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-map-marked-alt"></i>
                            </div>                       
                            <h3>Land and Leases</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!--Legal Module -->
                @can('Finance Module')
                <div class="module-card">
                    <a href="{{ route('hsseq.dashboard') }}" class="counter-link">
                        <div class="counter blue">                       
                            <div class="counter-icon"> 
                                <i class="fa fa-gavel"></i>                                  
                            </div>                       
                            <h3>Legal Module</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!-- Customer Feedback Module Card -->
                @can('Feedback Module')
                <div class="module-card">
                    <a href="{{ route('feedback.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-comments"></i>
                            </div>                       
                            <h3>Customer Feedback</h3>
                        </div>
                    </a>
                </div>
                @endcan
                <!-- Staff Suggestions Module Card -->
                @can('Suggestions Module')
                <div class="module-card">
                    <a href="{{ route('suggestions.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">                                
                                <i class="fa fa-lightbulb"></i>
                            </div>             
                            <h3>Staff Suggestions</h3>
                        </div>
                    </a>
                </div>
                @endcan  
                <!-- Galana Foundation Module Card -->
                @can('Suggestions Module')
                <div class="module-card">
                    <a href="{{ route('foundation.dashboard') }}" class="counter-link">
                        <div class="counter blue">
                            <div class="counter-icon">
                                <i class="fa fa-users"></i>
                            </div>                       
                            <h3>Galana Foundation</h3>
                        </div>
                    </a>
                </div>
                @endcan                
            </div>
        </div>      
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
 
@endsection
