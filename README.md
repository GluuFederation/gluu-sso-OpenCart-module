Opencart OpenID Connect Single Sign-On (SSO) Extension by Gluu 
=========================
![image](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/plugin.jpg)

OpenID Connect Single Sign-On (SSO) Extension by Gluu gives access for login to your OpenCart site, with the help of Gluu server.

For example if you are using OpenID Connect Single Sign-On (SSO) Extension by Gluu-2.4.4 module, you need to connect with oxd-server-2.4.4.

Now I want to explain in details how to use extension step by step. 

Module will not be working if your host does not have https://. 

## Step 1. Install Gluu-server 

(version 2.4.4)

If you want to use external gluu server, You can not do this step.   

[Gluu-server installation gide](https://www.gluu.org/docs/deployment/).

## Step 2. Download oxd-server 

[Download oxD-server-2.4.4.Final](https://ox.gluu.org/maven/org/xdi/oxd-server/2.4.4.Final/oxd-server-2.4.4.Final-distribution.zip).

## Step 3. Unzip and run oxd-server
 
1. Unzip your oxd-server. 
2. Open the command line and navigate to the extracted folder in the conf directory.
3. Open oxd-conf.json file.  
4. If your server is using 8099 port, please change "port" number to free port, which is not used.
5. Open the command line and navigate to the extracted folder in the bin directory.
6. For Linux environment, run sh oxd-start.sh&. 
7. For Windows environment, run oxd-start.bat.
8. After the server starts, go to Step 4.

[Oxd-server installation gide](https://oxd.gluu.org/docs/oxdserver/install/)

## Step 4. Download OpenID Connect Single Sign-On (SSO) Extension by Gluu

[Link to Opencart marketplace] (http://www.opencart.com/index.php?route=extension/extension/info&extension_id=27180&filter_search=gluu)
 
[Download OpenID Connect Single Sign-On (SSO) Extension by Gluu 2.4.4](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/Gluu_SSO_2.4.4/Gluu_SSO_2.4.4.zip).

## Step 5. Install module
 
1. Open menu tab Extensions / Extension Installer and click on ```Upload``` button

2. Choose downloaded module and click on ```Continue``` button. 
![Manager](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/1.png) 

3. Open menu tab Extensions / Modules and find OpenID Connect Single Sign-On (SSO) Extension by Gluu 2.4.4 click on ```Install``` button, than click on ```Edit``` button.
![Manager](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/2.png) 

## Step 6. General

![Scopes1](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/15.png) 

1. Admin Email: please add your or admin email address for registrating site in Gluu server.
2. Gluu Server URL: please add your Gluu server URL.
3. Oxd port in your server: choose that port which is using oxd-server (see in oxd-server/conf/oxd-conf.json file).
4. Click next to continue.

If You are successfully registered in gluu server, you will see bottom page.

![oxD_id](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/7.png)

For making sure go to your gluu server / OpenID Connect / Clients and search for your oxd ID

If you want to reset configurations click on Reset configurations button.

## Step 7. OpenID Connect Configuration

### Scopes.
You can look all scopes in your gluu server / OpenID Connect / Scopes and understand the meaning of  every scope.
Scopes are need for getting loged in users information from gluu server.
Pay attention to that, which scopes you are using that are switched on in your gluu server.

In OpenID Connect Single Sign-On (SSO) Extension by Gluu 2.4.4 you can enable, disable and delete scope, but also add new scope, but when you add new scope by {any name}, necessary to add that scope in your gluu server too. 
![Scopes2](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/9.png) 

### Custom scripts.

![Customscripts](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/10.png)  

You can look all custom scripts in your gluu server / Configuration / Manage Custom Scripts / and enable login type, which type you want.
Custom Script represent itself the type of login, at this moment gluu server supports (U2F, Duo, Google +, Basic, OxPush2) types.

### Pay attention to that.

1. Which custom script you enable in your OpenCart site in order it must be switched on in gluu server too.
2. Which custom script you will be enable in OpenID Connect Configuration page, after saving that will be showed in OpenCart Configuration page too.
3. When you create new custom script, both fields are required.

## Step 8. OpenCart Configuration

### Customize Login Icons
 
Pay attention to that, if custom scripts are not enabled, nothing will be showed.
Customize shape, space between icons and size of the login icons.

![OpenCartConfiguration](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/11.png)  

## Step 9. Show icons in frontend

![frontend](https://raw.githubusercontent.com/GluuFederation/gluu-sso-OpenCart-module/master/docu/12.png) 
