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
  <div style="padding: 15px;">
  
    <article class="full-block clearfix">
  <section>
    <!--  Profile Details -->
    <!-- ---------------- -->
	  <article class="full-block">	
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
    
  </div>
</div>
<!-- // END -->

<?=Asset::js('human-resource.js');?>