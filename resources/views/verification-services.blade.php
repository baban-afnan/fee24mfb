<x-app-layout>
<x-slot name="title">Verification - services</x-slot>


<!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row icon-main">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <h3 class="m-b-0 f-w-700">Our Verification Services</h3>
                  </div>
                  <div class="card-body">
                    <div class="row icon-lists"> 
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('nin.verification.index') }}">
                          <img src="../assets/images/apps/nimc1.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Verify NIN</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('validation') }}">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Verify BVN</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('ipe') }}">
                          <img src="../assets/images/apps/nimc1.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Verify Phone No</h5>
                        </a>
                      </div>
                       <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('ipe') }}">
                          <img src="../assets/images/apps/agent.jpg" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Verify Account</h5>
                        </a>
                      </div>
                </div>
               </div>
            </div>


</x-app-layout>