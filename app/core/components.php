<?php

/**
 * FUNCTIONAL COMPONENTS
 **/

/**
 * Refreshes the current URL.
 * 
 * This function uses JavaScript to reload the current page.
 * The die() function is used to stop the execution of the script after reloading the page.
 */
function refreshUrl()
{
?>
    <script>
        location.reload();
    </script>
<?php
    die();
}

/**
 * Refreshes the current URL after a specified timeout.
 * 
 * This function uses JavaScript to reload the current page after a specified number of seconds.
 * The die() function is used to stop the execution of the script after reloading the page.
 * 
 * @param int $second The number of seconds to wait before reloading the page.
 */
function refreshUrlTimeout($second)
{
?>
    <script>
        setTimeout(function() {
            location.reload()
        }, <?= $second ?>);
    </script>
<?php
}

/**
 * Redirects to a specified URL.
 * 
 * This function uses JavaScript to redirect the user to a specified URL.
 * The die() function is used to stop the execution of the script after redirecting.
 * 
 * @param string $url The URL to redirect to.
 */
function redirectUrl($url)
{
?>
    <script>
        window.location.href = "<?= $url ?>"
    </script>
<?php
}

/**
 * Redirects to a specified URL after a specified timeout.
 * 
 * This function uses JavaScript to redirect the user to a specified URL after a specified number of seconds.
 * The die() function is used to stop the execution of the script after redirecting.
 * 
 * @param string $url The URL to redirect to.
 * @param int $second The number of seconds to wait before redirecting.
 */
function redirectUrlTimeout($url, $second)
{
?>
    <script>
        setTimeout(function() {
            location.href = '<?= $url ?>';
        }, '<?= $second ?>');
    </script>
<?php
    die();
}

/**
 * Displays an alert message.
 * 
 * This function displays an alert message with a specified type and message.
 * The type can be used to style the alert message (e.g., success, error, warning).
 * 
 * @param string $type The type of alert message (e.g., success, error, warning).
 * @param string $message The message to display in the alert.
 */
function alert($type, $message)
{
?>
    <div class="alert alert-<?= $type ?> fw-bold py-2"><?= $message ?></div>
<?php
}

/**
 * Displays a toast notification using Toastr.
 * 
 * This function displays a toast notification with a specified status, header, and message.
 * The status can be used to style the toast notification (e.g., success, error, warning).
 * 
 * @param string $status The status of the toast notification (e.g., success, error, warning).
 * @param string $header The header of the toast notification.
 * @param string $message The message to display in the toast notification.
 */
function toastHead($status, $header, $message)
{
?>
    <script>
        toastr.<?= $status ?>('<?= $message ?>', '<?= $header ?>');
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false
        }
    </script>
<?php
}

/**
 * Displays a toast notification using SweetAlert.
 * 
 * This function displays a toast notification with a specified type and message.
 * The type can be used to style the toast notification (e.g., success, error, warning).
 * 
 * @param string $type The type of toast notification (e.g., success, error, warning).
 * @param string $message The message to display in the toast notification.
 */
function swalToast($type, $message)
{
?>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                showClass: {
                    backdrop: 'swal2-noanimation',
                    popup: '',
                },
            });
            Toast.fire({
                icon: '<?= $type ?>',
                title: '<?= $message ?>'
            });
        });
    </script>
<?php
}

/**
 * Displays an alert message using SweetAlert.
 * 
 * This function displays an alert message with a specified type, title, and message.
 * The type can be used to style the alert message (e.g., success, error, warning).
 * 
 * @param string $type The type of alert message (e.g., success, error, warning).
 * @param string $title The title of the alert message.
 * @param string $message The message to display in the alert.
 */
function swalAlert($type, $title = null, $message = null)
{
?>
    <script>
        Swal.fire({
            icon: '<?= $type ?>',
            title: '<?= $title ?>',
            text: '<?= $message ?>',
            confirmButtonColor: "#198754",
            confirmButtonText: 'Okay'
        });
    </script>
<?php
}

/**
 * Displays an alert message with an action using SweetAlert.
 * 
 * This function displays an alert message with a specified type, title, and message, and redirects to a specified URL after confirmation.
 * The type can be used to style the alert message (e.g., success, error, warning).
 * 
 * @param string $type The type of alert message (e.g., success, error, warning).
 * @param string $title The title of the alert message.
 * @param string $redirect The URL to redirect to after confirmation.
 */
function swalAlertAction($type, $title, $redirect)
{
?>
    <script>
        Swal.fire({
            icon: '<?= $type ?>',
            title: '<?= $title ?>',
            confirmButtonColor: "#26adf8",
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '<?= $redirect ?>';
            }
        });
    </script>
<?php
}
