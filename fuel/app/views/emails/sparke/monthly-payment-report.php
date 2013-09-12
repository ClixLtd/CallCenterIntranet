<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <h2>Spark E Monthly Payment Report for <?=$month;?></h2>
    
    <table cellpadding="5" cellspacing="0">
      <thead>
        <tr style="background-color:#DDDDDD">
          <th>Client ID</th>
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
        foreach($clients as $client)
        {
          ?>
          <tr style="background-color: <?php echo ($background2 == 0) ? "#EEEEEE" : "#CCCCCC"; ?>; border-bottom: #DDDDDD 1px solid;">
            <td><?=$client['ClientID'];?></td>
            <td><?=$client['FirstPaymentDate'];?></td>
            <td><?=$client['SecondPaymentDate'];?></td>
            <td><?=$client['UsedDI'];?></td>
            <td><?=$client['PaymentMethod'];?></td>
            <td>&pound;<?=$client['PaymentToMake'];?></td>
          </tr>
          <?php
          $background2 = ($background2 == 0) ? 1 : 0;
        }
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
  </body>
</html>