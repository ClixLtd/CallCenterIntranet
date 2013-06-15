<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
  
    <table>
      <tr>
        <td><b>Date:</b></td>
        <td><?=date("d/m/Y");?></td>
      </tr>
      <tr>
        <td><b>Time:</b></td>
        <td><?=(date("H") - 1);?>:00</td>
      </tr>
      <tr>
        <td align="center">
          <table width="100%">
            <thead>
              <tr>
                <th>Lead ID</th>
                <th>Senior</th>
                <th>Transfer Time</th>
                <th>Completed Time</th>
                <th>Leadpool ID</th>
                <th>List ID</th>
                <th>Errored</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(count($results) > 0)
              {
                foreach($results as $result)
                {
                ?>
                <tr>
                  <td align="center"><?=$result['lead_id'];?></td>
                  <td><?=$result['senior_username'];?></td>
                  <td><?=$result['transfered_date_time'];?></td>
                  <td><?=$result['completed_date_time'];?></td>
                  <td align="center"><?=$result['leadpool_id'];?></td>
                  <td align="center"><?=$result['list_id'];?></td>
                  <td align="center"><?=$result['has_error'];?></td>
                  <td align="center"><?=$result['status'];?></td>
                </tr>
                <?php
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