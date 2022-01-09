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
                                                            <p>Welcome to Advanatage Basket Ball, {{ucfirst($name)}}!
                                                                <br/>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <p style="width: 80%;text-align: left;margin: 5px;"><b>Link:</b> <a href="{{ url('/') }}/affliate/login">{{ url('/') }}/affliate/login</a></p>
                                                    <p style="width: 80%;text-align: left;margin: 5px;"><b>Username:</b> {{$email}}</p>
                                                    <p style="width: 80%;text-align: left;margin: 5px;"><b>Password:</b> {{$password}}</p>
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