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
                <th>Transfers</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(count($results) > 0)
              {
                $background = 0;
                
                $dialsTotal = 0;
                $connectionsTotal = 0;
                $noneConnectionsTotal = 0;
                $pitchedToTotal = 0;
                $salesTotal = 0;
                
                foreach($results as $result)
                {
                  ?>
                  <tr style="background-color: <?php echo ($background==0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
                    <td align="center"><?=$result['user'];?></td>
                    <td align="center"><?=$result['agent_name'];?></td>
                    <td align="center"><?=number_format($result['dials']);?></td>
                    <td align="center"><?=number_format($result['connections']);?></td>
                    <td align="center"><?=number_format($result['none_connections']);?></td>
                    <td align="center"><?=number_format($result['pitched_to']);?></td>
                    <td align="center"><?=number_format($result['sales']);?></td>
                  </tr>
                  <?php
                  $background = ($background==0) ? 1 : 0;
                  
                  $dialsTotal = ($dialsTotal + $result['dials']);
                  $connectionsTotal = ($connectionsTotal + $result['connections']);
                  $noneConnectionsTotal = ($noneConnectionsTotal + $result['none_connections']);
                  $pitchedToTotal = ($pitchedToTotal + $result['pitched_to']);
                  $salesTotal = ($salesTotal + $result['sales']);
                }
                ?>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Totals</strong></td>
                  <td align="center"><strong><?=number_format($dialsTotal);?></strong></td>
                  <td align="center"><strong><?=number_format($connectionsTotal);?></strong></td>
                  <td align="center"><strong><?=number_format($noneConnectionsTotal);?></strong></td>
                  <td align="center"><strong><?=number_format($pitchedToTotal);?></strong></td>
                  <td align="center"><strong><?=number_format($salesTotal);?></strong></td>
                </tr>
                <?php
              }
              else
              {
                ?>
                <td colspan="8">No Data for Today</td>
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