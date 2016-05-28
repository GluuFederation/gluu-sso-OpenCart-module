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
                <div  id="form-socl-login" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="<?php if($activ_tab == 'General'){ echo 'active';} ?>"><a href="#General" data-toggle="tab"><?php echo $General; ?></a></li>
                        <li class="<?php if($activ_tab == 'OpenIDConnect'){ echo 'active';} ?>"><a href="#OpenIDConnect" data-toggle="tab"><?php echo $OpenIDConnect; ?></a></li>
                        <li class="<?php if($activ_tab == 'OpenCartConfig'){ echo 'active';} ?>"><a href="#OpenCartConfig" data-toggle="tab"><?php echo $OpenCartConfig; ?></a></li>
                        <li class="<?php if($activ_tab == 'helpTrouble'){ echo 'active';} ?>"><a href="#helpTrouble" data-toggle="tab"><?php echo $helpTrouble; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?php if($activ_tab == 'General'){ echo 'active';} ?>" id="General">
                            <?php if (!$oxd_id){ ?>
                            <div class="mo2f_table_layout">
                                <form id="register_GluuOxd" name="f" method="post"
                                      action="<?php echo $action; ?>">
                                    <input type="hidden" name="form_key" value="general_register_page"/>

                                    <div class="login_GluuOxd">
                                        <div class="mess_red">
                                            <?php echo $messageConnectProvider; ?>
                                        </div>
                                        <br/>

                                        <div><h3><?php echo $registerMessageConnectProvider; ?></h3></div>
                                        <hr>
                                        <div class="mess_red"><?php echo $linkToGluu; ?></div>
                                        <div class="mess_red"><?php echo $Instructions; ?></div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="loginemail"><b><font
                                                            color="#FF0000">*</font><?php echo $adminEmail; ?>
                                                </b></label>

                                            <div class="col-sm-10"><input type="email" name="loginemail" id="loginemail"
                                                                          autofocus="true" required
                                                                          placeholder="person@example.com"

                                                                          value="<?php echo $admin_email;?>" class="form-control"/></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="loginemail"><b><font
                                                            color="#FF0000">*</font><?php echo $portNumber; ?>
                                                </b></label>

                                            <div class="col-sm-10"><input type="number" name="oxd_port" min="0"
                                                                          max="65535"
                                                                          value="8099"
                                                                          placeholder="<?php echo $EnterportNumber; ?>"
                                                                          class="form-control"/></div>
                                        </div>

                                        <br/>

                                        <div class="form-group">
                                            <label class="col-sm-2 "></label>

                                            <div class="col-sm-10">
                                                <input style="width: 100px;" class="btn btn-success" type="submit" name="submit" value="<?php echo $next; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php } else{ ?>
                            <div class="page" id="accountsetup">
                                <div>
                                    <div>
                                        <div class="about">
                                            <h3 style="color: #45a8ff" class="sc"><img  style=" height: 45px; " src="<?php echo $base_url; ?>image/gluu_icon/ox.png"/>&nbsp; <?php echo $serverConfig; ?></h3>
                                        </div>
                                    </div>
                                    <div class="entry-edit">
                                        <div class="entry-edit-head">
                                            <h4 class="icon-head head-edit-form fieldset-legend">OXD id</h4>
                                        </div>
                                        <div class="fieldset">
                                            <div class="hor-scroll">
                                                <table class="form-list container">
                                                    <tr class="wrapper-trr">
                                                        <td class="value">
                                                            <input style="width: 500px !important;" type="text" name="oxd_id" value="<?php echo $oxd_id; ?>" <?php echo 'disabled' ?> />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo $action; ?>" method="post">
                                    <input type="hidden" name="form_key" value="general_oxd_id_reset"/>
                                    <p><input style="width: 200px; background-color: red !important; cursor: pointer" type="submit" class="btn btn-danger " value="<?php echo $resetConfig; ?>" name="resetButton"/></p>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane <?php if($activ_tab == 'OpenIDConnect'){ echo 'active';} ?>" id="OpenIDConnect">
                            <?php if (!$oxd_id){ ?>
                            <div class="mess_red">
                                <?php echo $OXDConfiguration; ?>
                            </div>
                            <br/>
                            <?php } ?>
                            <div>
                                <form action="<?php echo $action; ?>" method="post"
                                      enctype="multipart/form-data">
                                    <input type="hidden" name="form_key" value="openid_config_page"/>
                                    <div style="float: right">
                                        <input style="width: 100px" type="submit" class="btn btn-success" value="Save" name="set_oxd_config " <?php if (!$oxd_id) echo 'disabled' ?> />
                                        <br/>
                                    </div>
                                    <div>
                                        <div>
                                            <div class="about">
                                                <br/>

                                                <h3 style="color: #00aa00" class="sc"><img style="height: 45px; " src="<?php echo $base_url; ?>image/gluu_icon//gl.png"/> &nbsp; <?php echo $serverConfig; ?>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="entry-edit">
                                            <div class="entry-edit-head" style="background-color: #00aa00 !important;">
                                                <h4 class="icon-head head-edit-form fieldset-legend"><?php echo $allScopes; ?></h4>
                                            </div>
                                            <div class="fieldset">
                                                <div class="hor-scroll">
                                                    <table class="form-list">
                                                        <tr class="wrapper-trr">
                                                            <?php foreach ($get_scopes as $scop) : ?>
                                                            <td class="value">
                                                                <?php if ($scop == 'openid'){ ?>
                                                                <input style="display: block !important;"
                                                                       type="hidden" name="scope[]" value="<?php echo $scop; ?>" <?php if ($oxd_config && in_array($scop, $oxd_config['scope'])) {
                                                            echo " checked "; } ?>  <?php if (!$oxd_id) echo ' disabled ' ?>/>
                                                                <?php } ?>
                                                                <input style="display: block !important;" <?php if (!$oxd_id) echo ' disabled ' ?>
                                                                type="checkbox" name="scope[]"  <?php if ($oxd_config && in_array($scop, $oxd_config['scope'])) {
                                                            echo " checked "; } ?> id="<?php echo $scop; ?>"
                                                                value="<?php echo $scop; ?>" <?php if ($scop == 'openid') echo ' disabled '; ?> />
                                                                <label for="<?php echo $scop; ?>"><?php echo $scop; ?></label>
                                                            </td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    </table>
                                                    <table class="form-list" style="text-align: center">
                                                        <tr class="wrapper-tr" style="text-align: center">
                                                            <th style="border: 1px solid #43ffdf; width: 70px;text-align: center">
                                                                <h3>N</h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $name; ?></h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $delete; ?></h3></th>
                                                        </tr>
                                                        <?php
                                            $n = 0;
                                            foreach ($get_scopes as $scop) {
                                                $n++;
                                                ?>
                                                        <tr class="wrapper-trr">
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 70px">
                                                                <h3><?php echo $n; ?></h3></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <h3>
                                                                    <label for="<?php echo $scop; ?>"><?php echo $scop; ?></label>
                                                                </h3></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <?php if ($n == 1): ?>
                                                                <form></form>
                                                                <?php endif; ?>
                                                                <form
                                                                        action="<?php echo $action; ?>"
                                                                        method="post">
                                                                    <input type="hidden" name="form_key"
                                                                           value="openid_config_delete_scop"/>
                                                                    <input type="hidden"
                                                                           value="<?php echo $scop; ?>"
                                                                           name="value_scope"/>
                                                                    <?php if ($scop != 'openid'){ ?>
                                                                    <input style="width: 100px; background-color: red !important; cursor: pointer"
                                                                           type="submit" value="<?php echo $delete; ?>"
                                                                           name="delete_scop"
                                                                           class="btn btn-danger button button-primary " <?php if (!$oxd_id) echo 'disabled' ?>
                                                                    />
                                                                    <?php } ?>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                            }
                                            ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="entry-edit">
                                            <div class="entry-edit-head" style="background-color: #00aa00 !important;">
                                                <h4 class="icon-head head-edit-form fieldset-legend"><?php echo $addScopes;?></h4>
                                            </div>
                                            <div class="fieldset">
                                                <input type="button" id="adding"
                                                       class="button button-primary button-large add"
                                                       style="width: 100px" value="<?php echo $addScopes;?>"/>

                                                <div class="hor-scroll">
                                                    <table class="form-list5 ">
                                                        <tr class="wrapper-tr">
                                                            <td class="value">
                                                                <input type="text"
                                                                       placeholder="<?php echo $InputScopeName; ?>"
                                                                       name="scope_name[]"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="entry-edit">
                                            <div class="entry-edit-head" style="background-color: #00aa00 !important;">
                                                <h4 class="icon-head head-edit-form fieldset-legend"><?php echo $allCustomScripts; ?></h4>
                                            </div>
                                            <div class="fieldset">
                                                <div class="hor-scroll">
                                                    <?php echo $manageAuthentication;?>
                                                    <table style="width:100%;display: table;">
                                                        <tbody>
                                                        <tr>
                                                            <?php echo $selected_icon; ?>
                                                        </tr>
                                                        <tr style="display: none;">
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="form-list" style="text-align: center">
                                                        <tr class="wrapper-tr" style="text-align: center">
                                                            <th style="border: 1px solid #43ffdf; width: 70px;text-align: center">
                                                                <h3>N</h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $DisplayName; ?></h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $ACRvalue; ?></h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $Image; ?></h3></th>
                                                            <th style="border: 1px solid #43ffdf;width: 200px;text-align: center">
                                                                <h3><?php echo $delete; ?></h3></th>
                                                        </tr>
                                                        <?php
                                            $n = 0;
                                            foreach ($custom_scripts as $custom_script) {
                                                $n++;
                                                ?>
                                                        <tr class="wrapper-trr">
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 70px">
                                                                <h3><?php echo $n; ?></h3></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <h3><?php echo $custom_script['name']; ?></h3></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <h3><?php echo $custom_script['value']; ?></h3></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <img src=" <?php echo $custom_script['image']; ?> "
                                                                     width="40px" height="40px"/></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <?php if ($n == 1): ?>
                                                                <form></form>
                                                                <?php endif; ?>
                                                                <form
                                                                        action="<?php echo $action; ?>"
                                                                        method="post">
                                                                    <input type="hidden" name="form_key"
                                                                           value="openid_config_delete_custom_scripts"/>
                                                                    <input type="hidden"
                                                                           value="<?php echo $custom_script['value']; ?>"
                                                                           name="value_script"/>
                                                                    <input value="Delete" name="delete_config"
                                                                           style="width: 100px; background-color: red !important; cursor: pointer"
                                                                           type="submit"
                                                                           class="btn btn-danger button button-primary " <?php if (!$oxd_id) echo 'disabled' ?>
                                                                    />
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                            }
                                            ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <br/>

                                            <div class="entry-edit-head" style="background-color: #00aa00 !important;">
                                                <h4 class="icon-head head-edit-form fieldset-legend"><?php echo $multipleCustomScripts; ?></h4>
                                                <br/>
                                                <p style="color:#cc0b07; font-style: italic; font-weight: bold;font-size: larger"> <?php echo $BothFields; ?></p>
                                            </div>
                                            <div class="fieldset">
                                                <div class="hor-scroll">
                                                    <input type="hidden" name="count_scripts" value="1"
                                                           id="count_scripts" />
                                                    <input type="button" class="button button-primary button-large "
                                                           style="width: 100px" id="adder" value="Add acr"/>
                                                    <table class="form-list1 ">
                                                        <tr class="count_scripts wrapper-trr">
                                                            <td class="value">
                                                                <input style='width: 200px !important;' type="text" placeholder="<?php echo $exampleGoogle; ?>" name="name_in_site_1"/>
                                                            </td>
                                                            <td class="value">
                                                                <input style='width: 270px !important;' type="text" placeholder="<?php echo $scriptName; ?>" name="name_in_gluu_1"/>
                                                            </td>
                                                            <td class="value">
                                                                <input type="file" accept="image/png" name="images_1"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="tab-pane <?php if($activ_tab == 'OpenCartConfig'){ echo 'active';} ?>" id="OpenCartConfig">
                            <?php if (!$oxd_id){ ?>
                            <div class="mess_red">
                                <?php echo $OXDConfiguration; ?>
                            </div>
                            <br/>
                            <?php } ?>
                            <form id="form-apps" name="form-apps" method="post"
                                  action="<?php echo $action;?>" enctype="multipart/form-data">
                                <input type="hidden" name="form_key" value="opencart_config_page"/>
                                <div class="mo2f_table_layout">
                                    <input  type="submit" name="submit" value="<?php echo $Save; ?>" style="width:100px; float: right" class="btn btn-success" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                </div>
                                <div id="twofactor_list" class="mo2f_table_layout">
                                    <h3><?php echo $GluuLoginConfig; ?> </h3>
                                    <hr>
                                    <p style="font-size:14px"><?php echo $CustomizeYourLogin; ?></p>
                                    <hr>

                                    <h3><?php echo $CustomizeLoginIcons; ?></h3>
                                    <p><?php echo $CustomizeShape; ?></p>
                                    <table style="width:100%;display: table;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b><?php echo $Shape; ?></b>
                                                <b style="margin-left:130px; display: none"><?php echo $Theme; ?></b>
                                                <b style="margin-left:130px;"><?php echo $SpaceBetweenIcons; ?></b>
                                                <b style="margin-left:86px;"><?php echo $SizeofIcons; ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input name="gluuoxd_openid_login_theme" value="circle"
                                                       onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,'circle',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)"
                                                       checked type="radio" "<?php if (!$oxd_id) echo 'disabled'; ?>"
                                                ><?php echo $Round; ?>
                            <span style="margin-left:106px; display: none">
                                <input type="radio" id="gluuoxd_openid_login_default_radio" name="gluuoxd_openid_login_custom_theme" value="default"
                                       onclick="checkLoginButton();gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'default',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)"
                                       checked <?php if (!$oxd_id) echo 'disabled'; ?>
                                ><?php echo $Default; ?>
                            </span>
                            <span style="margin-left:111px;">
                                    <input onkeyup="gluuOxLoginSpaceValidate(this)" id="gluuox_login_icon_space"
                                           name="gluuox_login_icon_space" type="text" value="<?php echo $iconSpace; ?>"
                                           style="width:50px" <?php if (!$oxd_id) echo ' disabled '; ?> />
                                    <input type="button" value="+" onmouseup="document.getElementById('gluuox_login_icon_space').value=parseInt(document.getElementById('gluuox_login_icon_space').value)+1;gluuOxLoginPreview(setSizeOfIcons() ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)"
                                           id="gluuox_login_space_plus" <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> />
                                    <input type="button" value="-" onmouseup="document.getElementById('gluuox_login_icon_space').value=parseInt(document.getElementById('gluuox_login_icon_space').value)-1;gluuOxLoginPreview(setSizeOfIcons()  ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)"
                                           id="gluuox_login_space_minus" <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> />
                            </span>
                            <span id="commontheme" style="margin-left:95px">
                                <input style="width:50px "  id="gluuox_login_icon_size"
                                       onkeyup="gluuOxLoginSizeValidate(this)" name="gluuox_login_icon_custom_size" type="text"
                                       value="<?php if ($iconCustomSize) echo $iconCustomSize; else echo '35'; ?>" <?php if (!$oxd_id) echo "disabled"; ?>>
                                <input id="gluuox_login_size_plus"  type="button" value="+"
                                       onmouseup="document.getElementById('gluuox_login_icon_size').value=parseInt(document.getElementById('gluuox_login_icon_size').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                <input id="gluuox_login_size_minus"  type="button" value="-"
                                       onmouseup="document.getElementById('gluuox_login_icon_size').value=parseInt(document.getElementById('gluuox_login_icon_size').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                            </span>
                            <span style="margin-left: 95px; display: none;" class="longbuttontheme"><?php echo $Width; ?>
                                <input style="width:50px"  id="gluuox_login_icon_width"
                                       onkeyup="gluuOxLoginWidthValidate(this)" name="gluuox_login_icon_custom_width" type="text"
                                       value="<?php echo $iconCustomWidth; ?>" <?php if (!$oxd_id) echo 'disabled'; ?>/>
                                <input id="gluuox_login_width_plus"  type="button" value="+"
                                       onmouseup="document.getElementById('gluuox_login_icon_width').value=parseInt(document.getElementById('gluuox_login_icon_width').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                <input id="gluuox_login_width_minus" type="button" value="-"
                                       onmouseup="document.getElementById('gluuox_login_icon_width').value=parseInt(document.getElementById('gluuox_login_icon_width').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input type="radio" name="gluuoxd_openid_login_theme" value="oval"
                                                       onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value,'oval',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_size').value )"
                                                <?php if ($loginTheme == 'oval') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $RoundedEdges; ?>
                        <span style="margin-left:50px; display: none">
                                <input type="radio" id="gluuoxd_openid_login_custom_radio"
                                       name="gluuoxd_openid_login_custom_theme" value="custom"
                                       onclick="checkLoginButton();gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)"
                            <?php if ($loginCustomTheme == 'custom') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $CustomBackground; ?>
                                </span>
                            <span style="margin-left: 256px; display: none;" class="longbuttontheme"><?php echo $Height; ?>
                            <input style="width:50px"  id="gluuox_login_icon_height"
                                   onkeyup="gluuOxLoginHeightValidate(this)" name="gluuox_login_icon_custom_height" type="text"
                                   value="<?php if ($iconCustomHeight) echo $iconCustomHeight; else echo '35'; ?>" <?php if (!$oxd_id) echo 'disabled'; ?> />
                            <input id="gluuox_login_height_plus"  type="button" value="+"
                                   onmouseup="document.getElementById('gluuox_login_icon_height').value=parseInt(document.getElementById('gluuox_login_icon_height').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                            <input id="gluuox_login_height_minus"  type="button" value="-"
                                   onmouseup="document.getElementById('gluuox_login_icon_height').value=parseInt(document.getElementById('gluuox_login_icon_height').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                        </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input type="radio"
                                                       name="gluuoxd_openid_login_theme" value="square"
                                                       onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,'square',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_size').value )"
                                                <?php if ($loginTheme == 'square') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $Square; ?>
                                    <span style="margin-left:113px; display: none">
                                        <input type="color"
                                               name="gluuox_login_icon_custom_color" id="gluuox_login_icon_custom_color"
                                               value="<?php echo $iconCustomColor; ?>"
                                               onchange="gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?>>
                                    </span>
                                            </td>
                                        </tr>
                                        <tr style="display: none">
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input
                                                        type="radio"
                                                        id="iconwithtext" name="gluuoxd_openid_login_theme" value="longbutton"
                                                        onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,'longbutton',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)"
                                                <?php if ($loginTheme == 'longbutton') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?>/><?php echo $LongButton; ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <h3><?php echo $Preview; ?> </h3>
                                    <span hidden id="no_apps_text"><?php echo $NoApps; ?></span>
                                    <div>
                                        <?php foreach ($custom_scripts as $custom_script): ?>
                                        <img class="gluuox_login_icon_preview"
                                             id="gluuox_login_icon_preview_<?php echo $custom_script['value']; ?>"
                                             src="<?php echo $custom_script['image']; ?>"/>
                                        <?php endforeach; ?>
                                    </div>
                                    <br><br>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="helpTrouble">
                            <?php echo $doocumentation242; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var $m = jQuery;
    $m(document).ready(function () {
        $oxd_id = "<?php echo $oxd_id; ?>";
    });
    function setactive($id) {
        $m(".nav-tabs>li").removeClass("active");
        $m("#minisupport").show();
        $id = '#' + $id;
        $m($id).addClass("active");
    }
    function voiddisplay($href) {
        $m(".page").css("display", "none");
        $m($href).css("display", "block");
    }

    var tempHorSize = '<?php echo $iconCustomSize ?>';
    var tempHorTheme = '<?php echo $loginTheme ?>';
    var tempHorCustomTheme = '<?php echo $loginCustomTheme ?>';
    var tempHorCustomColor = '<?php echo $iconCustomColor ?>';
    var tempHorSpace = '<?php echo $iconSpace ?>';
    var tempHorHeight = '<?php echo $iconCustomHeight ?>';
    gluuOxLoginPreview(setSizeOfIcons(), tempHorTheme, tempHorCustomTheme, tempHorCustomColor, tempHorSpace, tempHorHeight);
    checkLoginButton();

    function setLoginTheme() {
        return jQuery('input[name=gluuoxd_openid_login_theme]:checked', '#form-apps').val();
    }
    function setLoginCustomTheme() {
        return jQuery('input[name=gluuoxd_openid_login_custom_theme]:checked', '#form-apps').val();
    }
    function setSizeOfIcons() {
        if ((jQuery('input[name=gluuoxd_openid_login_theme]:checked', '#form-apps').val()) == 'longbutton') {
            return document.getElementById('gluuox_login_icon_width').value;
        } else {
            return document.getElementById('gluuox_login_icon_size').value;
        }
    }
    function gluuOxLoginPreview(t, r, l, p, n, h) {

        if (l == 'default') {
            if (r == 'longbutton') {
                var a = "btn-defaulttheme";
                jQuery("." + a).css("width", t + "px");
                if (h > 26) {
                    jQuery("." + a).css("height", "26px");
                    jQuery("." + a).css("padding-top", (h - 26) / 2 + "px");
                    jQuery("." + a).css("padding-bottom", (h - 26) / 2 + "px");
                } else {
                    jQuery("." + a).css("height", h + "px");
                    jQuery("." + a).css("padding-top", (h - 26) / 2 + "px");
                    jQuery("." + a).css("padding-bottom", (h - 26) / 2 + "px");
                }
                jQuery(".fa").css("padding-top", (h - 35) + "px");
                jQuery("." + a).css("margin-bottom", n + "px");
            } else {
                var a = "gluuox_login_icon_preview";
                jQuery("." + a).css("margin-left", n + "px");
                if (r == "circle") {
                    jQuery("." + a).css({height: t, width: t});
                    jQuery("." + a).css("borderRadius", "999px");
                } else if (r == "oval") {
                    jQuery("." + a).css("borderRadius", "5px");
                    jQuery("." + a).css({height: t, width: t});
                } else if (r == "square") {
                    jQuery("." + a).css("borderRadius", "0px");
                    jQuery("." + a).css({height: t, width: t});
                }
            }
        }
        else if (l == 'custom') {
            if (r == 'longbutton') {
                var a = "btn-customtheme";
                jQuery("." + a).css("width", (t) + "px");
                if (h > 26) {
                    jQuery("." + a).css("height", "26px");
                    jQuery("." + a).css("padding-top", (h - 26) / 2 + "px");
                    jQuery("." + a).css("padding-bottom", (h - 26) / 2 + "px");
                } else {
                    jQuery("." + a).css("height", h + "px");
                    jQuery("." + a).css("padding-top", (h - 26) / 2 + "px");
                    jQuery("." + a).css("padding-bottom", (h - 26) / 2 + "px");
                }
                jQuery("." + a).css("margin-bottom", n + "px");
                jQuery("." + a).css("background", p);
            } else {
                var a = "gluuOx_custom_login_icon_preview";
                jQuery("." + a).css({height: t - 8, width: t});
                jQuery("." + a).css("padding-top", "8px");
                jQuery("." + a).css("margin-left", n + "px");
                jQuery("." + a).css("background", p);

                if (r == "circle") {
                    jQuery("." + a).css("borderRadius", "999px");
                } else if (r == "oval") {
                    jQuery("." + a).css("borderRadius", "5px");
                } else if (r == "square") {
                    jQuery("." + a).css("borderRadius", "0px");
                }
                jQuery("." + a).css("font-size", (t - 16) + "px");
            }
        }
        previewLoginIcons();
    }
    function checkLoginButton() {
        if (document.getElementById('iconwithtext').checked) {
            if (setLoginCustomTheme() == 'default') {
                jQuery(".gluuox_login_icon_preview").hide();
                jQuery(".gluuOx_custom_login_icon_preview").hide();
                jQuery(".btn-customtheme").hide();
                jQuery(".btn-defaulttheme").show();
            } else if (setLoginCustomTheme() == 'custom') {
                jQuery(".gluuox_login_icon_preview").hide();
                jQuery(".gluuOx_custom_login_icon_preview").hide();
                jQuery(".btn-defaulttheme").hide();
                jQuery(".btn-customtheme").show();
            }
            jQuery("#commontheme").hide();
            jQuery(".longbuttontheme").show();
        }
        else {
            if (setLoginCustomTheme() == 'default') {
                jQuery(".gluuox_login_icon_preview").show();
                jQuery(".btn-defaulttheme").hide();
                jQuery(".btn-customtheme").hide();
                jQuery(".gluuOx_custom_login_icon_preview").hide();
            } else if (setLoginCustomTheme() == 'custom') {
                jQuery(".gluuox_login_icon_preview").hide();
                jQuery(".gluuOx_custom_login_icon_preview").show();
                jQuery(".btn-defaulttheme").hide();
                jQuery(".btn-customtheme").hide();
            }
            jQuery("#commontheme").show();
            jQuery(".longbuttontheme").hide();
        }

        previewLoginIcons();
    }
    function previewLoginIcons() {
        var flag = 0;
    <?php foreach($custom_scripts as $custom_script):?>
        if (document.getElementById('<?php echo $custom_script["value"];?>_enable').checked) {
            flag = 1;
            if (document.getElementById('gluuoxd_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
                jQuery("#gluuox_login_icon_preview_<?php echo $custom_script['value'];?>").show();
            if (document.getElementById('gluuoxd_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
                jQuery("#gluuOx_custom_login_icon_preview_<?php echo $custom_script['value'];?>").show();
            if (document.getElementById('gluuoxd_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
                jQuery("#gluuox_login_button_preview_<?php echo $custom_script['value'];?>").show();
            if (document.getElementById('gluuoxd_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
                jQuery("#gluuOx_custom_login_button_preview_<?php echo $custom_script['value'];?>").show();
        }
        else if (!document.getElementById('<?php echo $custom_script["value"];?>_enable').checked) {
            jQuery("#gluuox_login_icon_preview_<?php echo $custom_script['value'];?>").hide();
            jQuery("#gluuOx_custom_login_icon_preview_<?php echo $custom_script['value'];?>").hide();
            jQuery("#gluuox_login_button_preview_<?php echo $custom_script['value'];?>").hide();
            jQuery("#gluuOx_custom_login_button_preview_<?php echo $custom_script['value'];?>").hide();
        }
    <?php endforeach;?>
        if (flag) {
            jQuery("#no_apps_text").hide();
        } else {
            jQuery("#no_apps_text").show();
        }



    }

    var selectedApps = [];
    function setTheme() {
        return jQuery('input[name=gluuoxd_openid_share_theme]:checked', '#settings_form').val();
    }
    function setCustomTheme() {
        return jQuery('input[name=gluuoxd_openid_share_custom_theme]:checked', '#settings_form').val();
    }
    function gluuOxLoginSizeValidate(e) {
        var t = parseInt(e.value.trim());
        t > 60 ? e.value = 60 : 20 > t && (e.value = 20);
        reloadLoginPreview();
    }
    function gluuOxLoginSpaceValidate(e) {
        var t = parseInt(e.value.trim());
        t > 60 ? e.value = 60 : 0 > t && (e.value = 0);
        reloadLoginPreview();
    }
    function gluuOxLoginWidthValidate(e) {
        var t = parseInt(e.value.trim());
        t > 1000 ? e.value = 1000 : 140 > t && (e.value = 140)
        reloadLoginPreview();
    }
    function gluuOxLoginHeightValidate(e) {
        var t = parseInt(e.value.trim());
        t > 100 ? e.value = 100 : 10 > t && (e.value = 10)
        reloadLoginPreview();
    }
    function reloadLoginPreview() {
        if (setLoginTheme() == 'longbutton')
            gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value, setLoginTheme(), setLoginCustomTheme(), document.getElementById('gluuox_login_icon_custom_color').value, document.getElementById('gluuox_login_icon_space').value,
                    document.getElementById('gluuox_login_icon_height').value);
        else
            gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value, setLoginTheme(), setLoginCustomTheme(), document.getElementById('gluuox_login_icon_custom_color').value, document.getElementById('gluuox_login_icon_space').value);
    }

    jQuery('#adding').click(function() {
        var wrapper = "<tr class='wrapper-tr'>" +
                "<td class='value'><input type='text' placeholder='<?php echo $InputScopeName; ?>' name='scope_name[]'></td>" +
                "<td class='value'><button class='remove'>Remove</button></td>" +
                "</tr>";
        jQuery(wrapper).find('.remove').on('click', function() {
            jQuery(this).parent('.wrapper-tr').remove();
        });
        jQuery(wrapper).appendTo('.form-list5');
    });
    jQuery('.form-list5').on('click', 'button.remove', function() {
        if (jQuery('.wrapper-tr').length > 1) {
            jQuery(this).parents('.wrapper-tr').remove();
        } else {
            alert('at least one image need to be selected');
        }
    });

    var j = jQuery('.count_scripts').length + 1;
    var d = jQuery('.count_scripts').length + 1;
    jQuery('#adder').click(function() {
        var wrapperer = "<tr class='count_scopes wrapper-trr'>" +
                "<td  class='value'><input style='width: 200px !important;' placeholder='<?php echo $exampleGoogle; ?>' type='text' name='name_in_site_"+j+"'></td>" +
                "<td  class='value'><input style='width: 270px !important;' placeholder='<?php echo $scriptName; ?>' type='text' name='name_in_gluu_"+j+"'></td>" +
                "<td class='value'><input type='file' accept='image/png' name='images_"+j+"'></td>" +
                "<td class='value'><button class='removeer'>Remove</button></td>" +
                "</tr>";
        jQuery(wrapperer).find('.removeer').on('click', function() {
            jQuery(this).parent('.wrapper-trr').remove();

        });
        jQuery('#count_scripts').val(d);
        j++;
        d++;

        jQuery(wrapperer).appendTo('.form-list1');

    });
    jQuery('.form-list1').on('click', 'button.removeer', function() {
        if (j > 2) {
            jQuery(this).parents('.wrapper-trr').remove();
            j--;
        }
    });

    jQuery("#show_script_table").click(function(){
        jQuery("#custom_script_table").toggle();
    });
</script>
<?php echo $footer; ?>