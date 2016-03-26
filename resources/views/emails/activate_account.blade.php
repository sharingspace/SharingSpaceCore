@extends('emails/layouts/default')

@section('content')
  <td class="jumbotron_cell" background="/assets/img/email/anyshare_welcome_image.jpg" align="center" valign="middle" style="padding: 32px;vertical-align: middle;background-position: 0 0;background-size: 100% auto;background-repeat: no-repeat;height: 224px;background-image: url(images/anyshare_welcome_image.jpg);background-color: #353536;">
  <h1 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;padding: 0;font-weight: bold;font-size: 32px;line-height: 40px;margin-top: 0;margin-bottom: 8px;color: #ffffff;">Activate your account now</h1>
    <h3 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;padding: 0;font-weight: normal;font-size: 19px;line-height: 28px;margin-top: 10px;margin-bottom: 10px;color: #ffffff;">Simply click the button below.</h3>
      <table class="hruler" width="80" border="0" align="center" cellpadding="0" cellspacing="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 80px;margin-left: auto;margin-right: auto;clear: both;">
        <tbody>
          <tr>
            <td class="hspace" style="padding: 0;width: 100%;font-size: 0;line-height: 16px;height: 16px;overflow: hidden;">&nbsp;</td>
          </tr>
        </tbody>
      </table><!-- end .hruler -->
      <table class="primary_btn" align="center" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;clear: both;margin: 0 auto;">
        <tbody>
          <tr>
            <td class="font_default" style="padding: 9px 32px;font-family: Helvetica, Arial, sans-serif;text-align: center;font-size: 18px;line-height: 26px;mso-line-height-rule: exactly;-webkit-border-radius: 4px;border-radius: 4px;background-color: #f14145;">
              <a href="{{{ $data['activateAccountUrl'] }}}" style="display: block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #ffffff;font-weight: bold;text-align: center;"><span style="text-decoration: none;font-weight: bold;text-align: center;display: block;color: #ffffff;">Click here!</span></a>
            </td>
          </tr>
        </tbody>
      </table><!-- end .primary_btn -->
  </td>

@stop
