<h1>Client Change of Details Request</h1>

<div style="float: right; margin-bottom: 15px;">

</div>

<table class="datatable">
    
    <thead>
    <tr>
        <th>Client Debtsolv ID</th>
        <th>Company Name</th>
        <th>Client Name</th>
        <th>Field</th>
        <th>Request Date</th>
    </tr>
    </thead>
    
    <tbody>
      <?php foreach ($requestList AS $clientID => $request): ?>
      <tr>
        <td><a href="javascript:void(0);" rel="<?=$clientID;?>" class="Change-Details-Link" title="Click to approve changes"><?=$clientID;?></a></td>
        <td><?=$request[0]['company_name'];?></td>
        <td><?=$request[0]['client_name'];?></td>
        <td>
          <?php foreach($request as $item) : ?>
          <?=$item['field'];?><br />
          <?php endforeach; ?>
        </td>
        <td>
          <?php foreach($request as $item) : ?>
          <?=date("d/m/Y G:i", strtotime($item['date_requested']));?><br />
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>

</table>

<!-- Change Client Details Dialog Box -->
<!-- -------------------------------- -->
<div id="Change-Client-Details">
  <form id="Change-Client-Details-Form">
    <input type="hidden" name="ClientID" id="ClientID" value="" />
    <input type="hidden" name="RequestID" id="RequestID" value="" />
    <input type="hidden" name="Field" id="Field" value="" />
    <input type="hidden" name="CompanyID" id="CompanyID" value="" />
    <table>
      <tr>
        <td width="200">Select Field to Approve:</td>
        <td id="Field-List" style="text-align: left;"></td>
      </tr>
      <tr>
        <td>Old Value:</td>
        <td id="Old-Value" align="left"></td>
      </tr>
      <tr>
        <td>New Value:</td>
        <td id="New-Value" align="left"></td>
      </tr>
    </table>
  </form>
</div>

<?=asset::js('client-area.js');?>