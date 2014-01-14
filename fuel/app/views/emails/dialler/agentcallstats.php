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
        <td colspan="2"><hr /></td>
      </tr>
        <td colspan="2" align="center">
          <table cellpadding="5" width="100%">
            <thead>
              <tr>
                <th>Agent ID</th>
                <th>Agent Name</th>
                <th>Dials</th>
                <th>Connections</th>
                <th>None Connections</th>
                <th>Pitched To</th>
                <th>Sales</th>
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
                    <td align="center"><?=$result['user'];?></td>
                    <td align="center"><?=$result['agent_name'];?></td>
                    <td align="center"><?=$result['dials'];?></td>
                    <td><?=$result['connections'];?></td>
                    <td align="center"><?=$result['none_connections'];?></td>
                    <td align="center"><?=$result['pitched_to'];?></td>
                    <td align="center"><?=$result['sales'];?></td>
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