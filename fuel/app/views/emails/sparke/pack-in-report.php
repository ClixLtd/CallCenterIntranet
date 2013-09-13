<!DOCTYPE HTML>
<html>
  <head>
    
  </head>
  <body>
    <h2>Spark E Pack-In Payment Report for <?=$date;?></h2>
    <p>
    <table>
      <tr>
        <th style="background-color: #DDDDDD;">Total Clients:</th>
        <td align="center"><?=count($clients);?></td>
        
        <th style="background-color: #DDDDDD;">Total To Payout:</th>
        <td>&pound;<?=number_format((count($clients) * 100), 2);?></td>
      </tr>
    </table>
    </p><p>
    <table cellpadding="5" cellspacing="0">
      <thead>
        <tr style="background-color:#DDDDDD">
          <th>Client ID</th>
          <th>Introducer</th>
          <th>Pack Received Date</th>
          <th>Payment</th>
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
              <td><?=$client['Client_ID'];?></td>
              <td><?=$client['Name'];?></td>
              <td><?=$client['PackReceived'];?></td>
              <td>&pound;<?=isset($client['Payment']) ? $client['Payment'] : 0;?></td>
            </tr>
            <?php
            $background2 = ($background2 == 0) ? 1 : 0;
          }
        }
        else
        {
          ?>
          <td colspan="4" align="center"><b>No Packs Returned</b></td>
          <?php
        }
        ?>
      </tbody>
    </table>
    </p>
  </body>
</html>