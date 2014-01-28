<button class="btn" id="Add-New-Script-Button"><i class="icon-plus"></i> Add New Script</button>

<hr />

<div id="Create-Script-Box">
    
    <form action="#" name="CreateScriptForm" method="POST" id="Create-Script-Form">
      <h1>Survey Form</h1>
      <article class="">	
			<section>
			  <div class="row-fluid">
			    <div class="span12">
          <table>
            <tr>
              <td><strong>Survey Name</strong></td>
              <td><input type="text" name="form[script_name]" id="script_name" /></td>
            </tr>
            <tr>
              <td><strong>Can Repeat</strong></td>
              <td>
                <select name="form[can_repeat]">
                  <option value="">-- Select --</option>
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><strong>Survey Form</strong></td>
              <td>
                <div id="Form-Elements"></div>
                <table class="" id="Form-Elements-Table">
                  <thead>
                    <th>Question</th>
                    <th>Field Type</th>
                    <th>Answers</th>
                    <th>Required</th>
                    <th>Remove</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4">Use the below form to add a question field to the Survey Form</td>
                    </tr>
                  </tbody>
                </table>
                
                <table class="">
                  <thead>
                  </thead>
                  <tbody>
                    <tr style="background-color: #EEE;">
                      <td><strong>Field Type</strong></td>
                      <td>
                        <select name="input_type" id="Input-Type-Select" class="input-medium">
                          <option value="">-- Select --</option>
                          <?php
                          if(count($scriptFormTypes) > 0)
                          {
                            foreach($scriptFormTypes as $type)
                            {
                              ?>
                              <option value="<?=$type['id'];?>" rel="<?=$type['type'];?>"><?=$type['description'];?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </td>
                      <td><strong>Question</strong></td>
                      <td>
                        <textarea name="question" id="Input-Name"></textarea>
                      </td>
                    </tr>
                    <tr style="background-color: #EEE;">
                      <td>
                        <strong>Is Required</strong>
                      </td>
                      <td>
                        <select name="required" id="Required" class="input-medium">
                          <option value="no">No</option>
                          <option value="yes">Yes</option>
                        </select>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                        <button type="button" class="btn btn-primary" id="Add-Input-Button">Add Question</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button type="button" id="Save-Survey">Save Survey</button>
              </td>
            </tr>
          </table>
          </div>
       </div>
    </form>
    
</div>

<?=Asset::js('modules/script/admin.js');?>
<?=Asset::js('modules/script/script-form.js');?>

<script type="text/javascript">
  //loadAllScripts();
</script>