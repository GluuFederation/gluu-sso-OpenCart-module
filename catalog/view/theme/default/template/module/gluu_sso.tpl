<?php
if(!empty($openid_error_message)){
?>
    <h3 style="color: red"><?php echo $openid_error_message;?></h3>
<?php

}
if($gluu_send_user_check == 'yes' && $gluu_oxd_id) {
	header("Location: ".$login_url);
	exit;
}
else if($gluu_send_user_check == 'no' && $gluu_oxd_id) {
?>
<label><h4><input type='radio' name='radio' id='OpenID' value='Yes' />Login by OpenID Provider </h4></label>
<br/><label><h4><input type='radio' name='radio' id='base' value='No' />Show login form </h4></label>
<br/><a href="<?php echo $login_url;?>" style="btn btn-primary; width: 200px" class="btn btn-primary" id="gluu_login">Login by OpenID Provider</a>
<script type="application/javascript">
    jQuery( document ).ready(function() {
        jQuery('.col-sm-6').hide();
        $('input:radio[name="radio"]').change(
                function(){
                    if ($(this).is(':checked') && $(this).val() == 'Yes') {
                        jQuery('#gluu_login').show();
                        jQuery('.col-sm-6').hide();
                    }else{
                        jQuery('#gluu_login').hide();
                        jQuery('.col-sm-6').show();
                    }
                });
        $('#OpenID').attr('checked', true);

    });
</script>
<?php
}

?>