<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <h2>Terminated and Suspended Clients</h2>
    
    <table width="100%" cellpadding="5" cellspacing="0">
      <thead>
        <tr style="background-color:#DDDDDD">
          <th colspan="4" style="font-size: 14px;">Summary</th>
        </tr>
        <tr style="background-color:#DDDDDD">
          <th>Date</th>
          <th>Office</th>
          <th>Total Terminated</th>
          <th>Total Suspended</th>
        </tr>
      </thead>
      <tbody>
        <tr style="background-color:#EEEEEE">
          <td align="center"><?=date("d/m/Y");?></td>
          <td align="center"><?=$clients['Office'];?></td>
          <td align="center"><?=number_format(count($clients['status']['Terminated']));?></td>
          <td align="center"><?=number_format(count($clients['status']['Suspended']));?></td>
        </tr>
      </tbody>
    </table>
    
    <br />
    <hr />
    <br />
    
    <?php
    foreach($clients['status'] as $status => $clientList)
    {
      ?>    
      <table width="100%" cellpadding="5" cellspacing="0">
        <thead>
          <tr style="background-color:#DDDDDD">
            <th colspan="7" style="font-size: 14px;"><?=$status;?></th>
          </tr>
          <tr style="background-color:#DDDDDD">
            <th width="80">Client ID</th>
            <th>Client Name</th>
            <th>Changed By</th>
            <th>Process Stage Date/Time</th>
            <th>Last Correspondence Title</th>
            <th>Last Correspondence Note</th>
            <th>First Payment Made</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $background = 0;
        
        if(count($clientList) > 0)
        {
          foreach($clientList as $client)
          {
            ?>
            <tr style="background-color: <?php echo ($background==0) ? "#EEEEEE" : "#DDDDDD"; ?>; border-bottom: #CCCCCC 1px solid;">
              <td rowspan="3" align="center" valign="top"><?=$client['ClientID'];?></td>
              <td nowrap><?=rtrim($client['Title'] . ' ' . $client['Forename'] . ' ' . $client['Surname']);?></td>
              <td nowrap><?=$client['CreatedBy'];?></td>
              <td align="center" nowrap><?=date("d-m-Y H:i", strtotime($client['ProcessDate']));?></td>
              <td><?=$client['CorresspondenceTitle'];?></td>
              <td><?=nl2br($client['CorrespondenceDescription']);?></td>
              <td align="center"><?=$client['FirstPaymentMade'];?></td>
            </tr>
            <tr>
              <th>Date Agreed</th>
              <th>DI</th>
              <th>Last Payment Date</th>
              <th>Months on Plan</th>
              <th>Total Calls Made</th>
              <th></th>
            </tr>
            <tr>
              <td><?=date("d-m-Y H:i", strtotime($client['DateAgreed']));?></td>
              <td><?=$client['AgreedDI'];?></td>
              <td><?=date("d-m-Y H:i", strtotime($client['LastPaymentMade']));?></td>
              <td><?=$client['MonthsOnPlan'];?></td>
              <td><?=$client['TotalCallsToClient'];?></td>
              <td></td>
            </tr>
            <?php
            $background = ($background==0) ? 1 : 0;
          }
        }
        else
        {
          ?>
          <td colspan="6" align="center">No Accounts Found</td>
          <?php
        }
        ?>
        </tbody>
        
      </table>
      
      <br />
      <hr />
      <br />
      
      <?php
      }
    ?>
  </body>
</html>