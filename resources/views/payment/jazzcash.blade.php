<h1>Please wait you will be redirected soon to <br>Jazzcash Payment Page</h1>
<head>
    <script type="text/javascript">
        function closethisasap() {
            // document.forms["redirectpost"].submit();
        }
    </script>
</head>
<body onload="closethisasap();">
    <div id="header" style="display: ;">
        <form name="redirectpost" method="post" action="<?php echo $PostURL; ?>" />
        <input type="text" name="pp_Version" value="<?php echo $Version; ?>" />
        <input type="text" name="pp_TxnType" value="<?php echo $TxnType; ?>" />
        <input type="text" name="pp_Language" value="<?php echo $Language; ?>" />
        <input type="text" name="pp_MerchantID" value="<?php echo $MerchantID; ?>" />
        <input type="hidden" name="pp_SubMerchantID" value="<?php echo $SubMerchantID; ?>" />
        <input type="text" name="pp_Password" value="<?php echo $Password; ?>" />
        <input type="text" name="pp_TxnRefNo" value="<?php echo $TxnRefNumber; ?>" />
        <input type="text" name="pp_Amount" value="<?php echo $Amount; ?>" />
        <input type="text" name="pp_TxnCurrency" value="<?php echo $TxnCurrency; ?>" />
        <input type="text" name="pp_TxnDateTime" value="<?php echo $TxnDateTime; ?>" />
        <input type="text" name="pp_BillReference" value="<?php echo $BillReference; ?>" />
        <input type="text" name="pp_Description" value="<?php echo $Description; ?>" />
        <input type="hidden" id="pp_DiscountedAmount" name="pp_DiscountedAmount" value="<?php echo $DiscountedAmount; ?>">
        <input type="hidden" id="pp_DiscountBank" name="pp_DiscountBank" value="<?php echo $DiscountedBank; ?>">
        <input type="text" name="pp_TxnExpiryDateTime" value="<?php echo $TxnExpiryDateTime; ?>" />
        <input type="text" name="pp_ReturnURL" value="<?php echo $ReturnURL; ?>" />
        <input type="text" name="pp_SecureHash" value="<?php echo $Securehash; ?>" />


        <input type="hidden" id="pp_DiscountedAmount" name="pp_IsRegisteredCustomer" value="<?php echo $IsRegisteredCustomer; ?>">
        <input type="hidden" id="pp_DiscountBank" name="pp_TokenizedCardNumber" value="<?php echo $TokenizedCardNumber; ?>">
        <input type="text" name="pp_CustomerID" value="<?php echo $CustomerID; ?>" />
        <input type="text" name="pp_CustomerEmail" value="<?php echo $CustomerEmail; ?>" />
        <input type="text" name="pp_CustomerMobile" value="<?php echo $CustomerMobile; ?>" />


        <input type="text" placeholder="ppmpf_1" name="ppmpf_1" value="<?php echo $ppmpf_1; ?>" />
        <input type="text" placeholder="ppmpf_2" name="ppmpf_2" value="<?php echo $ppmpf_2; ?>" />
        <input type="text" placeholder="ppmpf_3" name="ppmpf_3" value="<?php echo $ppmpf_3; ?>" />
        <input type="text" placeholder="ppmpf_4" name="ppmpf_4" value="<?php echo $ppmpf_4; ?>" />
        <input type="text" placeholder="ppmpf_5" name="ppmpf_5" value="<?php echo $ppmpf_5; ?>" /><br> <br> <br>
        {{-- <button id="submit" type="submit">submit</button> --}}
        </form>

        <?php
        
        ?>

    </div>
</body>