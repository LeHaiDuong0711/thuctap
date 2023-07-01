<div id="sectionMyOrder">
    <div class="container mt-5 mb-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab-order" role="tablist">
                <button class="nav-link active" id="nav-all-order-tab" data-bs-toggle="tab" data-bs-target="#nav-all-order" type="button" role="tab" aria-controls="nav-all-order" aria-selected="true">Tất cả</button>
                <button class="nav-link" id="nav-processing-tab" data-bs-toggle="tab" data-bs-target="#nav-processing" type="button" role="tab" aria-controls="nav-processing" aria-selected="false">Đang xử lý</button>
                <button class="nav-link" id="nav-delivering-tab" data-bs-toggle="tab" data-bs-target="#nav-delivering" type="button" role="tab" aria-controls="nav-delivering" aria-selected="false">Đang giao</button>
                <button class="nav-link" id="nav-received-tab" data-bs-toggle="tab" data-bs-target="#nav-received" type="button" role="tab" aria-controls="nav-received" aria-selected="false">Đã nhận</button>
                <button class="nav-link" id="nav-cancel-order-tab" data-bs-toggle="tab" data-bs-target="#nav-cancel-order" type="button" role="tab" aria-controls="nav-cancel-order" aria-selected="false">Đã Hủy</button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tab-content-orders">
            <div class="tab-pane fade show active" id="nav-all-order" role="tabpanel" aria-labelledby="nav-all-order-tab">

            </div>
            <div class="tab-pane fade" id="nav-processing" role="tabpanel" aria-labelledby="nav-processing-tab"></div>
            <div class="tab-pane fade" id="nav-delivering" role="tabpanel" aria-labelledby="nav-delivering-tab"></div>
            <div class="tab-pane fade" id="nav-received" role="tabpanel" aria-labelledby="nav-received-tab"></div>
            <div class="tab-pane fade" id="nav-cancel-order" role="tabpanel" aria-labelledby="nav-cancel-order-tab"></div>
        </div>
    </div>
</div>
<script src="./Assets/js/jquery/jqueryListOrders.js"></script>