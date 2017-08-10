<!DOCTYPE html>
<html>
    @include('partials.mail-header')
    <body>
        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
            <td align="center" valign="top" id="bodyCell">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                    <td align="center" valign="top" id="templateHeader" background="https://gallery.mailchimp.com/a691a25ff2c949305a23cb193/images/7ef044a3-ff07-43f4-ad6a-68585c33264b.jpg" style="background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:100px; padding-bottom:100px;">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="headerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <div style="text-align: center;">
                                                                    <span style="color:#FFFFFF"><span style="font-size:72px; font-weight: 600;"></span></span>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>
                    <td align="center" valign="top" id="templateBody">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="bodyContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <h1 style="text-align: center;">Enjoy you meal2gether!</h1>
                                                                <p style="text-align: center; font-size: 16px; line-height: 150%; margin-top: 30px;">
                                                                    Hi {{ $user->first_name }}! How are you? We're just passing by to tell you that {{ $host->first_name }} is happily expecting you for a delicious meal and some nice stories.<br><br>
                                                                    You'll find your host's contact info below.<br>
                                                                </p>
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%; width:600px">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EAEAEA;">
                                                    <tbody>
                                                    <tr>
                                                    <td>
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; width:600px">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="209" style="width:209px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:209px;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="font-size: 16px; line-height: 150%; margin-top: 30px; padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                                                                First name:<br>
                                                                Last name:<br>
                                                                Email address:<br>
                                                                Phone number:<br><br>
                                                                Date &amp; time:<br>
                                                                Street:<br>
                                                                Postal code:<br>
                                                                City:<br><br>
                                                                Message:
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td valign="top" width="389" style="width:389px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:389px;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="font-size: 16px; line-height: 150%; margin-top: 30px; padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                                                                {{ $host->first_name }}<br>
                                                                {{ $host->last_name }}<br>
                                                                {{ $host->email }}<br>
                                                                {{ $booking->telephone_number }}<br><br>
                                                                {{ $datetime }}<br>
                                                                {{ $booking->street_number}}<br>
                                                                {{ $booking->postalcode }}<br>
                                                                {{ $booking->city }}<br><br>
                                                                {{ $host_message ? $host_message : '/'}}
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%; width:600px">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EAEAEA;">
                                                    <tbody>
                                                    <tr>
                                                    <td>
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                                            <tbody class="mcnButtonBlockOuter">
                                            <tr>
                                            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #00C77C;">
                                                    <tbody>
                                                    <tr>
                                                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 15px;">
                                                        <a class="mcnButton " title="View booking" href="{{ env('APP_URL') }}/#/booking/{{ $booking->id }}/details" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">View booking</a>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </table>
                    <tr>
                    <td align="center" valign="top" id="templateFooter">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="footerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                            <td class="mcnDividerBlockInner"
                                                    style="min-width: 100%; padding: 10px 18px 25px;">
                                                <table class="mcnDividerContent" border="0" cellpadding="0"
                                                        cellspacing="0" width="100%"
                                                        style="min-width: 100%;border-top: 2px solid #EEEEEE;">
                                                    <tbody>
                                                    <tr>
                                                    <td>
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px; text-align: center;">
                                                                <em>Copyright © 2016 Dine2Gether, All rights reserved.</em><br>
                                                                <br>
                                                                *If you didn't register yourself to our website, you can just ignore this mail.
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                </table>
            </td>
            </tr>
        </table>
    </body>
</html>