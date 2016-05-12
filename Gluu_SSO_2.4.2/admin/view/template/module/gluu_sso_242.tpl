<?php echo $header; ?>

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
                <div  id="form-socl-login" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-General" data-toggle="tab"><?php echo $General; ?></a></li>
                        <li><a href="#tab-OpenIDConnect" data-toggle="tab"><?php echo $OpenIDConnect; ?></a></li>
                        <li><a href="#tab-OpenCartConfig" data-toggle="tab"><?php echo $OpenCartConfig; ?></a></li>
                        <li><a href="#tab-helpTrouble" data-toggle="tab"><?php echo $helpTrouble; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-General">
                            <?php if (!$oxd_id){ ?>
                            <div class="mo2f_table_layout">
                                <form id="register_GluuOxd" name="f" method="post" action="<?php echo $action; ?>">
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
                                            <label class="col-sm-2 control-label" for="loginemail"><b><font color="#FF0000">*</font><?php echo $adminEmail; ?></b></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="loginemail" id="loginemail" autofocus="true" required placeholder="person@example.com" value="<?php echo $admin_email;?>" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="loginemail"><b><font color="#FF0000">*</font><?php echo $portNumber; ?> </b></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="oxd_port" min="0" max="65535" value="8099" placeholder="<?php echo $EnterportNumber; ?>" class="form-control"/>
                                            </div>
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
                                            <h3 style="color: #45a8ff" class="sc"><img  style=" height: 45px; margin-left: 20px;" src="view/image/gluu_sso_242/ox.png"/>&nbsp;<?php echo $serverConfig; ?></h3>
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
                                    <p><input style="width: 200px; background-color: red !important; cursor: pointer" type="submit" class="btn btn-danger " value="<?php echo $resetConfig;?>" name="resetButton"/></p>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="tab-OpenIDConnect">
                            <?php if (!$oxd_id){ ?>
                            <div class="mess_red">
                                <?php echo $OXDConfiguration;?>
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
                                                <h3 style="color: #00aa00" class="sc"><img style="height: 45px; " src="view/image/gluu_sso_242/gl.png"/> &nbsp; <?php echo $serverConfig; ?></h3>
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
                                                                <input style="display: block !important;" type="hidden" name="scope[]" value="<?php echo $scop; ?>" <?php if ($oxd_config && in_array($scop, $oxd_config['scope'])) {
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
                                                                <form action="<?php echo $action; ?>" method="post">
                                                                    <input type="hidden" name="form_key" value="openid_config_delete_scop"/>
                                                                    <input type="hidden" value="<?php echo $scop; ?>" name="value_scope"/>
                                                                    <?php if ($scop != 'openid'){ ?>
                                                                    <input style="width: 100px; background-color: red !important; cursor: pointer" type="submit" value="<?php echo $delete; ?>" name="delete_scop" class="btn btn-danger button button-primary " <?php if (!$oxd_id) echo 'disabled' ?>
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
                                                <h4 class="icon-head head-edit-form fieldset-legend"><?php echo $addScopes; ?></h4>
                                            </div>
                                            <div class="fieldset">
                                                <input type="button" id="adding" class="button button-primary button-large add" style="width: 100px" value="<?php echo $addScopes; ?>"/>
                                                <div class="hor-scroll">
                                                    <table class="form-list5 ">
                                                        <tr class="wrapper-tr">
                                                            <td class="value">
                                                                <input type="text" placeholder="<?php echo $InputScopeName; ?>" name="scope_name[]"/>
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
                                                                <img src="<?php echo $custom_script['image']; ?>" width="40px" height="40px"/></td>
                                                            <td style="border: 1px solid #43ffdf; padding: 0px; width: 200px">
                                                                <?php if ($n == 1): ?>
                                                                <form></form>
                                                                <?php endif; ?>
                                                                <form action="<?php echo $action; ?>" method="post">
                                                                    <input type="hidden" name="form_key" value="openid_config_delete_custom_scripts"/>
                                                                    <input type="hidden" value="<?php echo $custom_script['value']; ?>" name="value_script"/>
                                                                    <input value="Delete" name="delete_config" style="width: 100px; background-color: red !important; cursor: pointer" type="submit" class="btn btn-danger button button-primary " <?php if (!$oxd_id) echo 'disabled' ?>/>
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
                                                <p style="color:#cc0b07; font-style: italic; font-weight: bold;font-size: larger"><?php echo $BothFields; ?></p>
                                            </div>
                                            <div class="fieldset">
                                                <div class="hor-scroll">
                                                    <input type="hidden" name="count_scripts" value="1" id="count_scripts" />
                                                    <input type="button" class="button button-primary button-large " style="width: 100px" id="adder" value="<?php echo $Addacr; ?>"/>
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
                        <div class="tab-pane" id="tab-OpenCartConfig">
                            <?php if (!$oxd_id){ ?>
                            <div class="mess_red">
                                <?php echo $OXDConfiguration; ?>
                            </div>
                            <br/>
                            <?php } ?>
                            <form id="form-apps" name="form-apps" method="post" action="<?php echo $action;?>" enctype="multipart/form-data">
                                <input type="hidden" name="form_key" value="opencart_config_page"/>
                                <div class="mo2f_table_layout">
                                    <input  type="submit" name="submit" value="Save" style="width:100px; float: right" class="btn btn-success" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                </div>
                                <div id="twofactor_list" class="mo2f_table_layout">
                                    <h3><?php echo $GluuLoginConfig;?></h3>
                                    <hr>
                                    <p style="font-size:14px"><?php echo $CustomizeYourLogin;?></p>
                                    <hr>

                                    <h3><?php echo $CustomizeLoginIcons;?></h3>
                                    <p><?php echo $CustomizeShape;?></p>
                                    <table style="width:100%;display: table;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b><?php echo $Shape;?></b>
                                                <b style="margin-left:130px; display: none"><?php echo $Theme;?></b>
                                                <b style="margin-left:130px;"><?php echo $SpaceBetweenIcons;?></b>
                                                <b style="margin-left:86px;"><?php echo $SizeofIcons;?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input name="gluuoxd_openid_login_theme" value="circle" onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,'circle',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" checked type="radio" "<?php if (!$oxd_id) echo 'disabled'; ?>" /><?php echo $Round;?>
                                                <span style="margin-left:106px; display: none">
                                                    <input type="radio" id="gluuoxd_openid_login_default_radio" name="gluuoxd_openid_login_custom_theme" value="default" onclick="checkLoginButton();gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'default',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" checked <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $default;?>
                                                </span>
                                                <span style="margin-left:111px;">
                                                        <input onkeyup="gluuOxLoginSpaceValidate(this)" id="gluuox_login_icon_space" name="gluuox_login_icon_space" type="text" value="<?php echo $iconSpace; ?>" style="width:50px" <?php if (!$oxd_id) echo ' disabled '; ?> />
                                                        <input type="button" value="+" onmouseup="document.getElementById('gluuox_login_icon_space').value=parseInt(document.getElementById('gluuox_login_icon_space').value)+1;gluuOxLoginPreview(setSizeOfIcons() ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" id="gluuox_login_space_plus" <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                        <input type="button" value="-" onmouseup="document.getElementById('gluuox_login_icon_space').value=parseInt(document.getElementById('gluuox_login_icon_space').value)-1;gluuOxLoginPreview(setSizeOfIcons()  ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" id="gluuox_login_space_minus" <?php if (!$oxd_id) echo 'disabled'; ?> <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                </span>
                                                <span id="commontheme" style="margin-left:95px">
                                                    <input style="width:50px "  id="gluuox_login_icon_size" onkeyup="gluuOxLoginSizeValidate(this)" name="gluuox_login_icon_custom_size" type="text" value="<?php if ($iconCustomSize) echo $iconCustomSize; else echo '35'; ?>" <?php if (!$oxd_id) echo "disabled"; ?>>
                                                    <input id="gluuox_login_size_plus"  type="button" value="+" onmouseup="document.getElementById('gluuox_login_icon_size').value=parseInt(document.getElementById('gluuox_login_icon_size').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                    <input id="gluuox_login_size_minus"  type="button" value="-" onmouseup="document.getElementById('gluuox_login_icon_size').value=parseInt(document.getElementById('gluuox_login_icon_size').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                </span>
                                                <span style="margin-left: 95px; display: none;" class="longbuttontheme"><?php echo $Width;?>
                                <input style="width:50px"  id="gluuox_login_icon_width" onkeyup="gluuOxLoginWidthValidate(this)" name="gluuox_login_icon_custom_width" type="text" value="<?php echo $iconCustomWidth; ?>" <?php if (!$oxd_id) echo 'disabled'; ?>/>
                                <input id="gluuox_login_width_plus"  type="button" value="+" onmouseup="document.getElementById('gluuox_login_icon_width').value=parseInt(document.getElementById('gluuox_login_icon_width').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                <input id="gluuox_login_width_minus" type="button" value="-" onmouseup="document.getElementById('gluuox_login_icon_width').value=parseInt(document.getElementById('gluuox_login_icon_width').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input type="radio" name="gluuoxd_openid_login_theme" value="oval" onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value,'oval',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_size').value )" <?php if ($loginTheme == 'oval') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $RoundedEdges;?>
                                                <span style="margin-left:50px; display: none">
                                                    <input type="radio" id="gluuoxd_openid_login_custom_radio" name="gluuoxd_openid_login_custom_theme" value="custom" onclick="checkLoginButton();gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if ($loginCustomTheme == 'custom') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $CustomBackground;?>
                                                </span>
                                                <span style="margin-left: 256px; display: none;" class="longbuttontheme"><?php echo $Height;?>
                                                    <input style="width:50px"  id="gluuox_login_icon_height" onkeyup="gluuOxLoginHeightValidate(this)" name="gluuox_login_icon_custom_height" type="text" value="<?php if ($iconCustomHeight) echo $iconCustomHeight; else echo '35'; ?>" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                    <input id="gluuox_login_height_plus"  type="button" value="+" onmouseup="document.getElementById('gluuox_login_icon_height').value=parseInt(document.getElementById('gluuox_login_icon_height').value)+1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                    <input id="gluuox_login_height_minus"  type="button" value="-" onmouseup="document.getElementById('gluuox_login_icon_height').value=parseInt(document.getElementById('gluuox_login_icon_height').value)-1;gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if (!$oxd_id) echo 'disabled'; ?> />
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input type="radio" name="gluuoxd_openid_login_theme" value="square" onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_size').value ,'square',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_size').value )" <?php if ($loginTheme == 'square') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?> /><?php echo $Square;?>
                                                <span style="margin-left:113px; display: none">
                                                    <input type="color" name="gluuox_login_icon_custom_color" id="gluuox_login_icon_custom_color" value="<?php echo $iconCustomColor; ?>" onchange="gluuOxLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value)" <?php if (!$oxd_id) echo 'disabled'; ?>>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr style="display: none">
                                            <td class="gluuoxd_openid_table_td_checkbox">
                                                <input type="radio" id="iconwithtext" name="gluuoxd_openid_login_theme" value="longbutton" onclick="checkLoginButton();gluuOxLoginPreview(document.getElementById('gluuox_login_icon_width').value ,'longbutton',setLoginCustomTheme(),document.getElementById('gluuox_login_icon_custom_color').value,document.getElementById('gluuox_login_icon_space').value,document.getElementById('gluuox_login_icon_height').value)" <?php if ($loginTheme == 'longbutton') echo "checked"; ?> <?php if (!$oxd_id) echo 'disabled'; ?>/><?php echo $LongButton;?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <h3><?php echo $Preview;?> </h3>
                                    <span hidden id="no_apps_text"><?php echo $NoApps;?></span>
                                    <div>
                                        <?php foreach ($custom_scripts as $custom_script): ?>
                                        <img class="gluuox_login_icon_preview" id="gluuox_login_icon_preview_<?php echo $custom_script['value']; ?>" src="<?php echo $custom_script['image']; ?>"/>
                                        <?php endforeach; ?>
                                    </div>
                                    <br><br>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="tab-helpTrouble">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>