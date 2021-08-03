
<button onclick=" window.open('<?php echo base_url()?>export/registration', '_blank')" type="button" class="btn btn-success">Export List of Registration (in Excel Format)</button>


<script src="<?php echo base_url()?>assets/jquery/jquery-3.5.1.js"></script>
<script src="<?php echo base_url()?>assets/jquery/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url()?>assets/jquery/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/jquery/sweetalert2@11.js"></script>
<script>

$(document).ready(function(){
    var pagepassword = "<?php echo $password?>";

    if (pagepassword != ""){

        (async () => {
        const { value: password } = await Swal.fire({
            title: 'Enter admin password',
            input: 'password',
            inputLabel: 'Password',
            inputPlaceholder: 'Enter your password',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
            })

            if (password == pagepassword) {
                
            }
            else{
                Swal.fire({
                        title: 'Failed!',
                        text: 'Incorrect Password.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                        }).then((result) => {
                            location.reload();
                        })
                        // End of Swal

            }
        })()
    }
})
</script>