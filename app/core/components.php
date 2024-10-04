<?php

/**
 * FUNCTIONAL COMPONENTS
**/

function refreshUrl(){
    ?>
		<script>location.reload();</script>
	<?php
	die();
}

function refreshUrlTimeout($second){
    ?>
		<script>setTimeout(function(){ location.reload() },<?=$second?>);</script>
	<?php
	die();
}


function redirectUrl($url){
	?>
		<script>window.location.href="<?=$url?>"</script>
	<?php
	die();
}

function redirectUrlTimeout($url, $second){
	?>
		<script>
			setTimeout(function(){ location.href='<?=$url?>'; },'<?=$second?>');
		</script>
	<?php
	die();
}

function alert($type, $message){
	?>
	   <div class="alert alert-<?=$type?> fw-bold py-2"><?=$message?></div>
	<?php
}



function toastHead($status, $header, $message){
    ?>
        <script>
            toastr.<?=$status?>('<?=$message?>', '<?=$header?>');
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false
            }
        </script>
    <?php
}


function swalToast($type, $message){
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
		        	icon: '<?=$type?>',
		        	title: '<?=$message?>'
		      });
			});
		</script>
	<?php
}

function swalAlert($type, $title = null, $message = null){
	?>
		<script>
			Swal.fire({
				icon:'<?=$type?>',
				title:'<?=$title?>',
				text:'<?=$message?>',
				confirmButtonColor: "#26adf8",
				confirmButtonText: 'Okay'
			});
		</script>
	<?php
}

function swalAlertAction($type, $title, $redirect){
	?>
		<script>
			Swal.fire({
				icon:'<?=$type?>',
				title:'<?=$title?>',
				confirmButtonColor: "#26adf8",
				confirmButtonText: 'Okay'
			}).then((result) => {
			    if (result.isConfirmed) {
                    location.href='<?=$redirect?>';
                }
			});
		</script>
	<?php
}

