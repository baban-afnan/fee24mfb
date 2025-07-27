<x-app-layout>

 </div>
<!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row icon-main">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <h3 class="m-b-0 f-w-700">Our BVN </h3>
                  </div>
                  <div class="card-body">
                    <div class="row icon-lists"> 
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('bvn-crm') }}">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">CRM</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('bvn.index') }}" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">BVN user</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                       <a href="{{ route('send-vnin.index') }}">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">VNIN TO NIBSS</h5>
                        </a>
                      </div>
                    <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('modification') }}">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Modification</h5>
                        </a>
                      </div>
                        <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                         <a href="{{ route('phone.search.index') }}">
                         <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                        <h5 class="mt-0">Get BVN Link P/N</h5>
                        </a>
                    </div>
                </div>
               </div>
            </div>

</x-app-layout>