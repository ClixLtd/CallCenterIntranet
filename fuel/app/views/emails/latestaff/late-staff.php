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
        <table cellpadding="5" cellspacing="0" width="100%">
          <thead>
            <tr style="background-color:#DDDDDD">
              <td colspan="5" style="font-size: 14px;"><b><?=$result['full_name'];?></b></td>
            </tr>
            <tr style="background-color:#DDDDDD">
              <td colspan="5" align="center"><b>Summary</b></td>
            </tr>
            <tr style="background-color:#DDDDDD">
              <th>Group</th>
              <th>Total Time Taken</th>
              <th>Total Tardiness</th>
              <th>Total Breaks Taken</th>
              <th>Total Lunches Taken</th>
            </tr>
          </thead>
          <tbody>
            <tr style="background-color:#EEEEEE">
              <td align="center"><?=$result['user_group'];?></td>
              <td align="center"><?=$result['total_break_time'];?></td>
              <td align="center"><?=$result['time_diff'];?></td>
              <td align="center"><?=$result['total_breaks_taken'];?></td>
              <td align="center"><?=$result['total_lunch_taken'];?></td>
            </tr>
            <tr>
              <td colspan="5" align="center" style="background-color:#DDDDDD"><b>Breakdown</b></td>
            </tr>
            <tr>
              <td colspan="5" style="background-color:#EEEEEE">
                <table cellpadding="5" cellspacing="0" width="100%">
                  <thead>
                    <tr style="background-color:#DDDDDD">
                      <th>Break/Lunch</th>
                      <th>Time Taken</th>
                      <th>Is Late</th>
                      <th>Tardiness</th>
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
                        <tr style="background-color: <?php echo ($background2 == 0) ? "#EEEEEE" : "#DDDDDD"; ?>; border-bottom: #CCCCCC 1px solid;">
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