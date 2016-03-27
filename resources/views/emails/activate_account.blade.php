@extends('emails/layouts/default')

@section('content')
<table class="jumbotron" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;" background="https://anysha.re/assets/img/backgrounds/hp/sets.png" >
  <tbody>
    <tr>
      <td class="jumbotron_cell junk"  align="center" valign="middle" >
        <h1 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;padding: 0;font-weight: bold;font-size: 32px;line-height: 40px;margin-top:20px;margin-bottom: 8px;color: #ffffff;">Activate your account now</h1>
        <h3 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;padding: 0;font-weight: normal;font-size: 19px;line-height: 28px;margin-top: 10px;margin-bottom:50px;color: #ffffff;">Simply click the button below.</h3>

        <table class="primary_btn" align="center" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;clear: both;margin: 0 auto 50px auto;">
          <tbody>
            <tr>
              <td class="font_default" style="padding: 9px 32px;font-family: Helvetica, Arial, sans-serif;text-align: center;font-size: 18px;line-height: 26px;mso-line-height-rule: exactly;-webkit-border-radius: 4px;border-radius: 4px;background-color: #f14145;">
                <a href="{{{ $data['activateAccountUrl'] }}}" style="display: block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #ffffff;font-weight: bold;text-align: center;"><span style="text-decoration: none;font-weight: bold;text-align: center;display: block;color: #ffffff;">Click here!</span></a>
              </td>
            </tr>
          </tbody>
        </table><!-- end .primary_btn -->
      </td>
      </tr>
    </tbody>
  </table><!-- end .jumbotron -->
@stop
