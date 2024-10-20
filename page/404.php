
     <style>
        body {
            height: 100vh; /* Full height of the viewport */
            display: flex;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            margin: 0; /* Remove default margin */
            background-color: #f8f9fa; /* Light background color */
        }
        .img-error {
            max-width: 100%; /* Responsive image */
            height: auto; /* Maintain aspect ratio */
            max-height: 60vh; /* Limit the height for large screens */
        }
        .lead {
            font-size: 1.5rem; /* Increase font size for visibility */
            margin-top: 20px; /* Space above the text */
        }
    </style>
    <div class="container-fluid d-flex flex-column align-items-center justify-content-center text-center" style="height: 100vh;">
        <img class="mb-4 img-error" src="assets/img/404.jpg" alt="404 Not Found" />
        <p class="lead">This requested URL was not found on this server.</p>
        <a href="index.php" class="btn btn-success btn-lg">
            <i class="fas fa-arrow-left me-1"></i>
            Return to Dashboard
        </a>
    </div>
