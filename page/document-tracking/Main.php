<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Document Tracking System</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                <i class="bi bi-upload"></i> Upload New Document
            </button>
        </div>

        <!-- Filter Section -->
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchBar" placeholder="Search by name, ID, or tags">
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterStatus">
                        <option value="">All Statuses</option>
                        <option value="Pending Review">Pending Review</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterPriority">
                        <option value="">All Priorities</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>

            <!-- Document Table -->
            <div class="table-responsive mt-3">
                <table id="documentTable" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Document Name</th>
                            <th>Department</th>
                            <th>Date Received</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $documents = $DB->SELECT("document_tracking", "*", "ORDER BY document_id DESC");
                        $i = 1;
                        foreach ($documents as $doc) {
                            $statusClass = $doc['status'] === 'Approved' ? 'bg-success text-light' : ($doc['status'] === 'Rejected' ? 'bg-danger text-light' : 'bg-warning text-dark');
                            $priorityClass = $doc['priority'] === 'High' ? 'bg-danger text-light' : ($doc['priority'] === 'Medium' ? 'bg-warning text-dark' : 'bg-secondary text-light');
                            echo "<tr>
                                <td>{$i}</td>
                                <td>" . htmlspecialchars($doc['document_name']) . "</td>
                                <td>" . htmlspecialchars($doc['department']) . "</td>
                                <td>" . htmlspecialchars($doc['date_received']) . "</td>
                                <td>" . htmlspecialchars($doc['last_modified']) . "</td>
                                <td><span class='badge {$statusClass}'>" . htmlspecialchars($doc['status']) . "</span></td>
                                <td><span class='badge {$priorityClass}'>" . htmlspecialchars($doc['priority']) . "</span></td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <button class='btn btn-sm btn-light viewDocument' data-id='" . htmlspecialchars($doc['document_id']) . "'><i class='bi bi-eye'></i></button>
                                        <button class='btn btn-sm btn-success approveDocument' data-id='" . htmlspecialchars($doc['document_id']) . "'><i class='bi bi-check-circle'></i></button>
                                        <button class='btn btn-sm btn-danger rejectDocument' data-id='" . htmlspecialchars($doc['document_id']) . "'><i class='bi bi-x-circle'></i></button>
                                        <button class='btn btn-sm btn-light downloadDocument' data-id='" . htmlspecialchars($doc['document_id']) . "'><i class='bi bi-download'></i></button>
                                        <button class='btn btn-sm btn-light deleteDocument' data-id='" . htmlspecialchars($doc['document_id']) . "'><i class='bi bi-trash'></i></button>
                                    </div>
                                </td>
                            </tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light text-success">
                <h5 class="modal-title" id="uploadDocumentModalLabel">Upload Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/api/document-tracking/process_upload.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Document Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="document_name" name="document_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Document Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority Level <span class="text-danger">*</span></label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks/Notes</label>
                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags">
                    </div>
                    <div class="mb-3">
                        <label for="file_attachment" class="form-label">File Attachment <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file_attachment" name="file_attachment" accept=".pdf,.docx,.jpg" required>
                        <small class="text-muted">Allowed formats: PDF, DOCX, JPG (Max size: 10 MB)</small>
                    </div>
                    <button type="submit" class="btn btn-success">Upload Document</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Document View Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header bg-light text-success">
                <h5 class="modal-title" id="documentModalTitle">Document Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="documentModalBody">
                <!-- Document details will be dynamically injected here by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript for handling modals and AJAX requests -->
<script>
    $(document).ready(function() {
        function fetchDocuments() {
            const searchTerm = $('#searchBar').val();
            const status = $('#filterStatus').val();
            const priority = $('#filterPriority').val();

            $.post('/api/document-tracking/search_document.php', {
                search: searchTerm,
                status: status,
                priority: priority
            }, function(data) {
                if (data.error) {
                    // Handle error response
                    alert("Error: " + data.error);
                    return;
                }

                let documentRows = '';
                data.forEach((doc, index) => {
                    const statusClass = doc.status === 'Approved' ? 'bg-success text-light' :
                        (doc.status === 'Rejected' ? 'bg-danger text-light' : 'bg-warning text-dark');
                    const priorityClass = doc.priority === 'High' ? 'bg-danger text-light' :
                        (doc.priority === 'Medium' ? 'bg-warning text-dark' : 'bg-secondary text-light');

                    documentRows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${doc.document_name}</td>
                    <td>${doc.department}</td>
                    <td>${doc.date_received}</td>
                    <td>${doc.last_modified}</td>
                    <td><span class="badge ${statusClass}">${doc.status}</span></td>
                    <td><span class="badge ${priorityClass}">${doc.priority}</span></td>
                    <td>
                        <button class="btn btn-sm btn-light viewDocument" data-id="${doc.document_id}"><i class='bi bi-eye'></i></button>
                        <button class="btn btn-sm btn-success approveDocument" data-id="${doc.document_id}"><i class='bi bi-check-circle'></i></button>
                        <button class="btn btn-sm btn-danger rejectDocument" data-id="${doc.document_id}"><i class='bi bi-x-circle'></i></button>
                        <button class="btn btn-sm btn-light downloadDocument" data-id="${doc.document_id}"><i class='bi bi-download'></i></button>
                        <button class="btn btn-sm btn-warning deleteDocument" data-id="${doc.document_id}"><i class='bi bi-trash'></i></button>
                    </td>
                </tr>`;
                });
                $('#documentTable tbody').html(documentRows);
            }, 'json').fail(function() {
                alert("Failed to fetch documents. Please try again.");
            });
        }

        $('#searchBar, #filterStatus, #filterPriority').on('input change', fetchDocuments);
        fetchDocuments();

        $(document).on('click', '.viewDocument', function() {
            const docId = $(this).data('id');
            $.post('/api/document-tracking/view_document.php', {
                document_id: docId
            }, function(document) {
                if (document.error) {
                    alert(document.error);
                    return;
                }
                $('#documentModalTitle').text(document.document_name);
                $('#documentModalBody').html(`
                    <p><strong>Category:</strong> ${document.category}</p>
                    <p><strong>Department:</strong> ${document.department}</p>
                    <p><strong>Status:</strong> ${document.status}</p>
                    <p><strong>Priority:</strong> ${document.priority}</p>
                    <p><strong>Remarks:</strong> ${document.remarks}</p>
                    <hr>
                    <a href="${document.file_url}" target="_blank" class="btn btn-success">Open Document</a>
                `);
                $('#documentModal').modal('show');
            }, 'json');
        });

        // Approve Document
        $(document).on('click', '.approveDocument', function() {
            const docId = $(this).data('id');
            $.post('/api/document-tracking/approve_document.php', {
                document_id: docId
            }, function(response) {
                $('#response').html(response);
                fetchDocuments();
            });
        });

        // Reject Document
        $(document).on('click', '.rejectDocument', function() {
            const docId = $(this).data('id');
            if (remarks) {
                $.post('/api/document-tracking/reject_document.php', {
                    document_id: docId,
                }, function(response) {
                    $('#response').html(response);
                    fetchDocuments();
                });
            }
        });

        // Download Document
        $(document).on('click', '.downloadDocument', function() {
            const docId = $(this).data('id');
            $.post('/api/document-tracking/view_document.php', {
                document_id: docId
            }, function(document) {
                if (document.error) {
                    alert(document.error);
                } else {
                    window.open(document.file_url, '_blank');
                }
            }, 'json');
        });

        $(document).on('click', '.deleteDocument', function() {
            const docId = $(this).data('id');

            Swal.fire({
                title: "Are you sure you want to delete this document?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                confirmButtonColor: '#198754' // Green color for confirmation button
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/api/document-tracking/delete_document.php', {
                        document_id: docId
                    }, function(response) {
                        if (response.status === "error") {
                            Swal.fire("Error", response.message, "error");
                        } else {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "Document deleted successfully!",
                                icon: "success",
                                confirmButtonColor: '#198754' // Green color for OK button
                            }).then(() => {
                                location.reload(); // Refresh the page after deletion
                            });
                        }
                    }, 'json').fail(function() {
                        Swal.fire("Error", "Failed to delete. Please try again.", "error");
                    });
                }
            });
        });
    });
</script>


<!-- Placeholder for response messages -->
<div id="response"></div>