<script type="text/javascript">
  var empID = <?=(int)$empID;?>;
  var departmentID = <?=(int)isset($jobRole['department_id']) ? $jobRole['department_id'] : 0;?>;
  var positionID = <?=(int)isset($jobRole['position_id']) ? $jobRole['position_id'] : 0;?>;
  var positionLevelID = <?=(int)isset($jobRole['level_id']) ? $jobRole['level_id'] : 0;?>;
</script>
<article class="full-block clearfix">
  <section>
    <article class="full-block">
      <header>
        <h2>Employee Profile</h2>
        <nav><button class="btn Edit-Profile">Edit Profile</button></nav>
      </header>
    </article>
  </section>
</article>

<?php
if($profileCompleted === false)
{
  ?>
  <div class="notification attention">
	  <p><strong>NO PROFILE!</strong> This Employee hasn't got a completed profile yet. Complete thier profile now. [ <a href="javascript:void(0);" rel="<?=$empID;?>" class="Edit-Profile">Complete Profile</a> ]</p>
  </div>
  <?php
}
?>

<article class="full-block clearfix">
  <section>
    <!--  Profile Details -->
    <!-- ---------------- -->
	  <article class="half-block">	
			<section>
			  <div class="row-fluid">
			    <div class="span12">
				    <table>
             <tr>
               <th>Employee ID</th>
               <td><?=$empID;?></td>
             </tr>
             <tr>
                <th>Employment Date</th>
                <td><?=date("d-m-Y", $employeeDeatils['start_date']);?></td>
              </tr>
              <tr>
                <th>Forename</th>
                <td id="Forename-Cell"><?=$employeeDeatils['first_name'];?></td>
              </tr>
              <tr>
                <th>Surname</th>
                <td id="Surname-Cell"><?=$employeeDeatils['last_name'];?></td>
              </tr>
              <tr>
                <th>Date of Birth</th>
                <td id="Date-of-Birth-Cell"><?=date("d-m-Y", strtotime($employeeDeatils['date_of_birth']));?></td>
              </tr>
              <tr>
                <th>Building</th>
                <td id="Building-Cell"><?=$employeeDeatils['building'];?></td>
              </tr>
              <tr>
                <th>No. / Street</th>
                <td id="Street_and-Number-Cell"><?=$employeeDeatils['street_and_number'];?></td>
              </tr>
              <tr>
                <th>District</th>
                <td id="District-Cell"><?=$employeeDeatils['district'];?></td>
              </tr>
              <tr>
                <th>Town / Barangay</th>
                <td id="Town-Cell"><?=$employeeDeatils['town'];?></td>
              </tr>
              <tr>
                <th>County / Municipality</th>
                <td id="County-Cell"><?=$employeeDeatils['county'];?></td>
              </tr>
              <tr>
                <th>Post Code</th>
                <td id="Post-Code-Cell"><?=$employeeDeatils['post_code'];?></td>
              </tr>
              <tr>
                <th>Telephone Home</th>
                <td id="Telephone-Home-Cell"><?=$employeeDeatils['telephone_home'];?></td>
              </tr>
              <tr>
                <th>Telephone Mobile</th>
                <td id="Telephone-Mobile-Cell"><?=$employeeDeatils['telephone_mobile'];?></td>
              </tr>
              <tr>
                <th>Telephone Other</th>
                <td id="Telephone-Other-Cell"><?=$employeeDeatils['telephone_other'];?></td>
              </tr>
              <tr>
                <th>Email Address</th>
                <td><?=$employeeDeatils['email'];?></td>
              </tr>
            </table>
					</div>
				</div>
		  </section>
	  </article>
    <!-- END -->
    
    <!-- Profile Navigation -->
    <!-- ------------------ -->
    <article class="half-block clearrm">
      <section>
			  <div class="row-fluid">
			    <div class="span12">
				    <table>
              <tr>
                <th>Center</th>
                <td colspan="5"><?=$employeeDeatils['center_name'];?></td>
              </tr>
              <tr>
                <th>Department</th>
                <td><?=isset($jobRole['department_name']) ? $jobRole['department_name'] : '</i>Not Set</i>';?></td>
                
                <th>Role</th>
                <td><?=isset($jobRole['position_job_role']) ? $jobRole['position_job_role'] : '</i>Not Set</i>';?></td>
                
                <th>Level</th>
                <td><?=isset($jobRole['level_name']) ? $jobRole['level_name'] : false;?></td>
              </tr>
            </table>
					</div>
				</div>
		  </section>
      <br />
      <section>
			  <div class="row-fluid">
			    <div class="span12">
                    
				    <div class="Navigation-Button-Holder-50pc">
              <div class="Navigation-Button">
                <a href="/hr/profiles/" class="Nav-Link">
                  <div class="Navigation-Button-Title">
                    Attendance Log
                  </div>
                </a>
              </div>              
            </div>
            
            <div class="Navigation-Button-Holder-50pc">
              <div class="Navigation-Button">
                <a href="/hr/profiles/" class="Nav-Link">
                  <div class="Navigation-Button-Title">
                    Payslips
                  </div>
                </a>
              </div>
            </div>                
            
            <div class="clear"><!-- --></div>
                   
					</div>
				</div>
		  </section>      
      
    </article>
		<!-- // END -->
	</section>
</article>

<!-- Edit Profile Dialog Box -->
<!-- ----------------------- -->
<div id="Create-New-Profile-Dialog">
  <div style="padding: 5px;">
  
    <form id="Employee-New-Profile-Form">
      <!-- Employee Contacts -->
      <!-- ----------------- -->
      <div id="NP-Step-1" class="New-Profile-Step">
        <article class="full-block clearfix">
        <section>
          <article class="full-block">
            <header>
              <h2>Contact Details</h2>
            </header>
          </article>
        </section>
      </article>
      
      <article class="full-block clearfix">
        <section>
        <!--  Profile Details -->
        <!-- ---------------- -->
    	  <article class="full-block">	
    			<section>
    			  <div class="row-fluid">
    			    <div class="span12">
    				    <table width="100%" cellpadding="5" id="Profile-Edit-Form" class="Form-Table">
                  <tr>
                  <!--
                    <th>Title</th>
                    <td>
                      <select name="Profile-Title" id="Title-Input">
                        <option value=""> Select </option>
                        <option value="Mr">Mr</option>
                        <option value="Miss">Miss</option>
                        <option value="Mrs">Mrs</option>
                      </select>
                    </td>
                    -->
                    <th>Forename</th>
                    <td id="Forename-Cell"><input type="text" name="Profile-Forename" id="Forename-Input" class="medium" value="<?=$employeeDeatils['first_name'];?>" /></td>
                    
                    <th>Surname</th>
                    <td id="Surname-Cell"><input type="text" name="Profile-Surname" id="Surname-Input" class="medium" value="<?=$employeeDeatils['last_name'];?>" /></td>
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th>Date of Birth</th>
                    <td id="Date-of-Birth-Cell"><input type="text" name="Profile-Date-of-Birth" class="medium" id="Date-of-Birth" maxlength="10" value="<?=date("d-m-Y", strtotime($employeeDeatils['date_of_birth']));?>" placeholder="dd/mm/yyyy" /></td>
                    <td colspan="4" style="text-align: left;"><span id="DOB-Error" style="color: #FF0000;"></span></td>               
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Address</th>
                  </tr>
                  <tr>
                    <th>Building</th>
                    <td id="Building-Cell"><input type="text" name="Profile-Building" class="medium" value="<?=$employeeDeatils['building'];?>" /></td>
                    
                    <th>No. / Street</th>
                    <td id="Street_and-Number-Cell"><input type="text" name="Profile-Street-and-Number" class="medium" id="Street-and-Number-Input" value="<?=$employeeDeatils['street_and_number'];?>" /></td>
                    
                    <th>District</th>
                    <td id="District-Cell"><input type="text" name="Profile-District" class="medium" id="District-Input" value="<?=$employeeDeatils['district'];?>" /></td>
                  </tr>
                  <tr>
                    <th>Town / Barangay</th>
                    <td id="Town-Cell"><input type="text" name="Profile-Town" class="medium" id="Town-Input" value="<?=$employeeDeatils['town'];?>" /></td>
                    
                    <th>County / Municipality</th>
                    <td id="County-Cell"><input type="text" name="Profile-County" class="medium" id="County-Input" value="<?=$employeeDeatils['county'];?>" /></td>
                    
                    <th>Post Code</th>
                    <td id="Post-Code-Cell"><input type="text" name="Profile-Post-Code" class="medium" maxlength="8" id="Post-Code-Input" value="<?=$employeeDeatils['post_code'];?>" /></td>
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Telephone</th>
                  </tr>
                  <tr>
                    <th>Home</th>
                    <td id="Telephone-Home-Cell"><input type="text" name="Profile-Telephone-Home" class="medium" id="Telephone-Home-Input" value="<?=$employeeDeatils['telephone_home'];?>" /></td>
    
                    <th>Mobile</th>
                    <td id="Telephone-Mobile-Cell"><input type="text" name="Profile-Telephone-Mobile" class="medium" id="Telephone-Mobile-Input" value="<?=$employeeDeatils['telephone_mobile'];?>" /></td>
    
                    <th>Other</th>
                    <td id="Telephone-Other-Cell"><input type="text" name="Profile-Telephone-Other" class="medium" id="Telephone-Other-Input" value="<?=$employeeDeatils['telephone_other'];?>" /></td>
                  </tr>
                </table>
    					</div>
    				</div>
    		  </section>
    	  </article>
        </section>
       </article>
      </div>
      <!-- END Employee Contacts -->
      <!-- --------------------- -->
      
      <!-- Job Role -->
      <!-- -------- -->
      <div id="NP-Step-2" class="New-Profile-Step">
        <article class="full-block clearfix">
          <section>
            <article class="full-block">
              <header>
                <h2>Job Role, Pay and Tax</h2>
              </header>
            </article>
          </section>
        </article>
      
        <article class="full-block clearfix">
          <section>
    	      <article class="full-block">	
    			    <section>
    			      <div class="row-fluid">
    			        <div class="span12">
    				        <table width="100%" cellpadding="5" class="Form-Table">
                      <tr>
                        <th colspan="6" style="background-color: #FFF;">Job Position</th>
                      </tr>
                      <tr>
                        <th>Department</th>
                        <td>
                          <select name="Department" id="Department-Select" rel="<?=(int)$employeeDeatils['center_id'];?>">
                            <option value="">-- Select --</option>
                            <?php
                            foreach($departmentsList as $department)
                            {
                              ?>
                              <option value="<?=$department['id'];?>"<?=isset($jobRole['department_id']) && $jobRole['department_id'] ? ' SELECTED' : false;?>><?=$department['name'];?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </td>
                        <th>Position</th>
                        <td>
                          <select name="Position" id="Department-Position-Select" id="Position-Input">
                            <option value="">-- Select --</option>
                          </select>
                        </td>
                        <th>Level</th>
                        <td>
                          <select name="Position-Level" id="Department-Position-Level-Select">
                            <option value="">-- Select --</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <th colspan="6" style="background-color: #FFF;">Pay and Tax Details</th>
                      </tr>
                      <tr>
                        <th>Tin No.</th>
                        <th>Tax Code</th>
                        <th>PhHealth No.</th>
                        <th>SSSNo.</th>
                        <th>Basic Salary</th>
                        <th>Time Bonus</th>
                      </tr>
                      <tr>
                        <td><input type="text" name="Tin-Number" id="Tin-Number-Input" class="medium" placeholder="Tin No." value="<?=isset($taxAndPay['tin_number']) ? $taxAndPay['tin_number'] : false;?>" /></td>
                        <td>
                          <select name="Tax-Code" id="Tax-Code">
                            <option value="-1">-- Select --</option>
                            <?php
                            foreach($taxCodes as $code)
                            {
                              ?>
                              <option value="<?=$code['id'];?>"<?=isset($taxAndPay['tax_code_id']) && $taxAndPay['tax_code_id'] == $code['id'] ? ' SELECTED' : false;?>><?=$code['code'];?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </td>
                        <td><input type="text" name="PhilHealth-Number" id="PhilHealth-Number-Input" class="medium" placeholder="Phil Health" value="<?=isset($taxAndPay['phil_health_number']) ? $taxAndPay['phil_health_number'] : false;?>" /></td>
                        <td><input type="text" name="SSS-Number" id="SSS-Number-Input" class="medium" placeholder="SSS No." value="<?=isset($taxAndPay['sss_number']) ? $taxAndPay['sss_number'] : false;?>" /></td>
                        <td><input type="text" name="Basic-Salary-Override" id="Basic-Salary-Input" class="medium" placeholder="Basic Salary" value="<?=isset($taxAndPay['basic_pay_override']) ? $taxAndPay['basic_pay_override'] : false;?>" /></td>
                        <td><input type="text" name="Time-Bonus" id="Time-Bonus-Input" class="medium" placeholder="Time Bonus" value="<?=isset($taxAndPay['time_bonus']) ? $taxAndPay['time_bonus'] : false;?>" /></td>
                      </tr>
                      <tr>
                        <th>Managers Bonus</th>
                        <th>Bank</th>
                        <th>A/c Number</th>
                        <th colspan="3"></th>
                      </tr>
                      <tr>
                        <td><input type="text" name="Managers-Bonus" id="-Managers-Bonus-Input" class="medium" placeholder="Managers Bonus" value="<?=isset($taxAndPay['managers_bonus']) ? $taxAndPay['managers_bonus'] : false;?>" /></td>
                        <td><input type="text" name="Bank" id="Bank-Input" class="medium" placeholder="Bank" value="<?=isset($taxAndPay['bank']) ? $taxAndPay['bank'] : false;?>" /></td>
                        <td><input type="text" name="Account-Number" id="Account-Number-Input" class="medium" placeholder="Account Number" value="<?=isset($taxAndPay['account_number']) ? $taxAndPay['account_number'] : false;?>" /></td>
                        <td colspan="3"></td>
                      </tr>
                    </table>
    					    </div>
    				    </div>
    		      </section>
    	      </article>
          </section>
        </article>
      </div>
      <!-- END Job Role -->
      <!-- --------------->
    </form>
  </div>
</div>
<!-- // END -->

<?=Asset::js('human-resource.js');?>