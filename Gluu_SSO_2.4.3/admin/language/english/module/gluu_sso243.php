<?php

// Heading
$_['heading_title'] = 'Gluu SSO 2.4.3';

// Text
$_['text_module'] = 'Module';
$_['text_edit'] = 'Edit Gluu SSO 2.4.3 Module';

$_['gluu_sso'] = 'Gluu SSO 2.4.3';
$_['General'] = 'General';
$_['OpenIDConnect'] = 'OpenID Connect Configuration';
$_['OpenCartConfig'] = 'OpenCart Configuration';
$_['helpTrouble'] = 'Help & Troubleshooting';
$_['messageConnectProvider'] = 'Please enter the details of your OpenID Connect Provider.';
$_['messageSiteRegisteredSuccessful'] = 'Site registered Successful. You can configure Gluu and Social Login now.';
$_['messageScopeDeletedSuccessful'] = 'Scope deleted Successfully.';
$_['messageConfigurationsDeletedSuccessful'] = 'Configurations deleted Successfully.';
$_['messageScriptDeletedSuccessful'] = 'Custom script deleted Successfully.';
$_['messageYourConfiguration'] = 'Your configuration has been saved.';
$_['messageOpenIDConnectConfiguration'] = 'Your OpenID connect configuration has been saved.';
$_['messageSorryUploading'] = 'Sorry, there was an error uploading ';
$_['messageSwitchedOn'] = 'Sorry, but oxd server is not switched on!';
$_['problemImapConnection'] = 'Problem with imap connection, please look your imapData in your gluu server scopes.';
$_['necessaryToFill'] = 'Necessary to fill the hole row.';
$_['file_text'] = 'file';
$_['registerMessageConnectProvider'] = 'Register your site with an OpenID Connect Provider';

$_['linkToGluu'] = 'If you do not have an OpenID Connect provider, you may want to look at the Gluu Server (
                                    <a target="_blank" href="http://www.gluu.org/docs">Like OpenCart, there is a free open source Community Edition. For more information about Gluu Server support please visit <a target="_blank" href="http://www.gluu.org">our website.</a></a>)';

$_['Instructions'] = '<br/><h3>Instructions to Install oxd server</h3>
                                    <br><b>NOTE:</b> The oxd server should be installed on the same server as your OpenCart site. It is recommended that the oxd server listen only on the localhost interface, so only your local applications can reach its API"s.
                                    <ol style="list-style:decimal !important; margin: 30px">
                                        <li>Extract and copy in your DMZ Server.</li>
                                        <li>Download the latest oxd-server package for Centos or Ubuntu. See
                                            <a target="_blank" href="http://gluu.org/docs-oxd">oxd docs</a> for more info.
                                        </li><li>If you are installing an .rpm or .deb, make sure you have Java in your server.
                                        </li><li>Edit <b>oxd-conf.json</b> in the <b>conf</b> directory to specify the port on which
                                            it will run, and specify the hostname of the OpenID Connect provider.</li>
                                        <li>Open the command line and navigate to the extracted folder in the <b>bin</b> directory.</li>
                                        <li>For Linux environment, run <b>sh oxd-start.sh &amp;</b></li>
                                        <li>For Windows environment, run <b>oxd-start.bat</b></li>
                                        <li>After the server starts, set the port number and your email in this page and click Next.</li>
                                    </ol>';
$_['adminEmail'] = 'Admin Email:';
$_['hederGluu'] = 'Use OpenID Connect to login by leveraging the oxd client service demon.';
$_['portNumber'] = 'Port number:';
$_['Addacr'] = 'Add acr';
$_['Save'] = 'Save';
$_['EnterportNumber'] = 'Enter port number.';
$_['InputScopeName'] = 'Input scope name';
$_['exampleGoogle'] = 'Display name (example Google+)';
$_['scriptName'] = 'ACR Value (script name in the Gluu Server)';
$_['next'] = 'Next';
$_['resetConfig'] = 'Reset configurations';
$_['allScopes'] = 'All Scopes';
$_['name'] = 'Name';
$_['or'] = 'or';
$_['isExist'] = 'is exist.';
$_['delete'] = 'Delete';
$_['addScopes'] = 'Add scopes';
$_['DisplayName'] = 'Display Name';
$_['ACRvalue'] = 'ACR Value';
$_['Image'] = 'Image';
$_['multipleCustomScripts'] = 'Add multiple custom scripts';
$_['allCustomScripts'] = 'All custom scripts';
$_['BothFields'] = 'Both fields are required';
$_['OXDConfiguration'] = 'Please enter OXD configuration to continue.';
$_['GluuLoginConfig'] = 'Gluu login config ';
$_['Theme '] = 'Theme ';
$_['serverConfig '] = 'server config ';
$_['Round'] = 'Round ';
$_['Square'] = 'Square ';
$_['NoApps'] = 'No apps selected ';
$_['LongButton '] = 'Long Button with Text ';
$_['CustomBackground'] = 'Custom Background* ';
$_['RoundedEdges'] = 'Rounded Edges ';
$_['Width'] = 'Width:&nbsp; ';
$_['SpaceBetweenIcons'] = 'Space between Icons ';
$_['SizeofIcons'] = 'Size of Icons';
$_['Shape'] = 'Shape';
$_['Height'] = 'Height:';
$_['Default'] = 'Default:';
$_['Preview'] = 'Preview :';
$_['CustomizeLoginIcons'] = 'Customize Login Icons';
$_['CustomizeShape'] = 'Customize shape, theme and size of the login icons';
$_['CustomizeYourLogin'] = 'Customize your login icons using a range of shapes and sizes. You can choose different places to display these icons and also customize redirect url after login.';

$_['manageAuthentication'] = '<h3>Manage Authentication</h3>
                                        <p>An OpenID Connect Provider (OP) like the Gluu Server may provide many different work flows for
                                            authentication. For example, an OP may offer password authentication, token authentication, social
                                            authentication, biometric authentication, and other different mechanisms. Offering a lot of different
                                            types of authentication enables an OP to offer the most convenient, secure, and affordable option to
                                            identify a person, depending on the need to mitigate risk, and the sensors and inputs available on the
                                            device that the person is using.
                                        </p>
                                        <p>
                                            The OP enables a client (like a OpenCart site), to signal which type of authentication should be
                                            used. The client can register a
                                            <a target="_blank" href="http://openid.net/specs/openid-connect-registration-1_0.html#ClientMetadata">default_acr_value</a>
                                            or during the authentication process, a client may request a specific type of authentication using the
                                            <a target="_blank" href="http://openid.net/specs/openid-connect-core-1_0.html#AuthRequest">acr_values</a> parameter.
                                            This is the mechanism that the Gluu SSO module uses: each login icon corresponds to a acr request value.
                                            For example, and acr may tell the OpenID Connect to use Facebook, Google or even plain old password authentication.
                                            The nice thing about this approach is that your applications (like OpenCart) don"t have
                                            to implement the business logic for social login--it"s handled by the OpenID Connect Provider.
                                        </p>
                                        <p>If you are using the Gluu Server as your OP, youll notice that in the Manage Custom Scripts
                                            tab of oxTrust (the Gluu Server admin interface), each authentication script has a name.
                                            This name corresponds to the acr value.  The default acr for password authentication is set in
                                            the
                                            <a target="_blank" href="https://www.gluu.org/docs/admin-guide/configuration/#manage-authentication">LDAP Authentication</a>,
                                            section--look for the "Name" field. Likewise, each custom script has a "Name", for example see the
                                            <a target="_blank" href="https://www.gluu.org/docs/admin-guide/configuration/#manage-custom-scripts">Manage Custom Scripts</a> section.
                                        </p>';

$_['doocumentation242'] = '';

?>