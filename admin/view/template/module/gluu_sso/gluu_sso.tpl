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
                <div id="form-socl-login" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active" id="account_setup"><a href="<?php echo $action_general; ?>">General</a></li>
                        <?php if ( !$gluu_is_oxd_registered) { ?>
                        <li id="social-sharing-setup"><a style="pointer-events: none; cursor: default;">OpenID Connect Configuration</a></li>
                        <?php }else { ?>
                        <li id="social-sharing-setup"><a href="<?php echo $action_openidconfig; ?>">OpenID Connect Configuration</a></li>
                        <?php } ?>
                        <li id=""><a data-method="#configopenid" href="https://oxd.gluu.org/docs/plugin/opencart/"
                                     target="_blank">Documentation</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="General">
                            <?php if (!$gluu_oxd_id){ ?>
                            <div class="mo2f_table_layout">
                                <form id="register_GluuOxd" name="f" method="post"
                                      action="<?php echo $action; ?>">
                                    <input type="hidden" name="form_key" value="general_register_page"/>
                                    <div class="login_GluuOxd">
                                        <br/>
                                        <div style="padding-left: 20px;">Register your site with any standard OpenID
                                            Provider (OP). If you need an OpenID Provider you can deploy the <a
                                                    target="_blank" href="https://gluu.org/docs/deployment/"> free open
                                                source Gluu Server.</a></div>
                                        <hr>
                                        <div style="padding-left: 20px;">This plugin relies on the oxd mediator service.
                                            For oxd deployment instructions and license information, please visit the <a
                                                    target="_blank" href="https://oxd.gluu.org">oxd website.</a></div>
                                        <hr>
                                        <div style="padding-left: 20px;">
                                            <h3 style=" font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60%; font-weight: bold ">
                                                Server Settings</h3>
                                            <table class="table">

                                                <tr>
                                                    <td style="width: 270px"><b>URI of the OpenID Provider:</b></td>
                                                    <td><input class="" type="url" name="gluu_provider"
                                                               id="gluu_provider"
                                                               autofocus="true"
                                                               placeholder="Enter URI of the OpenID Provider."
                                                               value="<?php echo $gluu_provider;?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 270px"><b>Custom URI after logout:</b></td>
                                                    <td><input class="" type="url" name="gluu_custom_logout"
                                                               id="gluu_custom_logout"
                                                               autofocus="true"
                                                               placeholder="Enter custom URI after logout"
                                                               value="<?php echo $gluu_custom_logout;?>"/>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($openid_error)){ ?>
                                                <tr>
                                                    <td style="width: 270px"><b><font color="#FF0000">*</font>Redirect
                                                            URL:</b></td>
                                                    <td><p><?php echo $base_url.'index.php?route=module/gluu_sso/login_by_sso';?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 270px"><b><font color="#FF0000">*</font>Client ID:</b>
                                                    </td>
                                                    <td><input class="" type="text" name="gluu_client_id"
                                                               id="gluu_client_id"
                                                               autofocus="true"
                                                               placeholder="Enter OpenID Provider client ID."
                                                               value="<?php if(!empty($gluu_config['gluu_client_id'])) echo $gluu_config['gluu_client_id']; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 270px"><b><font color="#FF0000">*</font>Client
                                                            Secret:</b></td>
                                                    <td>
                                                        <input class="" type="text" name="gluu_client_secret"
                                                               id="gluu_client_secret"
                                                               autofocus="true"
                                                               placeholder="Enter OpenID Provider client secret."
                                                               value="<?php if(!empty($gluu_config['gluu_client_secret'])) echo $gluu_config['gluu_client_secret']; ?>"/>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                    <td style="width: 270px"><b><font color="#FF0000">*</font>oxd port:</b>
                                                    </td>
                                                    <td>
                                                        <input class="" type="number" name="gluu_oxd_port" min="0"
                                                               max="65535"
                                                               value="<?php echo $gluu_config['gluu_oxd_port']; ?>"
                                                               placeholder="Please enter free port (for example 8099). (Min. number 0, Max. number 65535)."/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="padding-left: 20px">
                                            <h3 style="font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60%;">
                                                Enrollment and Access Management
                                                <a data-toggle="tooltip" class="tooltipLink"
                                                   data-original-title="Choose whether to register new users when they login at an external identity provider. If you disable automatic registration, new users will need to be manually created">
                                                    <span class="fa fa-info"></span>
                                                </a>
                                            </h3>
                                            <div class="radio">
                                                <p><label><input name="gluu_users_can_register" type="radio" id="gluu_users_can_register" <?php if($gluu_users_can_register==1){ echo "checked";} ?>  value="1" style="margin-right: 3px"><b> Automatically register any user with an account in the OpenID Provider</b></label>
                                                </p>
                                            </div>
                                            <div class="radio">
                                                <p><label><input name="gluu_users_can_register" type="radio"
                                                                 id="gluu_users_can_register_1" <?php if($gluu_users_can_register==2){ echo "checked";} ?>
                                                        value="2" style="margin-right: 3px"> <b>Only register and allow ongoing access to users with one or more of the following roles in the OpenID Provider</b></label></p>
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
                                                                        class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                        </p>
                                                        <?php
                                                        } else {
                                                            ?>
                                                        <p class="role_p" style="padding-top: 10px">
                                                            <input type="text" name="gluu_new_role[]" required
                                                                   class="form-control"
                                                                   style="display: inline; width: 200px !important; "
                                                                   placeholder="Input role name"
                                                                   value="<?php echo $gluu_new_role; ?>"/>
                                                            <button type="button" class="btn btn-xs add_new_role"
                                                                    onclick="test_add()"><span
                                                                        class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                            <button type="button" class="btn btn-xs remrole"><span
                                                                        class="glyphicon glyphicon-minus"></span>
                                                            </button>
                                                        </p>
                                                        <?php }
                                                    }
                                                }else{
                                                    ?>
                                                        <p class="role_p" style="padding-top: 10px">
                                                            <input type="text" name="gluu_new_role[]" required
                                                                   class="form-control" placeholder="Input role name"
                                                                   style="display: inline; width: 200px !important; "
                                                                   value=""/>
                                                            <button type="button" class="btn btn-xs add_new_role"
                                                                    onclick="test_add()"><span
                                                                        class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                        </p>
                                                        <?php
                                                }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="radio">
                                                <p>
                                                    <label>
                                                        <input name="gluu_users_can_register" type="radio" id="gluu_users_can_register_2" <?php if($gluu_users_can_register==3){ echo "checked";} ?> value="3" style="margin-right: 3px" />
                                                        <b>Disable automatic registration</b>
                                                    </label>
                                                </p>
                                            </div>
                                            <table class="table" >
                                                <tr>
                                                    <td style="width: 290px;"><b>New Customer Default Group:</b></td>
                                                    <td>
                                                        <div class="form-group" style="margin-bottom: 0px !important; width: 370px">
                                                            <select id="UserType" class="form-control"  name="gluu_user_role">
                                                                <?php foreach($user_types as $user_type){ ?>
                                                                <option <?php if($user_type['status'] == $gluu_user_role) echo 'selected'; ?> "><?php echo $user_type['name'];?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($openid_error)){ ?>
                                                <tr>
                                                    <td style="width: 290px;">
                                                        <div><input class="btn btn-success button button-primary"
                                                                    type="submit" name="register" value="Register"
                                                                    style=";width: 120px; float: right; margin-right: 20px"/></div>
                                                    </td>
                                                    <td>
                                                        <div><a class="btn btn-danger button button-primary"
                                                                onclick="return confirm('Are you sure that you want to remove this OpenID Connect provider? Users will no longer be able to authenticate against this OP.')"
                                                                style="text-decoration: none;text-align:center; float: left; width: 120px; margin-left: -15px"
                                                                href="<?php echo $action; ?>&submit=delete">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php }
                                        else{ ?>
                                                <tr>
                                                    <?php if(!empty($gluu_provider)){ ?>
                                                    <td style="width: 250px">
                                                        <div><input type="submit" name="register" value="Register"
                                                                    style="width: 120px; float: right; margin-right: 20px"
                                                                    class="btn btn-success button button-primary"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger button button-primary"
                                                           onclick="return confirm('Are you sure that you want to remove this OpenID Connect provider? Users will no longer be able to authenticate against this OP.')"
                                                           style="text-decoration: none;text-align:center; float: left; width: 120px; margin-left: -15px"
                                                           href="<?php echo $action; ?>&submit=delete">Delete</a>
                                                    </td>
                                                    <?php }else{ ?>
                                                    <td style="width: 250px">
                                                        <div><input type="submit" name="submit" value="Register"
                                                                    style="width: 120px; float: right;margin-right: 20px"
                                                                    class="btn btn-success button button-primary"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <?php }?>
                                                </tr>
                                                <?php }?>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php } else{ ?>
                            <div class="mo2f_table_layout">

                                <form id="register_GluuOxd" name="f" method="post" action="<?php echo $action; ?>">
                                    <input type="hidden" name="form_key" value="general_oxd_id_reset"/>
                                    <fieldset style="border: 2px solid #53cc6b; padding: 20px">
                                        <legend style="border-bottom:none; width: 110px !important;">
                                            <img style=" height: 45px;" src="<?php echo $base_url; ?>image/gluu_icon/gl.png"/>
                                        </legend>
                                        <div style="padding-left: 20px; margin-top: -30px;">
                                            <h3 style="font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60%; ">Server Settings</h3>
                                            <table class="table">
                                                <tr>
                                                    <td style="width: 270px"><b>URI of the OpenID Provider:</b></td>
                                                    <td><input type="url" name="gluu_provider" id="gluu_provider"
                                                               disabled placeholder="Enter URI of the OpenID Provider."
                                                               value="<?php echo $gluu_provider; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 270px"><b>Custom URI after logout:</b></td>
                                                    <td><input class="" type="url" name="gluu_custom_logout" id="gluu_custom_logout"
                                                               autofocus="true" disabled placeholder="Enter custom URI after logout"

                                                               value="<?php echo $gluu_custom_logout;?>"/>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($gluu_config['gluu_client_id']) and !empty($gluu_config['gluu_client_secret'])){ ?>
                                                <tr>
                                                    <td style="width: 250px"><b><font color="#FF0000">*</font>Redirect URL:</b></td>
                                                    <td><p><?php echo $base_url.'index.php?route=module/gluu_sso/login_by_sso';?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 250px"><b><font color="#FF0000">*</font>Client ID:</b></td>
                                                    <td><input class="" type="text" name="gluu_client_id" id="gluu_client_id"
                                                               autofocus="true" placeholder="Enter OpenID Provider client ID."
                                                               style="background-color: rgb(235, 235, 228);"
                                                               value="<?php if(!empty($gluu_config['gluu_client_id'])) echo $gluu_config['gluu_client_id']; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 250px"><b><font color="#FF0000">*</font>Client Secret:</b></td>
                                                    <td>
                                                        <input class="" type="text" name="gluu_client_secret" id="gluu_client_secret"
                                                               autofocus="true" placeholder="Enter OpenID Provider client secret."  style="background-color: rgb(235, 235, 228);" value="<?php if(!empty($gluu_config['gluu_client_secret'])) echo $gluu_config['gluu_client_secret']; ?>"/>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                    <td style="width: 250px"><b><font color="#FF0000">*</font>oxd port:</b></td>
                                                    <td>
                                                        <input class="" type="text" disabled name="gluu_oxd_port" min="0" max="65535"
                                                               value="<?php echo $gluu_config['gluu_oxd_port']; ?>"
                                                               style=" background-color: rgb(235, 235, 228);" placeholder="Please enter free port (for example 8099). (Min. number 0, Max. number 65535)."/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 250px"><b>oxd ID:</b></td>
                                                    <td>
                                                        <input class="" type="text" disabled name="oxd_id"
                                                               value="<?php echo $gluu_is_oxd_registered; ?>"
                                                               style="background-color: rgb(235, 235, 228);" placeholder="Your oxd ID" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="padding-left: 20px;">
                                            <h3 style="font-weight:bold;padding-left: 10px;padding-bottom: 20px; border-bottom: 2px solid black; width: 60%;">Enrollment and Access Management
                                                <a data-toggle="tooltip" class="tooltipLink" data-original-title="Choose whether to register new users when they login at an external identity provider. If you disable automatic registration, new users will need to be manually created">
                                                    <span class="fa fa-info"></span>
                                                </a>
                                            </h3>
                                            <div>
                                                <p><label><input name="gluu_users_can_register" disabled type="radio" id="gluu_users_can_register" <?php if($gluu_users_can_register==1){ echo "checked";} ?> value="1" style="margin-right: 3px"><b> Automatically register any user with an account in the OpenID Provider</b></label></p>
                                            </div>
                                            <div>
                                                <p><label ><input name="gluu_users_can_register" disabled type="radio" id="gluu_users_can_register" <?php if($gluu_users_can_register==2){ echo "checked";} ?> value="2" style="margin-right: 3px"><b> Only register and allow ongoing access to users with one or more of the following roles in the OpenID Provider</b></label></p>
                                                <div style="margin-left: 20px;">
                                                    <div id="p_role_disabled">
                                                        <?php $k=0;
                                            if(!empty($gluu_new_roles)) {
                                                foreach ($gluu_new_roles as $gluu_new_role) {
                                                    if (!$k) {
                                                        $k++;
                                                        ?>
                                                        <p class="role_p" style="padding-top: 10px">
                                                            <input  type="text" name="gluu_new_role[]" disabled  style="display: inline; width: 200px !important; "
                                                                    placeholder="Input role name" class="form-control"
                                                                    value="<?php echo $gluu_new_role; ?>"/>
                                                            <button type="button" class="btn btn-xs " disabled="true"><span class="glyphicon glyphicon-plus"></span></button>
                                                        </p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p class="role_p" style="padding-top: 10px">
                                                            <input type="text" name="gluu_new_role[]" disabled class="form-control"
                                                                   placeholder="Input role name" style="display: inline; width: 200px !important; "
                                                                   value="<?php echo $gluu_new_role; ?>"/>
                                                            <button type="button" class="btn btn-xs " disabled="true" ><span class="glyphicon glyphicon-plus"></span></button>
                                                            <button type="button" class="btn btn-xs " disabled="true"><span class="glyphicon glyphicon-minus"></span></button>
                                                        </p>
                                                        <?php }
                                                }
                                            }else{
                                                ?>
                                                        <p class="role_p" style="padding-top: 10px">
                                                            <input type="text" name="gluu_new_role[]" disabled placeholder="Input role name" class="form-control" style="display: inline; width: 200px !important; " value=""/>
                                                            <button type="button" class="btn btn-xs " disabled="true" ><span class="glyphicon glyphicon-plus"></span></button>
                                                        </p>
                                                        <?php
                                            }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <p><label><input name="gluu_users_can_register" disabled type="radio" id="gluu_users_can_register_2" <?php if($gluu_users_can_register==3){ echo "checked";} ?> value="3" style="margin-right: 3px"><b>Disable automatic registration</b></label></p>
                                            </div>
                                            <table class="table">
                                                <tr>
                                                    <td style="width: 290px"><b>New Customer Default Group:</b></td>
                                                    <td>
                                                        <div class="form-group" style="margin-bottom: 0px !important; width: 370px !important;">
                                                            <select id="UserType" class="form-control" name="gluu_user_role" disabled>
                                                                <?php
                                                                    foreach($user_types as $user_type){
                                                                        ?>
                                                                <option <?php if($user_type['status'] == $gluu_user_role) echo 'selected'; ?> value="<?php echo $user_type['status'];?>"><?php echo $user_type['name'];?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 250px">
                                                        <a class="btn btn-success button button-primary" style="float:right;text-decoration: none;text-align:center; width: 120px;background-color: blue; margin-right: 20px" href="<?php echo $action_edit?>">Edit</a>
                                                    </td>
                                                    <td>
                                                        <input type="submit" onclick="return confirm('Are you sure that you want to remove this OpenID Connect provider? Users will no longer be able to authenticate against this OP.')" name="resetButton" value="Delete" style="text-decoration: none;text-align:center; float: left; width: 120px; margin-left: -15px" class="btn btn-danger button button-primary"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <?php } ?>
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
        jQuery("#p_role").on("click", ".remrole", function() {
            jQuery(this).parents(".role_p").remove();
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
<?php echo $footer; ?>
