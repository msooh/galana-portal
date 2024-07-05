<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Customer Feedback Form</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet"/>

    <!-- Styles -->
 
    <!-- Scripts -->
    
</head>
<body>
    <div class="mx-0 col-lg-6 mx-sm-auto">
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center">
                <img class="sidebar-brand-full" width="150" height="auto" src="{{ asset('assets/img/Logos/horizontal_logo_logo_full_white.png') }}" alt="Galana Logo">
                <h5 class="card-title text-white mx-auto">Feedback request</h5>
            </div>            
          <div class="modal-body">
            <div class="text-center">
              <i class="far fa-file-alt fa-4x mb-3 text-primary"></i>
              <p>
                <strong>Your opinion matters</strong>
              </p>
              <p>
                Have some ideas how to improve our product?
                <strong>Give us your feedback.</strong>
              </p>
            </div>
      
            <hr />
      
            <form class="px-4" action="{{ route('feedback.store') }}" method="POST">
                @csrf
                <p class="text-center"><strong>Customer Information:</strong></p>
                <div class="row mb-4">
                    <div class="col">
                      <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form6Example1" class="form-control" name="first_name" />
                        <label class="form-label" for="form6Example1">First name</label>
                      </div>
                    </div>
                    <div class="col">
                      <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form6Example2" class="form-control" name="last_name" />
                        <label class="form-label" for="form6Example2">Last name</label>
                      </div>
                    </div>
                  </div>
                
                  <!-- Text input -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="form6Example3" class="form-control" name="company_name" />
                    <label class="form-label" for="form6Example3">Company name</label>
                  </div>              
                 
                  <!-- Email input -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form6Example5" class="form-control" name="email" />
                    <label class="form-label" for="form6Example5">Email</label>
                  </div>
                
                  <!-- Number input -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="number" id="form6Example6" class="form-control" name="phone" />
                    <label class="form-label" for="form6Example6">Phone</label>
                  </div>
              <p class="text-center"><strong>Service Details:</strong></p>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="date" id="form6Example5" class="form-control" name="service_date" />
                <label class="form-label" for="form6Example5">Date</label>
              </div>
              <div data-mdb-select-init class="form-outline mb-4">
                <select data-mdb-select-init data-mdb-placeholder="Example placeholder" class="form-select" name="product">
                    <option value="">Select Product</option>
                    <option value="AGO">AGO</option>
                    <option value="PMS">PMS</option>
                    <option value="Lubricants">Lubricants</option>
                    <option value="Other">Other</option>                    
                </select>                              
              </div>
              <p class="text-center"><strong>Your rating:</strong></p>
              <div class="table-responsive">
                <table class="table">
            
                <thead>
                    <tr>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Customer Service</td>
                        <td>                                                       
                            <div class="text-center">
                                <div class="d-inline mx-3">Bad</div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio1" value="1" />
                                  <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio2" value="2" />
                                  <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio3" value="3" />
                                  <label class="form-check-label" for="inlineRadio3">3</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio4" value="4" />
                                  <label class="form-check-label" for="inlineRadio4">4</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio5" value="5" />
                                  <label class="form-check-label" for="inlineRadio5">5</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="customer_service" id="inlineRadio6" value="6" />
                                  <label class="form-check-label" for="inlineRadio6">6</label>
                                </div>
                                <div class="d-inline me-4">Excellent</div>
                              </div>                                                    
                        </td>
                    </tr>
                    <tr>
                        <td>Quality of Products</td>
                        <td>                                                        
                            <div class="text-center mb-4">
                                <div class="d-inline mx-3">Bad</div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio1" value="1" />
                                  <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio2" value="2" />
                                  <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio3" value="3" />
                                  <label class="form-check-label" for="inlineRadio3">3</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio4" value="4" />
                                  <label class="form-check-label" for="inlineRadio4">4</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio5" value="5" />
                                  <label class="form-check-label" for="inlineRadio5">5</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="product_quality" id="inlineRadio6" value="6" />
                                  <label class="form-check-label" for="inlineRadio6">6</label>
                                </div>
                                <div class="d-inline me-4">Excellent</div>
                              </div>                                                 
                        </td>
                    </tr>
                    <tr>
                        <td>Timeliness</td>
                        <td>                                                        
                            <div class="text-center mb-4">
                                <div class="d-inline mx-3">Bad</div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio1" value="1" />
                                  <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio2" value="2" />
                                  <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio3" value="3" />
                                  <label class="form-check-label" for="inlineRadio3">3</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio4" value="4" />
                                  <label class="form-check-label" for="inlineRadio4">4</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio5" value="5" />
                                  <label class="form-check-label" for="inlineRadio5">5</label>
                                </div>
                            
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="timeliness" id="inlineRadio6" value="6" />
                                  <label class="form-check-label" for="inlineRadio6">6</label>
                                </div>
                                <div class="d-inline me-4">Excellent</div>
                              </div>                                                 
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            </div>

              <div class="text-center">
                <p><strong>Overall Rating</strong></p>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="overall_rating" id="radio3Example1" value="very_good" />
                <label class="form-check-label" for="radio3Example1">Very good</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="overall_rating" id="radio3Example2" value="good" />
                <label class="form-check-label" for="radio3Example2">Good</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="overall_rating" id="radio3Example3" value="mediocre" />
                <label class="form-check-label" for="radio3Example3">Mediocre</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="overall_rating" id="radio3Example4" value="bad" />
                <label class="form-check-label" for="radio3Example4">Bad</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="overall_rating" id="radio3Example5" value="very_bad" />
                <label class="form-check-label" for="radio3Example5">Very bad</label>
              </div>
    
                  
              <p class="text-center"><strong>What could we improve?</strong></p>
      
              <!-- Message input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <textarea class="form-control" id="form4Example3" rows="4" name="feedback"></textarea>
                <label class="form-label" for="form4Example3">Your feedback</label>
              </div>
              <div class="text-end">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Submit</button>
                </div>
              
            </form>
          </div>
          
        </div>
      </div>
      

    <!-- MDB Script-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
</body>
</html>
