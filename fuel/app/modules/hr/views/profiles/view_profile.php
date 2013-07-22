<?php
#print_r($employeeDeatils);
?>
<script type="text/javascript">
  var empID = <?=(int)$empID;?>;
</script>
<article class="full-block clearfix">
  <section>
    <article class="full-block">
      <header>
        <h2>Employee Profile</h2>
      </header>
    </article>
  </section>
</article>

<?php
if($hasDetails === false)
{
  ?>
  <div class="notification attention">
	  <p><strong>NO PROFILE!</strong> This Employee hasn't got a profile yet. Create them a new profile now. [ <a href="javascript:void(0);" rel="<?=$empID;?>" id="Create-New-Profile">Create New Profile</a> ]</p>
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
                <th>Center</th>
                <td><?=$employeeDeatils['center_name'];?></td>
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
                <td id="Date-of-Birth-Cell"></td>
              </tr>
              <tr>
                <th>Building</th>
                <td id="Building-Cell"></td>
              </tr>
              <tr>
                <th>No. / Street</th>
                <td id="Street_and-Number-Cell"></td>
              </tr>
              <tr>
                <th>District</th>
                <td id="District-Cell"></td>
              </tr>
              <tr>
                <th>Town / Barangay</th>
                <td id="Town-Cell"></td>
              </tr>
              <tr>
                <th>County / Municipality</th>
                <td id="County-Cell"></td>
              </tr>
              <tr>
                <th>Post Code</th>
                <td id="Post-Code-Cell"></td>
              </tr>
              <tr>
                <th>Telephone Home</th>
                <td id="Telephone-Home-Cell"></td>
              </tr>
              <tr>
                <th>Telephone Mobile</th>
                <td id="Telephone-Mobile-Cell"></td>
              </tr>
              <tr>
                <th>Telephone Other</th>
                <td id="Telephone-Other-Cell"></td>
              </tr>
              <tr>
                <th>Email Address</th>
                <td></td>
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
				    Hello
					</div>
				</div>
		  </section>
      
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

<!-- Create New Profile Dialog Box -->
<!-- ----------------------------- -->
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
    				    <table width="100%" cellpadding="5" class="Form-Table">
                  <tr>
                    <th>Title</th>
                    <td>
                      <select name="New-Profile-Title" id="New-Title-Input">
                        <option value="">-- Select --</option>
                        <option value="Mr">Mr</option>
                        <option value="Miss">Miss</option>
                        <option value="Mrs">Mrs</option>
                      </select>
                    </td>
                    
                    <th>Forename</th>
                    <td id="Forename-Cell"><input type="text" name="New-Profile-Forename" id="New-Forename-Input" value="<?=$employeeDeatils['first_name'];?>" /></td>
                    
                    <th>Surname</th>
                    <td id="Surname-Cell"><input type="text" name="New-Profile-Surname" id="New-Surname-Input" value="<?=$employeeDeatils['last_name'];?>" /></td>
                  </tr>
                  <tr>
                    <th>Date of Birth</th>
                    <td id="Date-of-Birth-Cell"><input type="text" name="New-Profile-Date-of-Birth" id="New-Date-of-Birth" class="datepicker" placeholder="dd/mm/yyy" /></td>
                    <th colspan="4"></th>                    
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Address</th>
                  </tr>
                  <tr>
                    <th>Building</th>
                    <td id="Building-Cell"><input type="text" name="New-Profile-Building" /></td>
                    
                    <th>No. / Street</th>
                    <td id="Street_and-Number-Cell"><input type="text" name="New-Profile-Street-and-Number" id="New-Street-and-Number-Input" /></td>
                    
                    <th>District</th>
                    <td id="District-Cell"><input type="text" name="New-Profile-District" id="New-District-Input" /></td>
                  </tr>
                  <tr>
                    <th>Town / Barangay</th>
                    <td id="Town-Cell"><input type="text" name="New-Profile-Town" id="New-Town-Input" /></td>
                    
                    <th>County / Municipality</th>
                    <td id="County-Cell"><input type="text" name="New-Profile-County" id="New-County-Input" /></td>
                    
                    <th>Post Code</th>
                    <td id="Post-Code-Cell"><input type="text" name="New-Profile-Post-Code" id="New-Post-Code-Input" /></td>
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Telephone</th>
                  </tr>
                  <tr>
                    <th>Telephone Home</th>
                    <td id="Telephone-Home-Cell"><input type="text" name="New-Profile-Telephone-Home" id="New-Telephone-Home-Input" /></td>
    
                    <th>Telephone Mobile</th>
                    <td id="Telephone-Mobile-Cell"><input type="text" name="New-Profile-Telephone-Mobile" id="New-Telephone-Mobile-Input" /></td>
    
                    <th>Telephone Other</th>
                    <td id="Telephone-Other-Cell"><input type="text" name="New-Profile-Telephone-Other" id="New-Telephone-Other-Input" /></td>
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
                <h2>Job Role and Position</h2>
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
                          <select name="Department" id="Department-Select" rel="<?=(int)$employeeDeatils['call_center_id'];?>">
                            <option value="">-- Select --</option>
                            <?php
                            foreach($departmentsList as $department)
                            {
                              ?>
                              <option value="<?=$department['id'];?>"><?=$department['name'];?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </td>
                        <th>Position</th>
                        <td>
                          <select name="Position" id="Department-Position-Select" id="New-Position-Input">
                            <option value="">-- Select --</option>
                          </select>
                        </td>
                        <th>Level</th>
                        <td>
                          <select name="Position-Level" id="Department-Position-Level-Select" id="New-Position-Level-Input">
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
                        <td><input type="text" name="Tin-Number" id="New-Tin-Number-Input" placeholder="Tin No." /></td>
                        <td>
                          <select name="Tax-Code" id="New-Tax-Code">
                            <option value="-1">-- Select --</option>
                            <?php
                            foreach($taxCodes as $code)
                            {
                              ?>
                              <option value="<?=$code['id'];?>"><?=$code['code'];?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </td>
                        <td><input type="text" name="PhilHealth-Number" id="New-PhilHealth-Number-Input" placeholder="Phil Health" /></td>
                        <td><input type="text" name="SSS-Number" id="New-SSS-Number-Input" placeholder="SSS No." /></td>
                        <td><input type="text" name="Basic-Salary" id="New-Basic-Salary-Input" placeholder="Basic Salary" /></td>
                        <td><input type="text" name="Time-Bonus" id="New-Time-Bonus-Input" placeholder="Time Bonus" /></td>
                      </tr>
                      <tr>
                        <th>Managers Bonus</th>
                        <th>Bank</th>
                        <th>Account Number</th>
                        <th colspan="3"></th>
                      </tr>
                      <tr>
                        <td><input type="text" name="Managers-Bonus" id="New-Managers-Bonus-Input" placeholder="Managers Bonus" /></td>
                        <td><input type="text" name="Bank" id="New-Bank-Input" placeholder="Bank" /></td>
                        <td><input type="text" name="Account-Number" id="New-Account-Number-Input" placeholder="Account Number" /></td>
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