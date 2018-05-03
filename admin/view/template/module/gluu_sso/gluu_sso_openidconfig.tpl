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
                <div  id="form-socl-login" class="form-horizontal" style="background-color: #e5fff3;">
                    <ul class="nav nav-tabs">
                        <li  id="account_setup"><a  href="<?php echo $action_general; ?>">General</a></li>
                        <?php if ( !$gluu_is_oxd_registered) { ?>
                        <li id="social-sharing-setup"><a style="pointer-events: none; cursor: default;" >OpenID Connect Configuration</a></li>
                        <?php }else { ?>
                        <li class="active" id="social-sharing-setup"><a href="<?php echo $action_openidconfig; ?>">OpenID Connect Configuration</a></li>
                        <?php } ?>
                        <li id=""><a data-method="#configopenid" href="https://oxd.gluu.org/docs/plugin/opencart/" target="_blank">Documentation</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="General">
                            <form action="<?php echo $action; ?>" method="post" id="scpe_update">
                                <input type="hidden" name="form_key" value="openid_config_page"/>
                                <fieldset style="border: 2px solid #53cc6b; padding: 20px">
                                    <legend style="border-bottom:none; width: 110px !important;">
                                        <img style=" height: 45px;" src="<?php echo $base_url; ?>image/gluu_icon/gl.png"/>
                                    </legend>
                                    <h1 style="margin-left: 30px;padding-bottom: 20px; border-bottom: 2px solid black; width: 75% ">User Scopes</h1>
                                    <div >
                                        <table style="margin-left: 30px" class="form-table">
                                            <tr style="border-bottom: 1px solid green !important;">
                                                <th style="width: 200px; padding: 0px; ">
                                                    <h4 style="text-align: left;font-weight: bold !important;" id="scop_section">
                                                        Requested scopes
                                                        <a data-toggle="tooltip" class="tooltipLink" data-original-title="Scopes are bundles of attributes that the OP stores about each user. It is recommended that you request the minimum set of scopes required">
                                                            <span class="fa fa-info"></span>
                                                        </a>
                                                    </h4>
                                                </th>
                                                <td style="width: 200px; padding-left: 10px !important">
                                                    <table id="table-striped" class="form-table" >
                                                        <tbody style="width: inherit !important;">
                                                        <tr style="padding: 0px">
                                                            <td style=" width: 10%; padding: 0px 5px !important;">
                                                                <p >
                                                                    <input checked type="checkbox" name=""  id="openid" value="openid"  disabled />

                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important; width: 70%">
                                                                <p >
                                                                    <input type="hidden"  name="scope[]"  value="openid" />openid
                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important;  width: 20%">
                                                                <a class="btn btn-danger btn-xs" style="margin: 5px; float: right" disabled><span class="fa fa-trash-o"></span></a>
                                                            </td>
                                                        </tr>
                                                        <tr style="padding: 0px">
                                                            <td style=" padding: 0px 5px !important; width: 10%">
                                                                <p >
                                                                    <input checked type="checkbox" name=""  id="email" value="email"  disabled />

                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important; width: 70%">
                                                                <p >
                                                                    <input type="hidden"  name="scope[]"  value="email" />email
                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important;  width: 20%">
                                                                <a class="btn btn-danger btn-xs" style="margin: 5px; float: right" disabled><span class="fa fa-trash-o"></span></a>
                                                            </td>
                                                        </tr>
                                                        <tr style="padding: 0px">
                                                            <td style=" padding: 0px 5px !important; width: 10%">
                                                                <p >
                                                                    <input checked type="checkbox" name=""  id="_profile" value="_profile"  disabled />

                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important; width: 70%">
                                                                <p >
                                                                    <input type="hidden"  name="scope[]"  value="profile" />profile
                                                                </p>
                                                            </td>
                                                            <td style=" padding: 0px 5px !important;  width: 20%">
                                                                <a class="btn btn-danger btn-xs" style="margin: 5px; float: right" disabled><span class="fa fa-trash-o"></span></a>
                                                            </td>
                                                        </tr>
                                                        <?php foreach($get_scopes as $scop) :?>
                                                        <?php if ($scop == 'openid' or $scop == 'email' or $scop == 'profile'){?>
                                                        <?php } else{ ?>
                                                        <tr style="padding: 0px">
                                                        <td style=" padding: 0px 5px !important;">
                                                        <p id="<?php echo $scop;?>1">
                                                        <input <?php if($gluu_config && in_array($scop, $gluu_config['config_scopes'])){ echo "checked";} ?> type="checkbox" name="scope[]"  id="<?php echo $scop;?>1" value="<?php echo $scop;?>" <?php if (!$gluu_is_oxd_registered || $scop=='openid') echo ' disabled '; ?> />
                                                        </p>
                                                        </td>
                                                        <td style=" padding: 0px 5px !important;">
                                                            <p id="<?php echo $scop;?>1">
                                                                <?php echo $scop;?>
                                                            </p>
                                                        </td>
                                                        <td style=" padding: 0px 5px !important; ">
                                                            <button type="button" class="btn btn-danger btn-xs" style="margin: 5px; float: right" onclick="delete_scopes('<?php echo $scop;?>')" ><span class="fa fa-trash-o"></span></button>
                                                        </td>
                                                        </tr>
                                                        <?php } endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid green !important;">
                                                <th>
                                                    <h4 style="text-align: left;font-weight: bold !important;" id="scop_section1">
                                                        Add scopes
                                                    </h4>
                                                </th>
                                                <td>
                                                    <div style="margin-left: 10px" id="p_scents">
                                                        <p>
                                                            <input <?php if(!$gluu_is_oxd_registered) echo 'disabled'?> class="form-control" type="text" id="new_scope_field" name="new_scope[]" placeholder="Input scope name" />
                                                        </p>
                                                        <br/>
                                                        <p>
                                                            <input type="button" style="width: 80px" class="btn btn-primary btn-large" onclick="add_scope_for_delete()" value="Add" id="add_new_scope"/>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br/>
                                    <h1 style="margin-left: 30px;padding-bottom: 20px; border-bottom: 2px solid black; width: 75%">Authentication</h1>
                                    <br/>
                                    <p style=" margin-left: 20px; font-weight:bold "><label style="display: inline !important; "><input type="checkbox" name="send_user_check" id="send_user" value="1" <?php if(!$gluu_is_oxd_registered) echo 'disabled'?> <?php if( $gluu_send_user_check == 'yes') echo 'checked';?> /> <span>Bypass the local Opencart login page and send customers straight to the OP for authentication</span></label>
                                    </p>
                                    <br/>
                                    <div>
                                        <table style="margin-left: 30px" class="form-table">
                                            <tbody>
                                            <tr>
                                                <th style="width: 200px; padding: 0px; ">
                                                    <h4 style="text-align: left; font-weight: bold !important;" id="scop_section">
                                                        Select ACR: <a data-toggle="tooltip" class="tooltipLink" data-original-title="The OpenID Provider may make available multiple authentication mechanisms. To signal which type of authentication should be used for access to this site you can request a specific ACR. To accept the OP's default authentication, set this field to none.">
                                                            <span class="fa fa-info"></span>
                                                        </a>
                                                    </h4>
                                                </th>
                                                <td >
                                                    <?php
                                        $custom_scripts = $gluu_acr;
                                        if(!empty($custom_scripts)){
                                            ?>
                                                    <select style="margin-left: 5px;  padding: 0px 5px !important;" class="form-control" name="send_user_type" id="send_user_type" <?php if(!$gluu_is_oxd_registered) echo 'disabled'?>>
                                                    <option value="default">none</option>
                                                    <?php
                                                if($custom_scripts){
                                                    foreach($custom_scripts as $custom_script){
                                                        if($custom_script != "default" and $custom_script != "none"){
                                                            ?>
                                                    <option <?php if($gluu_auth_type == $custom_script) echo 'selected'; ?> value="<?php echo $custom_script;?>"><?php echo $custom_script;?></option>
                                                    <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                    </select>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            
                                            </tbody>
                                        </table>
                                        <div style="border-bottom:2px solid #000;"></div>
                                        <br/><br/>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4 text-center">
                                                <input type="submit" class="btn btn-primary btn-large" <?php if(!$gluu_is_oxd_registered) echo 'disabled'?> value="Save Authentication Settings" name="set_oxd_config" />
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
    jQuery(document).ready(function() {

        jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('#p_role').on('click', 'a.remrole', function() {
            jQuery(this).parents('.role_p').remove();
        });

    });
    jQuery(document ).ready(function() {

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

    });
    function delete_scopes(val){
        if (confirm("Are you sure that you want to delete this scope? You will no longer be able to request this user information from the OP.")) {
            jQuery.ajax({
                url: window.location,
                type: 'POST',
                data:{form_key_scope_delete:'form_key_scope_delete', delete_scope:val},
                success: function(result){
                    location.reload();
                }});
        }
        else{
            return false;
        }

    }

    function add_scope_for_delete() {
        var striped = jQuery('#table-striped');
        var k = jQuery('#p_scents p').size() + 1;
        var new_scope_field = jQuery('#new_scope_field').val();
        var m = true;
        if(new_scope_field){
            jQuery("input[name='scope[]']").each(function(){
                // get name of input
                var value =  jQuery(this).attr("value");
                if(value == new_scope_field){
                    m = false;
                }
            });
            if(m){
                jQuery('<tr >' +
                        '<td style=" padding: 0px 5px !important;">' +
                        '   <p  id="'+new_scope_field+'">' +
                        '     <input type="checkbox" name="scope[]" id="new_'+new_scope_field+'" value="'+new_scope_field+'"  />'+
                        '   </p>' +
                        '</td>' +
                        '<td style=" padding: 0px 5px !important;">' +
                        '   <p  id="'+new_scope_field+'">' +
                        new_scope_field+
                        '   </p>' +
                        '</td>' +
                        '<td style=" padding: 0px 5px !important; ">' +
                        '   <a href="#scop_section" class="btn btn-danger btn-xs" style="margin: 5px; float: right" onclick="delete_scopes(\''+new_scope_field+'\')" >' +
                        '<span class="fa fa-trash-o"></span>' +
                        '</a>' +
                        '</td>' +
                        '</tr>').appendTo(striped);
                jQuery('#new_scope_field').val('');

                jQuery.ajax({
                    url: window.location,
                    type: 'POST',
                    data:{form_key_scope:'oxd_openid_config_new_scope', new_value_scope:new_scope_field},
                    success: function(result){
                        if(result){
                            return false;
                        }
                    }});
                jQuery("#new_"+new_scope_field).change(
                        function(){
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

                return false;
            }
            else{
                alert('The scope named '+new_scope_field+' is exist!');
                jQuery('#new_scope_field').val('');
                return false;
            }
        }else{
            alert('Please input scope name!');
            jQuery('#new_scope_field').val('');
            return false;
        }
    }
</script>

<?php echo $footer; ?>
