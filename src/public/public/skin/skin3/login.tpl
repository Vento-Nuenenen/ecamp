<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
		
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />       
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/layout.css" />
        
		<style>
			
			table
			{ 	font-size:13px;	}	
			font.title
			{	font-size: 25px;	}
			div.menu
			{	width: 180px;
				background-color: #2288ff;
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
				position: relative;
				top: 30px;
				text-align: left;
			}
			a.menu
			{	color: #000000;	
				text-decoration: none;	}
			table.Login
			{
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
			}
			
			body{ text-align:center; } 
			
			
			.message, .register, .login, .browser
			{
				width:380px;
				padding: 10px;
				margin-bottom:20px;
			}
			
			table.support td
			{
				vertical-align: middle;
			}
			
			/*
			.browser
			{
				width:280px;
				padding:10px;
				margin-bottom:20px;
				background-color:white;
			}
			*/
			
			.hidden
			{
				display: none;
			}
			
			input[type=text], input[type=password]
			{
				width: 100%;
			}
		</style>
	
		<script type="text/javascript" language="javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin3/js/login.js"></script>
	</head>
	
	
	<body marginheight="100" marginwidth="0" class="bgcolor ">
	<center>	
        <div class="message bgcolor_content content_border_fit" tal:condition="SHOW_MSG" >
          <span tal:content="structure MSG">TEXT...</span>
        </div>
        
        <div class="login bgcolor_content content_border_fit">
        	<form action="login.php" method="post">
                <table width="80%">
                    <tr><td colspan="2"><font class="title">eCamp - Login</font></td></tr>
                    <tr height="10"><td> </td></tr>
                    <tr><td>E-Mail:</td><td><input tabindex="1" name="Login" type="text" id="Login" /></td></tr>
                    <tr><td>Passwort:</td><td><input tabindex="2" name="Passwort" type="password" /></td></tr>
					
					<tr>
						<td align="right"><input type="checkbox" name="autologin" id="autologin" /></td>
						<td><label for="autologin">Beim nächsten Besuch von eCamp automatisch an mich erinnern.</label></td>
					</tr>
					
                    <tr><td colspan="2" align="right"><input tabindex="3" type="submit" value="Login" /></td></tr>
                    <tr><td> </td></tr>
                </table>
                <input name="Form" value="Login" type="hidden" />
            </form>
        </div>
        
        <div class="register bgcolor_content content_border_fit">
        	Du hast noch kein Login? <a href="register.php" ><b>Registrieren</b></a><br /><br />
            <a href="reminder.php" ><b>Passwort vergessen?</b></a>
        </div>
        
        
    
	</center>
	</body>
</html>
