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
      <tr>
        <td colspan="2" align="center">
          <table cellpadding="5" width="100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Group</th>
                <th>Total Time Taken</th>
                <th>Total Overtime</th>
                <th>Total Breaks Taken</th>
                <th>Total Lunches Taken</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(count($results) > 0)
              {
                $background = 0;
                foreach($results as $key => $result)
                {
                  ?>
                  <tr style="background-color: <?php echo ($background==0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
                    <td align="center"><?=$result['full_name'];?></td>
                    <td align="center"><?=$result['user_group'];?></td>
                    <td align="center"><?=$result['total_break_time'];?></td>
                    <td align="center"><?=$result['time_diff'];?></td>
                    <td align="center"><?=$result['total_breaks_taken'];?></td>
                    <td align="center"><?=$result['total_lunch_taken'];?></td>
                  </tr>
                  <tr>
                    <td colspan="6"><b>Break Down</b></td>
                  </tr>
                  <tr>
                    <td colspan="6">
                      <table cellpadding="5" width="100%">
                        <thead>
                          <th>Break/Lunch</th>
                          <th>Time Taken</th>
                          <th>Is Late</th>
                          <th>Over Time</th>
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
                  <?php
                  $background = ($background==0) ? 1 : 0;
                }
              }
              else
              {
                ?>
                <td colspan="8">No Results</td>
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