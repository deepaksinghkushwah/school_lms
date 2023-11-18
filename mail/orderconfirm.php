<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>:: Word Cup ::</title>
        <style type="text/css">
            body {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                margin:0 !important;
                width: 100% !important;
                -webkit-text-size-adjust: 100% !important;
                -ms-text-size-adjust: 100% !important;
                -webkit-font-smoothing: antialiased !important;
            }
            .tableContent img {
                border: 0 !important;
                display: block !important;
                outline: none !important;
            }
            a{
                color:#382F2E;
            }

            p, h1{
                color:#382F2E;
                margin:0;
            }
            p{
                text-align:left;
                color:#999999;
                font-size:14px;
                font-weight:normal;
                line-height:19px;
            }

            a.link1{
                color:#382F2E;
            }
            a.link2{
                font-size:16px;
                text-decoration:none;
                color:#ffffff;
            }

            h2{
                text-align:left;
                color:#222222;
                font-size:19px;
                font-weight:normal;
            }
            div,p,ul,h1{
                margin:0;
            }

            .bgBody{
                background: #ffffff;
            }
            .bgItem{
                background: #ffffff;
            }

        </style>

        <script type="colorScheme" class="swatch active">

            "name":"Default",
            "bgBody":"ffffff",
            "link":"382F2E",
            "color":"999999",
            "bgItem":"ffffff",
            "title":"222222"

        </script>

    </head>
    <body paddingwidth="0" paddingheight="0"   style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ccc" class="tableContent" align="center"  style='font-family:Helvetica, Arial,serif;'>



            <tr>
                <td>
                    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width='40'></td>
                            <td width='520'>
                                <table width="520" border="0" cellspacing="0" bgcolor="#fff" cellpadding="0" align="center" style="padding:10px;">

                                    <!-- =============================== Header ====================================== -->



                                    <!-- =============================== Body ====================================== -->

                                    <tr>
                                        <td class='movableContentContainer ' valign='top'>

                                            <div class='movableContent'>
                                                <table width="520" border="0" cellspacing="0" cellpadding="0" align="center">
                                                    <tr>
                                                        <td valign='top' align='center'>
                                                            <div class="contentEditable">
                                                                <h1> <?= Yii::$app->params['settings']['application_name']; ?></h1>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>



                                            <div class='movableContent'>
                                                <table width="520" border="0" cellspacing="0" cellpadding="0" align="center">
                                                    <tr><td height='55'></td></tr>
                                                    <tr>
                                                        <td align='left'>
                                                            <div class="contentEditableContainer contentTextEditable">
                                                                <div class="contentEditable" align='center'>
                                                                    <p  style='text-align:left;color:#333;font-size:24px;font-weight:normal;line-height:19px;'>Dear <?php echo ucwords($userprofile->fullname) ?>,</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr><td height='15'> </td></tr>

                                                    <tr>
                                                        <td align='left'>
                                                            <div class="contentEditableContainer contentTextEditable">
                                                                <div class="contentEditable" align='center'>
                                                                    <p>Thank you for ordering at <?= Yii::$app->params['settings']['application_name'] ?> . Your order has been confirmed (Order ID: #<?=$order->id?>). We are processing your order and as we receive payment, we will enroll you in your courses. If you have used online payment option, please check your courses section in students corner. Please contact support if you have any trouble with this order with reference order id.</p>
                                                                    
                                                                    <br/>
                                                                    <br/>
                                                                    <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'>Thanks and Regards  </p>

                                                                    <p  style='text-align:left;color:#999999;font-size:14px;font-weight:normal;line-height:19px;'><?= Yii::$app->name; ?> </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td align='center'>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>

                                            <div class='movableContent'>
                                                <table width="520" border="0" cellspacing="0" cellpadding="0" align="center">
                                                    <tr><td height='35'></td></tr>
                                                    <tr><td  style='border-bottom:1px solid #DDDDDD;'></td></tr>
                                                    <tr>
                                                        <td>
                                                            <table width="330" border="0" cellspacing="0" cellpadding="0" align="center">
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td height='25'>
                                                            <p  style='text-align:left;color:#000;font-size:18x;font-weight:normal;line-height:50px; text-align:center;'>Copyright © <?=date('Y')?> <?= Yii::$app->params['settings']['application_name']; ?>
                                                            </p>
                                                        </td></tr>

                                                </table>
                                            </div>



                                        </td>
                                    </tr>
                                    <!-- =============================== footer ====================================== -->




                                </table>
                            </td>
                            <td width='40'></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr><td height='88'></td></tr>


        </table>



    </body>
</html>
