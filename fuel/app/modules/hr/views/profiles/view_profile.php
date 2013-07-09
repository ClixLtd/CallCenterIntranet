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
                <td id="Forename-Cell"></td>
              </tr>
              <tr>
                <th>Surname</th>
                <td id="Surname-Cell"></td>
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
                      <select name="New-Profile-Title">
                        <option value="">-- Select --</option>
                      </select>
                    </td>
                    
                    <th>Forename</th>
                    <td id="Forename-Cell"><input type="text" name="New-Profile-Forename" /></td>
                    
                    <th>Surname</th>
                    <td id="Surname-Cell"><input type="text" name="New-Profile-Surname" /></td>
                  </tr>
                  <tr>
                    <th>Date of Birth</th>
                    <td id="Date-of-Birth-Cell"><input type="text" name="New-Profile-Date-of-Birth" /></td>
                    <th colspan="4"></th>                    
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Address</th>
                  </tr>
                  <tr>
                    <th>Building</th>
                    <td id="Building-Cell"><input type="text" name="New-Profile-Building" /></td>
                    
                    <th>No. / Street</th>
                    <td id="Street_and-Number-Cell"><input type="text" name="New-Profile-Street-and-Number" /></td>
                    
                    <th>District</th>
                    <td id="District-Cell"><input type="text" name="New-Profile-District" /></td>
                  </tr>
                  <tr>
                    <th>Town / Barangay</th>
                    <td id="Town-Cell"><input type="text" name="New-Profile-Town" /></td>
                    
                    <th>County / Municipality</th>
                    <td id="County-Cell"><input type="text" name="New-Profile-County" /></td>
                    
                    <th>Post Code</th>
                    <td id="Post-Code-Cell"><input type="text" name="New-Profile-Post-Code" /></td>
                  </tr>
                  <tr>
                    <th colspan="6" style="background-color: #FFF;">Telephone</th>
                  </tr>
                  <tr>
                    <th>Telephone Home</th>
                    <td id="Telephone-Home-Cell"><input type="text" name="New-Profile-Telephone-Home" /></td>
    
                    <th>Telephone Mobile</th>
                    <td id="Telephone-Mobile-Cell"><input type="text" name="New-Profile-Telephone-Mobile" /></td>
    
                    <th>Telephone Other</th>
                    <td id="Telephone-Other-Cell"><input type="text" name="New-Profile-Telephone-Other" /></td>
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
                <h2>Jobe Role</h2>
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
                        <th></th>
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