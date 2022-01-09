<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody' style=" font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="left" cellspacing="0" border="0" style="background:  #cccccc;">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                            <tr>
                                <td class='movableContentContainer bgItem'>
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                                            <tr height="25">
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" width="600" align="center" style="padding-bottom: 30px;">
                                                    <div class="logo">
                                                        <img src="{{asset('public/images/logo-image.png')}}" alt="abb">
                                                    </div>
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
															<p>Hi {{ ucfirst($shipping_first_name) }},</p>
															<p>Your product order from AdvantageBasketball.com has just shipped!  You'll be able to track your shipment using this tracking number and link:
															</p>
															@php 
																$url = "https://tools.usps.com/go/TrackConfirmAction_input?qtc_tLabels1=$tracking_number";
															@endphp
															<p><a href="{{$url}}">{{$url}}</a></p>
															<p>Sent to:</p>
															<p>@if($shipping_address){{ ucfirst($shipping_address) }}@endif</p>
															<p>@if($shipping_city){{ ucfirst($shipping_city) }},@endif @if($shipping_state){{ ucfirst($shipping_state) }} ({{$stateCode}}),@endif @if($shipping_postal_code){{$shipping_postal_code}}@endif</p>
                                                        </div>
                                                    </div>
													<p align='left'>If you have any questions, please contact us at 425-670-8877 or info@advantagebasketball.com.</p>
													<p align='left'>Thank you for your order!</p>
                                                    <p align='left'>Team Advantage Basket Ball</p>
                                                </td>

                                            </tr>
                                        </table>

                                    </div>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>