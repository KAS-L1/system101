<!-- RFQ and Supplier Selection UI -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Create RFQ</h6>
                    <p class="card-text text-muted small">Create a request for quote for specific items.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRFQModal">Create RFQ</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">View RFQs</h6>
                    <p class="card-text text-muted small">View all sent RFQs and track responses from suppliers.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewRFQsModal">View RFQs</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Submit RFQ Response</h6>
                    <p class="card-text text-muted small">Submit a quote response to an RFQ.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#submitRFQResponseModal">Submit RFQ Response</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Evaluate RFQ</h6>
                    <p class="card-text text-muted small">Evaluate and compare quotes from suppliers.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#evaluateRFQModal">Evaluate RFQ</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Create RFQ -->
<div class="modal fade" id="createRFQModal" tabindex="-1" aria-labelledby="createRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRFQModalLabel">Create RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create RFQ Form -->
                <form action="create-rfq.php" method="post">
                    <div class="mb-3">
                        <label for="itemDescription" class="form-label">Item Description:</label>
                        <input type="text" id="itemDescription" name="itemDescription" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierID" class="form-label">Supplier:</label>
                        <select id="supplierID" name="supplierID" class="form-select" required>
                            <option value="">Select Supplier</option>
                            <option value="Supplier 1">Supplier 1</option>
                            <option value="Supplier 2">Supplier 2</option>
                            <option value="Supplier 3">Supplier 3</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create RFQ</button>
                </form>
            </div>
        </div>
    </div>
 </div>

<!-- Modal 2: View RFQs -->
<div class="modal fade" id="viewRFQsModal" tabindex="-1" aria-labelledby="viewRFQsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRFQsModalLabel">View RFQs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- View RFQs Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">RFQ ID</th>
                            <th scope="col">Item Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RFQ-001</td>
                            <td>Item 1</td>
                            <td>10</td>
                            <td>Supplier 1</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>RFQ-002</td>
                            <td>Item 2</td>
                            <td>20</td>
                            <td>Supplier 2</td>
                            <td>Approved</td>
                        </tr>
                        <tr>
                            <td>RFQ-003</td>
                            <td>Item 3</td>
                            <td>30</td>
                            <td>Supplier 3</td>
                            <td>Rejected</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Submit RFQ Response -->
<div class="modal fade" id="submitRFQResponseModal" tabindex="-1" aria-labelledby="submitRFQResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitRFQResponseModalLabel">Submit RFQ Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Submit RFQ Response Form -->
                <form action="submit-rfq-response.php" method="post">
                    <div class="mb-3">
                        <label for="rfqID" class="form-label">RFQ ID:</label>
                        <input type="text" id="rfqID" name="rfqID" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="quote" class="form-label">Quote:</label>
                        <input type="number" id="quote" name="quote" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit RFQ Response</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Evaluate RFQ -->
<div class="modal fade" id="evaluateRFQModal" tabindex="-1" aria-labelledby="evaluateRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluateRFQModalLabel">Evaluate RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Evaluate RFQ Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">RFQ ID</th>
                            <th scope="col">Item Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Quote</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RFQ-001</td>
                            <td>Item 1</td>
                            <td>10</td>
                            <td>Supplier 1</td>
                            <td>1000</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>RFQ-002</td>
                            <td>Item 2</td>
                            <td>20</td>
                            <td>Supplier 2</td>
                            <td>2000</td>
                            <td>Approved</td>
                        </tr>
                        <tr>
                            <td>RFQ-003</td>
                            <td>Item 3</td>
                            <td>30</td>
                            <td>Supplier 3</td>
                            <td>3000</td>
                            <td>Rejected</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>