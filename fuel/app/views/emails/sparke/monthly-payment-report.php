<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <h2>Spark E Monthly Payment Report for <?=$month;?></h2>
    <p>
    The payment to make column is the double the DI minus the &pound;100 paid for the for the pack-in.
    </p><p>
    <table cellpadding="5" cellspacing="0" style="border: 1px solid #999999;">
      <tr>
        <th style="background-color: #DDDDDD;">Total Clients:</th>
        <td width="120" align="center" style="background-color: #CCCCCC;"><?=number_format(count($clients));?></td>
        
        <th style="background-color: #DDDDDD;">Total DI:</th>
        <td width="120" align="right" style="background-color: #CCCCCC;">&pound;<?=number_format($totalDI, 2);?></td>
        
        <th style="background-color: #DDDDDD;">Total Payment to Make:</th>
        <td width="120" align="right" style="background-color: #CCCCCC;">&pound;<?=number_format($totalToPayOut);?></td>
      </tr>
    </table>
    </p><p>
    <table cellpadding="5" cellspacing="0" width="100%">
      <thead>
        <tr style="background-color:#DDDDDD;">
          <th height="45">Client ID</th>
          <th>First Payment Date</th>
          <th>Second Payment Data</th>
          <th>DI</th>
          <th>Payment Method</th>
          <th>Payment to Make</th>
        </tr>
      </thead>
      <tbody>
      <?php
      if(count($clients) > 0)
      {
        $background2 = 0;
        $total = 0;
        foreach($clients as $client)
        {
          ?>
          <tr style="background-color: <?php echo ($background2 == 0) ? "#EEEEEE" : "#CCCCCC"; ?>; border-bottom: #DDDDDD 1px solid;">
            <td align="center"><?=$client['ClientID'];?></td>
            <td align="center"><?=isset($client['FirstPaymentDate']) ? date("d-m-Y", strtotime($client['FirstPaymentDate'])) : false;?></td>
            <td align="center"><?=isset($client['SecondPaymentDate']) ? date("d-m-Y", strtotime($client['SecondPaymentDate'])) : false;?></td>
            <td align="right">&pound;<?=$client['UsedDI'];?></td>
            <td align="center"><?=$client['PaymentMethod'];?></td>
            <td align="right">&pound;<?=$client['PaymentToMake'];?></td>
          </tr>
          <?php
          $background2 = ($background2 == 0) ? 1 : 0;
        }
        ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
          <td align="right" style="background-color: #DDDDDD;"><b>Total:</b></td>
          <td align="right" style="background-color: #CCCCCC;"><b><?=number_format($totalToPayOut);?></b></td>
        </tr>
        <?php
      }
      else
      {
        ?>
        <tr>
          <td colspan="6"><b>No Payments to Make</b></td>
        </tr>
        <?php
      }
      ?>
      </tbody>
    </table>
    </p>
  </body>
</html>