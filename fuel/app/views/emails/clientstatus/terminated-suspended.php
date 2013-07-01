<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <h2>Terminated and Suspended Clients</h2>
    
    <table width="100" cellpadding="5" cellspacing="0">
      <thead>
        <tr style="background-color:#DDDDDD">
          <th colspan="3">Summary</th>
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
    
    <hr />
    
    <?php
    foreach($clients['status'] as $status => $clientList)
    {
      ?>    
      <table width="100" cellpadding="5" cellspacing="0">
        <thead>
          <tr style="background-color:#DDDDDD">
            <th colspan="6"><?=$status;?></th>
          </tr>
          <tr style="background-color:#DDDDDD">
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Changed By</th>
            <th>Process Stage Date/Time</th>
            <th>Last Correspondence Title</th>
            <th>Last Correspondence Note</th>
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
            <tr style="background-color: <?php echo ($background==0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
              <td align="center"><?=$client['ClientID'];?></td>
              <td><?=rtrim($client['Title'] . ' ' . $client['Forename'] . ' ' . $client['Surname']);?></td>
              <td align="center"><?=$client['CreatedBy'];?></td>
              <td align="center"><?=date("d-m-Y H:i", strtotime($client['ProcessDate']));?></td>
              <td align="center"><?=$client['CorresspondenceTitle'];?></td>
              <td align="center"><?=$client['CorrespondenceDescription'];?></td>
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
      
      <hr />
      
      <?php
      }
    ?>
  </body>
</html>