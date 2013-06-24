<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
  
    <table cellpadding="5" width="100%">
      <tr>
        <td width="100"><b>Date:</b></td>
        <td><?=date("d/m/Y");?></td>
      </tr>
      <tr>
        <td><b>Time:</b></td>
        <td><?=(date("H") - 1);?>:00</td>
      </tr>
      <tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
        <td colspan="2" align="center">
          <table cellpadding="5" width="100%">
            <thead>
              <tr>
                <th>Lead ID</th>
                <th>Office</th>
                <th>Tele Agent</th>
                <th>Senior</th>
                <th>Transfer Time</th>
                <th>Completed Time</th>
                <th>Leadpool ID</th>
                <th>List ID</th>
                <th>Lead Source</th>
                <th>Errored</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(count($results) > 0)
              {
                $background = 0;
                foreach($results as $result)
                {
                  ?>
                  <tr style="background-color: <?php echo ($background==0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
                    <td align="center"><?=$result['lead_id'];?></td>
                    <td align="center"><?=$result['office'];?></td>
                    <td align="center"><?=$result['tele_agent'];?></td>
                    <td><?=$result['senior_username'];?></td>
                    <td align="center"><?=$result['transfered_date_time'];?></td>
                    <td align="center"><?=$result['completed_date_time'];?></td>
                    <td align="center"><?=$result['leadpool_id'];?></td>
                    <td align="center"><?=$result['list_id'];?></td>
                    <td align="center"><?=$result['list_id'] == '970' ? 'Reactive' : $result['lead_source'];?></td>
                    <td align="center"><?=$result['has_error'];?></td>
                    <td align="center"><?=$result['description'];?></td>
                  </tr>
                  <?php
                  $background = ($background==0) ? 1 : 0;
                }
              }
              else
              {
                ?>
                <td colspan="8">No Transfers</td>
                <?php
              }
              ?>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
  
  </body>
</html>