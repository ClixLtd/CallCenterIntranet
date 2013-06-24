<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <?php
    if(count($results) > 0)
    {
      $background = 0;
      foreach($results as $result)
      {
        ?>
        <table cellpadding="5" width="100%">
          <thead>
            <tr style="background-color:#DDDDDD">
              <td colspan="5"><b><?=$result['full_name'];?></b></td>
            </tr>
            <tr>
              <td colspan="5" align="center"><b>Summary</b></td>
            </tr>
            <tr style="background-color:#EEEEEE">
              <th>Group</th>
              <th>Total Time Taken</th>
              <th>Total Overtime</th>
              <th>Total Breaks Taken</th>
              <th>Total Lunches Taken</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="center"><?=$result['user_group'];?></td>
              <td align="center"><?=$result['total_break_time'];?></td>
              <td align="center"><?=$result['time_diff'];?></td>
              <td align="center"><?=$result['total_breaks_taken'];?></td>
              <td align="center"><?=$result['total_lunch_taken'];?></td>
            </tr>
            <tr>
              <td colspan="5" align="center"><b>Breakdown</b></td>
            </tr>
            <tr>
              <td colspan="5">
                <table cellpadding="5" width="100%">
                  <thead>
                    <tr>
                      <th>Break/Lunch</th>
                      <th>Time Taken</th>
                      <th>Is Late</th>
                      <th>Over Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(count($result['breakDown']) > 0)
                    {
                      $background2 = 0;
                      foreach($result['breakDown'] as $break)
                      {
                        ?>
                        <tr style="background-color: <?php echo ($background2 == 0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
                          <td align="center"><?=$break['sub_status'];?></td>
                          <td align="center"><?=$break['total_break_time'];?></td>
                          <td align="center"><?=$break['is_late'];?></td>
                          <td align="center"><?=$break['time_diff'];?></td>
                        </tr>
                        <?php
                        $background2 = ($background2 == 0) ? 1 : 0;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
        <?php
      }
    }
    ?>
  </body>
</html>