<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="date=no">
<meta name="format-detection" content="address=no">
<meta name="format-detection" content="email=no">
<title></title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
<style type="text/css">
/**
 * BlauMail 
 * oroian.ro/responsive-newsletter
 * Last Modified: 11/11/2015 **/
/* Reset */
body {
  Margin: 0;
  padding: 0;
  min-width: 100%;
}
a, #outlook a {
  display: inline-block;
}
a, a span {
  text-decoration: none;
}
img {
  line-height: 1;
  mso-line-height-rule: exactly;
  outline: none;
  border: 0;
  text-decoration: none;
  -ms-interpolation-mode: bicubic;
}
table {
  border-spacing: 0;
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
}
td {
  padding: 0;
}
/* Email preview text */
.email_summary {
  display: none !important;
  font-size: 0 !important;
  max-height: 0 !important;
  line-height: 0 !important;
  mso-line-height-rule: exactly;
  padding: 0 !important;
  mso-hide: all;
  overflow: hidden !important;
  float: none !important;
  width: 0 !important;
  height: 0 !important;
}
/* Typography */
.font_default, h1, h2, h3, h4, h5, h6, p, a {
  font-family: Helvetica, Arial, sans-serif;  /* fallback font */
}
small {
  font-size: 100%;
}
p {
  font-size: 16px;
  line-height: 23px;
  Margin-top: 16px;
  Margin-bottom: 24px;
}
h1, h2, h3, h4, h5 {
  Margin-left: 0;
  Margin-right: 0;
  padding: 0;
}
h1, h2, h4, strong {
  font-weight: bold;
}
h1 {
  font-size: 32px;
  line-height: 40px;
  Margin-top: 0;
  Margin-bottom: 8px;
}
h2 {
  font-size: 22px;
  line-height: 30px;
  Margin-top: 8px;
  Margin-bottom: 8px;
}
h3 {
  font-weight: normal;
  font-size: 19px;
  line-height: 28px;
  Margin-top: 10px;
  Margin-bottom: 10px;
}
h4 {
  font-weight: bold;
  font-size: 19px;
  line-height: 28px;
  Margin-top: 16px;
  Margin-bottom: 8px;
}
h5 {
  font-size: 16px;
  line-height: 23px;
  font-weight: 400;
  Margin-top: 8px;
  Margin-bottom: 8px;
}
h6 {
  font-weight: bold;
  font-size: 42px;
  line-height: 48px;
  Margin-top: 0;
  Margin-bottom: 16px;
}
h6 small {
  font-size: 19px;
  font-weight: normal;
  line-height: 1;
}
/* Container */
.email_body {
  Margin: 0;
  padding: 0;
}
.email_body_cell {
  padding: 16px 8px;
  text-align: center;
  vertical-align: top;
  font-size: 0;
}
.container_outer {
  vertical-align: top;
  max-width: 584px;
  Margin: 0 auto;
}
.container {
  Margin: 0 auto;
  vertical-align: top;
  -webkit-border-radius: 4px;
  border-radius: 4px;
  overflow: hidden;
  background-color: #ffffff;
}
.header_cell, .jumbotron_native_cell, .jumbotron_small_cell, .jumbotron_native_small_cell, .jumbotron_button_cell, .jumbotron_button_native_cell, .content_cell, .content_image, .column {
  vertical-align: top;
}
.one_third, .two_thirds, .one_half {
  display: inline-block;
  width: 100%;
  vertical-align: top;
  text-align: left;
}
.one_third {
  max-width: 184px;
}
.two_thirds {
  max-width: 368px;
}
.one_half {
  max-width: 276px;
}
.column_cell {
  vertical-align: top;
  text-align: center;
  padding: 32px 16px;
}
.header_cell .column_cell, .jumbotron_small_cell .column_cell, .jumbotron_native_small_cell .column_cell, .content_article .column_cell, .content_article_alt .column_cell {
  padding: 8px 16px;
}
.header_cell, .content_cell, .content_image_cell  {
  font-size: 0;
  text-align: center;
  padding: 0 16px;
}
.content_image_cell {
  padding: 0;
}
.jumbotron_small_cell, .jumbotron_native_small_cell {
  font-size: 0;
  text-align: center;
  padding: 24px 16px;
}
.content_article .content_cell , .content_article_alt .content_cell {
  padding: 24px 16px;
}
/* Header */
.header_cell {
  padding: 24px 16px;
  -webkit-border-radius: 4px 4px 0 0;
  border-radius: 4px 4px 0 0;
  text-align: left;
  vertical-align: top;
}
.logo_cell {
  text-align: left;
  vertical-align: top;
}
.tagline_cell {
  text-align: left;
  vertical-align: top;
  font-size: 16px;
}
/* Footer */
.footer_cell {
  padding: 16px 32px 8px;
}
/* Jumbotron */
.jumbotron_cell {
  vertical-align: middle;
  background-position: 0 0;
  background-size: 100% auto;
  background-repeat: no-repeat;
  padding: 32px;
  height: 224px
}
/* Jumbotron Native */
.jumbotron_native_cell {
  text-align: center;
  vertical-align: middle;
  padding: 32px;
}
/* Jumbtron Button */
.jumbotron_button_cell, .jumbotron_button_native_cell {
  padding: 16px 32px;
}
/* Content */
.content_cell {
  padding: 0 16px;
}
.content_cell img {
  -webkit-border-radius: 4px;
  border-radius: 4px;
}
/* Primary Button */
.primary_btn, .secondary_btn {
  clear: both;
  margin: 0 auto;
}
.primary_btn td, .secondary_btn td {
  text-align: center;
  padding: 9px 32px;
  font-size: 18px;
  line-height: 26px;
  mso-line-height-rule: exactly;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}
.primary_btn a, .primary_btn span, .secondary_btn a, .secondary_btn span {
  font-weight: bold;
  text-align: center;
  display: block;
}
/* Horizontal Ruler */
.hruler {
  width: 80px;
  margin-left: auto;
  margin-right: auto;
  clear: both;
}
.hspace {
  width: 100%;
  font-size: 0;
  line-height: 16px;
  height: 16px;
  overflow: hidden;
}
/* Columns */
.one_column {
  text-align: left;
  padding: 32px;
}
.order_subtotal {
  text-align: right;
  padding: 16px 32px 24px;
}
.two_thirds .column_cell.font_default {
  text-align: left; 
}
/* Fluid Images */
.content_image_cell {
  line-height: 1;
}
.content_image_cell img {
  display: block;
  line-height: 1;
  width: 100%;
    max-width: 584px;
    height: auto;
}
.content_image_cell .one_half {
  max-width: 292px;
}
.content_image_cell .one_half img {
  max-width: 100%;
}
/* Colours */
.container {
  background-color: #f5f5f5;
}
.secondary_btn td {
  background-color: #ffffff;
}
.header_cell {
  border-top: 8px solid #f14145;
}
.header_cell, .content_cell {
  border-bottom: 1px solid #ebebeb;
}
body, .email_body_cell {
  background-color: #ffffff;
}
.jumbotron_cell, .jumbotron_small_cell, .jumbotron_button {
  background-color: #353536;
}
.jumbotron_native_cell, .jumbotron_native_small_cell, .jumbotron_button_native, .primary_btn td {
  background-color: #f14145;
}
.jumbotron_cell {
  background-image: url(/assets/img/email/anyshare_welcome_image.jpg);
}
a, .secondary_btn a, .secondary_btn span, h6, h6 small, .amount {
  color: #f14145;
}
h1, h3, h5, .primary_btn a, .primary_btn span {
  color: #ffffff;
}
h2, p, h4 {
  color: #4c4c4c;
}
small, .tagline_cell, .footer_cell p  {
  color: #999999;
}
/* Responsive */ 
@media screen {
h1, h2, h3, h4, h5, h6, p, a, .tagline_cell {
  font-family: "Open Sans", Helvetica, Arial, sans-serif !important;  /* web font */ 
}
.primary_btn td, .secondary_btn td {
  padding: 0 !important;
}
.primary_btn a, .secondary_btn a {
  font-size: 18px !important;
  line-height: 26px !important;
  padding: 9px 32px !important;
}
.jumbotron_cell {
  background-size: cover !important;
}
}
@media screen and (min-width: 621px) and (max-width: 769px) {
.one_third, .two_thirds, .one_half {
  float: left !important;
}
}
@media screen and (max-width: 620px) {
.email_body {
  min-width: 0 !important;
}
.one_third, .two_thirds, .one_half, .content_image_cell img, .content_image_cell .one_half img {
  max-width: 100% !important;
}
}
</style>
</head>
<body margintop="0" marginleft="0" marginright="0" marginbottom="0" style="margin: 0;padding: 0;min-width: 100%;background-color: #ffffff;">
<div class="email_summary" style="mso-line-height-rule: exactly;mso-hide: all;display: none !important;font-size: 0 !important;max-height: 0 !important;line-height: 0 !important;padding: 0 !important;overflow: hidden !important;float: none !important;width: 0 !important;height: 0 !important;">Activate your AnyShare account!</div>
<!-- end .email_summary -->
<table class="email_body" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;margin: 0;padding: 0;">
  <tbody>
    <tr>
      <td class="email_body_cell" style="padding: 16px 8px;text-align: center;vertical-align: top;font-size: 0;background-color: #ffffff;">
        <center>
          <div class="container_outer" style="vertical-align: top;max-width: 584px;margin: 0 auto;"> 
          <!--[if (gte mso 9)|(IE)]>
          <table width="584" align="center" cellpadding="0" cellspacing="0" border="0" style="vertical-align: top;">
            <tr>
              <td>
          <![endif]-->
              
            <table align="center" class="container" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;margin: 0 auto;vertical-align: top;-webkit-border-radius: 4px;border-radius: 4px;overflow: hidden;background-color: #f5f5f5;">
              <tbody>
                <tr>
                  <td class="container_cell" align="center" valign="top" style="padding: 0;">
                  
                    <table class="header" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
                      <tbody>
                        <tr>
                          <td class="header_cell" style="padding: 24px 16px;vertical-align: top;font-size: 0;text-align: left;-webkit-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;border-top: 8px solid #f14145;border-bottom: 1px solid #ebebeb;">
                          
                            <!--[if (gte mso 9)|(IE)]>
                            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="vertical-align: top;">
                            <tr>
                            <td align="left" width="184">
                            <![endif]-->
                            <div class="one_third" style="display: inline-block;width: 100%;vertical-align: top;text-align: left;max-width: 184px;">
                              <table width="100%" align="left" class="column" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;">
                                <tbody>
                                  <tr>
                                    <td class="column_cell logo_cell font_default" style="padding: 8px 16px;font-family: Helvetica, Arial, sans-serif;vertical-align: top;text-align: left;"><a href="#" style="display: inline-block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #f14145;"><img src="images/anyshare_email_logo.png" width="240" height="49" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div><!-- end .one_third --> 
                            <!--[if (gte mso 9)|(IE)]>
                                </td>
                                <td align="left" width="368">
                            <![endif]-->
          <!--                  <div class="two_thirds" style="display: inline-block;width: 100%;vertical-align: top;text-align: left;max-width: 368px;">
                              <table width="100%" class="column" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;">
                                <tbody>
                                  <tr>
                                    <td class="column_cell font_default tagline_cell" style="padding: 8px 16px;font-family: Helvetica, Arial, sans-serif;vertical-align: top;text-align: left;font-size: 16px;color: #999999;"><strong style="font-weight: bold;">Activate Your Account</strong></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div><!-- end .two_thirds --> 
                            <!--[if (gte mso 9)|(IE)]>
                                </td>
                              </tr>
                            </table>
                            <![endif]-->
                          
                          </td>
                        </tr>
                      </tbody>
                    </table><!-- end .header -->
                   
                    <table class="jumbotron" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
                      <tbody>
                        <tr>
                          <!----------------------------- This is where it all happens ---------------------->


                          @yield('content')


                          <!----------------------------- This is where it all happens ---------------------->
                        </tr>
                      </tbody>
                    </table><!-- end .jumbotron -->
                                                                         
                    <table class="footer" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
                      <tbody>
                        <tr>
                          <td align="center" class="footer_cell font_default" style="padding: 16px 32px 8px;font-family: Helvetica, Arial, sans-serif;"><p style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;line-height: 23px;margin-top: 16px;margin-bottom: 24px;color: #999999;"><a href="#" style="display: inline-block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #f14145;">&nbsp;<img src="images/facebook-color.png" width="32" height="32" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">&nbsp;</a> &nbsp;&nbsp; <a href="#" style="display: inline-block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #f14145;">&nbsp;<img src="images/twitter-color.png" width="32" height="32" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">&nbsp;</a> &nbsp;&nbsp; <a href="#" style="display: inline-block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #f14145;">&nbsp;<img src="images/googleplus-color.png" width="32" height="32" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">&nbsp;</a> &nbsp;&nbsp; <a href="#" style="display: inline-block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #f14145;">&nbsp;<img src="images/rss-color.png" width="32" height="32" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">&nbsp;</a></p>
                            <p style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;line-height: 23px;margin-top: 16px;margin-bottom: 24px;color: #999999;"><strong style="font-weight: bold;">AnyShare Society, </strong><a href="https://arcosanti.org" target="blank">Arcosanti</a>, Arizona, USA</p>
                            </td>
                        </tr>
                      </tbody>
                    </table><!-- end .footer -->
                    
                  </td>
                </tr>
              </tbody>
            </table><!-- end .container --> 
              
          <!--[if (gte mso 9)|(IE)]>
              </td>
            </tr>
          </table>
          <![endif]--> 
          </div><!-- end .container_outer -->
        </center>
      </td>
    </tr>
  </tbody>
</table>
<!-- end .email_body -->
</body>
</html>