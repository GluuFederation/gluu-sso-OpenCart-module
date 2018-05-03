<?php echo $header;?>
<?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid"></div>
    </div>
    <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <div id="messages">
                    <?php if (!empty($message_error)){ ?>
                    <div class="mess_red_error">
                        <?php echo $message_error; ?>
                    </div>
                    <?php } ?>
                    <?php if (!empty($message_success)) { ?>
                    <div class="mess_green">
                        <?php echo $message_success; ?>
                    </div>
                    <?php } ?>
                </div>
                <br/>
                <div id="form-socl-login" class="form-horizontal" style="background-color: #e5fff3;">
                    <ul class="nav nav-tabs">
                        <li class="active" id="account_setup"><a href="<?php echo $action_general; ?>">General</a></li>
                        <?php if ( !$gluu_is_oxd_registered) { ?>
                        <li id="social-sharing-setup"><a style="pointer-events: none; cursor: default;">OpenID Connect
                                Configuration</a></li>
                        <?php }else { ?>
                        <li id="social-sharing-setup"><a href="<?php echo $action_openidconfig; ?>">OpenID Connect
                                Configuration</a></li>
                        <?php } ?>
                        <li id=""><a data-method="#configopenid" href="https://oxd.gluu.org/docs/plugin/opencart/"
                                     target="_blank">Documentation</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="General">
                            <form id="register_GluuOxd" name="f" method="post" action="<?php echo $action; ?>"
                                  onsubmit="setFormSubmitting()">
                                <input type="hidden" name="form_key" value="general_oxd_edit"/>
                                <fieldset style="border: 2px solid #53cc6b; padding: 20px">
                                    <legend style="border-bottom:none; width: 110px !important;">
                                        <img style=" height: 45px;"
                                             src="<?php echo $base_url; ?>image/gluu_icon/gl.png"/>
                                    </legend>
                                    <div style="padding-left: 10px;margin-top: -20px">
                                        <div style="padding-left:10px;">
                                            <p>The oxd OpenID Connect single sign-on (SSO) plugin for OpenCart enables you to use a standard OpenID Connect Provider (OP), like Google or the Gluu Server, to authenticate and enroll users for your OpenCart site.</p>
                                            <p>This plugin relies on the oxd mediator service. For oxd deployment instructions and license information, please visit the <a href="https://oxd.gluu.org/">oxd website</a>.</p>
                                            <p>In addition, if you want to host your own OP you can deploy the <a href="https://www.gluu.org/">free open source Gluu Server</a>.</p>
                                        </div>
                                        <h3 style="font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60% ">
                                            Server Settings</h3>
                                        <p><i>The below values are required to configure your OpenCart site with your oxd server and OP. Upon successful registration of your OpenCart site in the OP, a unique identifier will be issued and displayed below in a new field called: oxd ID.</i></p>
                                        <table class="table">
                                            <tr>
                                                <td style="width: 270px"><b>URI of the OpenID Connect Provider:</b></td>
                                                <td><input class="" type="url" name="gluu_provider" id="gluu_provider"
                                                           autofocus="true" disabled
                                                           placeholder="Enter URI of the OpenID Connect Provider."
                                                           style=""
                                                           value="<?php echo $gluu_provider; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 270px"><b>Custom URI after logout:</b></td>
                                                <td><input class="" type="url" name="gluu_custom_logout"
                                                           id="gluu_custom_logout"
                                                           autofocus="true" placeholder="Enter custom URI after logout"
                                                           style=""
                                                           value="<?php echo $gluu_custom_logout;?>"/>
                                                </td>
                                            </tr>
                                            <?php if(!empty($gluu_config['gluu_client_id']) and !empty($gluu_config['gluu_client_secret'])){ ?>
                                            <tr>
                                                <td style="width: 270px"><b>Redirect
                                                        URL:</b></td>
                                                <td><input type="text" disabled value="<?php echo $base_url.'index.php?route=module/gluu_sso/login_by_sso';?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 270px"><b><font color="#FF0000">*</font>Client ID:</b>
                                                </td>
                                                <td><input class="" type="text" name="gluu_client_id"
                                                           id="gluu_client_id"
                                                           autofocus="true"
                                                           placeholder="Enter OpenID Provider client ID."
                                                           style=" "
                                                           value="<?php if(!empty($gluu_config['gluu_client_id'])) echo $gluu_config['gluu_client_id']; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 270px"><b><font color="#FF0000">*</font>Client Secret:</b>
                                                </td>
                                                <td>
                                                    <input class="" type="text" name="gluu_client_secret"
                                                           id="gluu_client_secret"
                                                           autofocus="true"
                                                           placeholder="Enter OpenID Provider client secret." style=" "
                                                           value="<?php if(!empty($gluu_config['gluu_client_secret'])) echo $gluu_config['gluu_client_secret']; ?>"/>
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <tr>
                                                <td>
                                                    <b>
                                                        <font color="#FF0000">*</font>Select oxd server / oxd https extension 
                                                        <a data-toggle="tooltip" class="tooltipLink" data-original-title="If you are using localhost to connect your open cart site to your oxd server, choose oxd server. If you are connecting via https, choose oxd https extension.">
                                                            <span class="fa fa-info-circle"></span>
                                                        </a>
                                                    </b>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">    
                                                            <div class="radio">
                                                                <label><input type="radio" style="margin-top:1px" name="oxd_request_pattern" value="1" <?php if(isset($gluu_config["oxd_request_pattern"]) &&  $gluu_config["oxd_request_pattern"] == 1) { echo 'checked'; }?>>oxd server</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="radio">
                                                                <label><input type="radio" style="margin-top:1px" name="oxd_request_pattern" value="2" <?php if(isset($gluu_config["oxd_request_pattern"]) &&  $gluu_config["oxd_request_pattern"] == 2) { echo 'checked'; }?>>oxd https extension</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="port">
                                                <td class="port" style="width: 270px"><b><font color="#FF0000">*</font>oxd port:</b>
                                                </td>
                                                <td class="port">
                                                    <input class="" type="number" name="gluu_oxd_port" min="0"
                                                           max="65535"
                                                           value="<?php echo $gluu_config['gluu_oxd_port']; ?>"
                                                           style=""
                                                           placeholder="Please enter free port (for example 8099). (Min. number 0, Max. number 65535)."/>
                                                </td>
                                            </tr>
                                            <tr class="host">
                                                <td class="host"><b><font color="#FF0000">*</font>oxd https extension host:</b></td>
                                                <td class="host">
                                                    <input class="" type="text" name="gluu_oxd_web_host" 
                                                           value="<?php echo $gluu_config['gluu_oxd_web_host']; ?>" 
                                                           placeholder="Please enter oxd https extension host">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 270px"><b>oxd ID:</b></td>
                                                <td>
                                                    <input class="" type="text" disabled name="oxd_id"
                                                           value="<?php echo $gluu_is_oxd_registered; ?>"
                                                           style="background-color: rgb(235, 235, 228);"
                                                           placeholder="Your oxd ID"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="padding-left: 10px;">
                                        <h3 style="font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60%;">
                                            Enrollment and Access Management
                                            <a data-toggle="tooltip" class="tooltipLink"
                                               data-original-title="Choose whether to register new users when they login at an external identity provider. If you disable automatic registration, new users will need to be manually created">
                                                <span class="fa fa-info-circle"></span>
                                            </a>
                                        </h3>
                                        <div style="padding-left: 10px;">
                                            <p><label><input name="gluu_users_can_register" type="radio"
                                                             id="gluu_users_can_register" <?php if($gluu_users_can_register==1){ echo "checked";} ?>
                                                    value="1" style="margin-right: 3px"> Automatically register any user
                                                    with an account in the OpenID Provider</label></p>
                                        </div>
                                        <div style="padding-left: 10px;">
                                            <p><label><input name="gluu_users_can_register" type="radio"
                                                             id="gluu_users_can_register" <?php if($gluu_users_can_register==2){ echo "checked";} ?>
                                                    value="2" style="margin-right: 3px"> Only register and allow ongoing access to users with one or more of the following roles in the OpenID Provider</label></p>
                                            <div style="margin-left: 20px;">
                                                <div id="p_role">
                                                    <?php $k=0;
                                        if(!empty($gluu_new_roles)) {
                                            foreach ($gluu_new_roles as $gluu_new_role) {
                                                if (!$k) {
                                                    $k++;
                                                    ?>
                                                    <p class="role_p" style="padding-top: 10px">
                                                        <input type="text" name="gluu_new_role[]" required
                                                               class="form-control"
                                                               style="display: inline; width: 200px !important; "
                                                               placeholder="Input role name"
                                                               value="<?php echo $gluu_new_role; ?>"/>
                                                        <button type="button" class="btn btn-xs add_new_role"
                                                                onclick="test_add()"><span
                                                                    class="glyphicon glyphicon-plus"></span></button>
                                                    </p>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <p class="role_p" style="padding-top: 10px">
                                                        <input type="text" name="gluu_new_role[]" required
                                                               placeholder="Input role name" class="form-control"
                                                               style="display: inline; width: 200px !important; "
                                                               value="<?php echo $gluu_new_role; ?>"/>
                                                        <button type="button" class="btn btn-xs add_new_role"
                                                                onclick="test_add()"><span
                                                                    class="glyphicon glyphicon-plus"></span></button>
                                                        <button type="button" class="btn btn-xs remrole"><span
                                                                    class="glyphicon glyphicon-minus"></span></button>
                                                    </p>
                                                    <?php }
                                            }
                                        }else{
                                            ?>
                                                    <p class="role_p" style="padding-top: 10px">
                                                        <input type="text" name="gluu_new_role[]" required
                                                               placeholder="Input role name" class="form-control"
                                                               style="display: inline; width: 200px !important; "
                                                               value=""/>
                                                        <button type="button" class="btn btn-xs add_new_role"
                                                                onclick="test_add()"><span
                                                                    class="glyphicon glyphicon-plus"></span></button>
                                                    </p>
                                                    <?php
                                        }?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="padding-left: 10px;">
                                            <p><label><input name="gluu_users_can_register" type="radio"
                                                             id="gluu_users_can_register_3" <?php if($gluu_users_can_register==3){ echo "checked";} ?>
                                                    value="3" style="margin-right: 3px">Disable automatic
                                                    registration</label></p>
                                        </div>
                                        <table class="table">
                                            <tr>
                                                <td style="width: 290px"><label for="UserType"><b>New Customer Default Group:</b></label></td>
                                                <td>
                                                    <div class="form-group"
                                                         style="margin-bottom: 0px !important; width: 370px">
                                                        <select id="UserType" class="form-control"
                                                                name="gluu_user_role">
                                                            <?php
                                                foreach($user_types as $user_type){
                                                    ?>
                                                            <option
                                                            <?php if($user_type['status'] == $gluu_user_role) echo 'selected'; ?>
                                                            value="<?php echo $user_type['status'];?>
                                                            "><?php echo $user_type['name'];?></option>
                                                            <?php
                                                }
                                                ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="border-bottom:2px solid #000;"></div>
                                            <br/><br/>
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-3 text-right">
                                                <input type="submit" name="saveButton" value="Save"
                                                       style="text-decoration: none;text-align:center; width: 120px; margin-right: 20px"
                                                       class="btn btn-primary"/>
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-primary"
                                                   onclick="edit_cancel_function()"
                                                   style="text-align:center; width: 120px;margin-left: -15px"
                                                   href="<?php echo $cancel;?>">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    var $m = jQuery;
    jQuery(document ).ready(function() {
        <?php if(isset($gluu_config["oxd_request_pattern"]) &&  $gluu_config["oxd_request_pattern"] == 2) { ?>
            jQuery(".port").hide();
            jQuery(".host").show();
        <?php } else { ?>
            jQuery(".host").hide();
            jQuery(".port").show();
        <?php } ?>
        
        jQuery("input[name='oxd_request_pattern']").change(function(){
            if(jQuery(this).val() == 2){
                jQuery(".port").hide();
                jQuery(".host").show();
            } else {
                jQuery(".host").hide();
                jQuery(".port").show();
            }
        });
        <?php if($gluu_users_can_register == 2){ ?>
            jQuery("#p_role").children().prop('disabled',false);
            jQuery("#p_role *").prop('disabled',false);
        <?php  }else if($gluu_users_can_register == 3){ ?>
            jQuery("#p_role").children().prop('disabled',true);
            jQuery("#p_role *").prop('disabled',true);
            jQuery("input[name='gluu_new_role[]']").each(function(){
                var striped = jQuery('#p_role');
                var value =  jQuery(this).attr("value");
                jQuery('<p><input type="hidden" name="gluu_new_role[]"  value= "'+value+'"/></p>').appendTo(striped);
            });
            jQuery("#UserType").prop('disabled',true);
        <?php }else{ ?>
            jQuery("#p_role").children().prop('disabled',true);
            jQuery("#p_role *").prop('disabled',true);
            jQuery("input[name='gluu_new_role[]']").each(function(){
                var striped = jQuery('#p_role');
                var value =  jQuery(this).attr("value");
                jQuery('<p><input type="hidden" name="gluu_new_role[]"  value= "'+value+'"/></p>').appendTo(striped);
            });
        <?php } ?>
        jQuery('input:radio[name="gluu_users_can_register"]').change(function(){
            if(jQuery(this).is(':checked') && jQuery(this).val() == '2'){
                jQuery("#p_role").children().prop('disabled',false);
                jQuery("#p_role *").prop('disabled',false);
                jQuery("input[type='hidden'][name='gluu_new_role[]']").remove();
                jQuery("#UserType").prop('disabled',false);
            }else if(jQuery(this).is(':checked') && jQuery(this).val() == '3'){
                jQuery("#p_role").children().prop('disabled',true);
                jQuery("#p_role *").prop('disabled',true);
                jQuery("input[type='hidden'][name='gluu_new_role[]']").remove();
                jQuery("input[name='gluu_new_role[]']").each(function(){
                    var striped = jQuery('#p_role');
                    var value =  jQuery(this).attr("value");
                    jQuery('<p><input type="hidden" name="gluu_new_role[]"  value= "'+value+'"/></p>').appendTo(striped);
                });
                jQuery("#UserType").prop('disabled',true);
            }else{
                jQuery("#p_role").children().prop('disabled',true);
                jQuery("#p_role *").prop('disabled',true);
                jQuery("input[type='hidden'][name='gluu_new_role[]']").remove();
                jQuery("input[name='gluu_new_role[]']").each(function(){
                    var striped = jQuery('#p_role');
                    var value =  jQuery(this).attr("value");
                    jQuery('<p><input type="hidden" name="gluu_new_role[]"  value= "'+value+'"/></p>').appendTo(striped);
                });
                jQuery("#UserType").prop('disabled',false);
            }
        });
        jQuery("input[name='scope[]']").change(function(){
            var form=$("#scpe_update");
            if (jQuery(this).is(':checked')) {
                jQuery.ajax({
                    url: window.location,
                    type: 'POST',
                    data:form.serialize(),
                    success: function(result){
                        if(result){
                            return false;
                        }
                    }});
            }else{
                jQuery.ajax({
                    url: window.location,
                    type: 'POST',
                    data:form.serialize(),
                    success: function(result){
                        if(result){
                            return false;
                        }
                    }});
            }
        });

        jQuery('#p_role').on('click', '.remrole', function() {
            jQuery(this).parents('.role_p').remove();
        });
    });

    function test_add() {
        var wrapper1 = '<p class="role_p" style="padding-top: 10px">' +
            '<input class="form-control"  type="text" name="gluu_new_role[]" placeholder="Input role name" style="display: inline; width: 200px !important; margin-right: 5px"/>' +
            '<button type="button" class="btn btn-xs add_new_role" onclick="test_add()"><span class="glyphicon glyphicon-plus"></span></button> ' +
            '<button type="button" class="btn btn-xs remrole" ><span class="glyphicon glyphicon-minus"></span></button>' +
            '</p>';
        jQuery(wrapper1).find('.remrole').on('click', function() {
            jQuery(this).parent('.role_p').remove();
        });
        jQuery(wrapper1).appendTo('#p_role');
    }
</script>
<script type="application/javascript">
    
    /*window.onbeforeunload = function(){
     return "You may have unsaved changes. Are you sure you want to leave this page?"
     }*/
    var formSubmitting = false;
    var setFormSubmitting = function() { formSubmitting = true; };
    var edit_cancel_function = function() { formSubmitting = true; };
    window.onload = function() {
        window.addEventListener("beforeunload", function (e) {
            if (formSubmitting ) {
                return undefined;
            }

            var confirmationMessage = "You may have unsaved changes. Are you sure you want to leave this page?";

            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        });
    };
</script>
<?php echo $footer; ?>
