<?php
if($script_logged){
echo $script_logged;
}

if ( ! $user_is_logged)
{
$html = '';
if($oxd_id){
$html.='<style>
.gluuox_login_icon_preview{
width:35px;
cursor:pointer;
display:inline;
}
.customer-account-login .page-title{
margin-top: -100px !important;
}
</style>';



if($loginTheme!='longbutton') {

    $html.='<style>.gluuOx_custom_login_icon_preview{cursor:pointer;}</style>';
if($loginTheme=='circle'){
$html.='<style> .gluuox_login_icon_preview, .gluuOx_custom_login_icon_preview{border-radius: 999px !important;}</style>';
} else if($loginTheme=='oval'){
$html.='<style> .gluuox_login_icon_preview, .gluuOx_custom_login_icon_preview{border-radius: 5px !important;}</style>';
}

if($loginCustomTheme!='custom') {
$html.='<div>';

    foreach($enableds as $enabled){
    if($enabled['enable']){
    $cl = "socialLogin('".$enabled['value']."')";
    $html.='<img class="gluuox_login_icon_preview" id="gluuox_login_icon_preview_'.$enabled['value'].'" src="'.$enabled['image'].'"
                 style="margin-left: '.$iconSpace.'px;  height:'.$iconCustomSize.'px; width:'.$iconCustomSize.'px;" onclick="'.$cl.'"  />';

    }
    }
    $html.='</div>
<br/>';
}
}
$html.="<br>
<script>


    function socialLogin(appName){
        window.location.href ='$base_url'+'index.php?app_name='+appName+'&route=module/gluu_sso242';
    }
</script>";
}
echo $html;
}
?>