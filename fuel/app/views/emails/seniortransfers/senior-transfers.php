<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
  
    <table>
      <tr>
        <td width="600">
          <h2>Senior Transfer Report</h2>
          Date: <?=date("d/m/Y");?><br />
          Time: <?=(date("H") - 1);?>
        </td>
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
                <td>Errored</td>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $result) : ?>
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
              <?php endforeach; ?>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
  
  </body>
</html>