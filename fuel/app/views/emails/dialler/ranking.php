<HTML>
	<HEAD>
	
	</HEAD>
	<BODY>
	
		<TABLE width="600" style="font-family: verdana; border-radius: 5px; background-color: #FFFFFF;">
			<TR>
				<TD>
					Based on the sales statistics for <?php echo date('d/m/Y', $chosendate); ?> the dialler groups have been updated as shown below.<br /><br />
					
					<center>
					<h2>Promotions and Demotions</h2>
					<TABLE width="650" cellpadding="2" cellspacing="0">
    					<THEAD>
        					<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
            					<TH width="50%">Promotions</TH>
            					<TH width="50%">Demotions</TH>
        					</TR>
    					</THEAD>
    					<TBODY>
        					<TR>
            					<TD valign="top"><TABLE width="100%" cellpadding="2" cellspacing="0">
                					<TBODY>
                    				    <?php foreach($promotions as $single): ?>
                    				    <TR>
                        					<TD><b><?php echo $single['center']; ?></b></TD>
                        					<TD><?php echo $single['name']; ?></TD>
                        				</TR>
                        				<?php endforeach; ?>
                					</TBODY>
            					</TABLE></TD>
            					<TD valign="top"><TABLE width="100%" cellpadding="2" cellspacing="0">
                					<TBODY>
                    				    <?php foreach($demotions as $single): ?>
                    				    <TR>
                        					<TD><b><?php echo $single['center']; ?></b></TD>
                        					<TD><?php echo $single['name']; ?></TD>
                        				</TR>
                        				<?php endforeach; ?>
                					</TBODY>
            					</TABLE></TD>
        					</TR>
    					</TBODY>
					</TABLE>
					
					<hr size="1" color="#EEEEEE" width="500">
					
					<h2>Premier Campaign</h2>
					<TABLE width="650" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
								<TH width="50">Center</TH>
								<TH>Name</TH>
								<TH width="100">Referrals</TH>
								<TH width="80">Pack Outs</TH>
								<TH width="50">Points</TH>
							</TR>
						</THEAD>
						
						<TBODY>
						    <?php foreach($top as $email_data): ?>
							<TR>
							    <TD align="center"><?php echo $email_data['center']; ?></TD>
								<TD align="center"><?php echo $email_data['name']; ?></TD>
								<TD align="center"><?php echo $email_data['referrals']; ?></TD>
								<TD align="center"><?php echo $email_data['packouts']; ?></TD>
								<TD align="center"><?php echo $email_data['points']; ?></TD>
							</TR>
							<?php endforeach; ?>
						</TBODY>
						
					</TABLE>
					</center>
					
					<br />
					
				    <center>
					<h2>Standard Campaign</h2>
					<TABLE width="650" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
							    <TH width="100">Center</TH>
								<TH>Name</TH>
								<TH width="80">Referrals</TH>
								<TH width="80">Pack Outs</TH>
								<TH width="50">Points</TH>
							</TR>
						</THEAD>
						
						<TBODY>
						    <?php foreach($bottom as $email_data): ?>
							<TR>
							    <TD align="center"><?php echo $email_data['center']; ?></TD>
								<TD align="center"><?php echo $email_data['name']; ?></TD>
								<TD align="center"><?php echo $email_data['referrals']; ?></TD>
								<TD align="center"><?php echo $email_data['packouts']; ?></TD>
								<TD align="center"><?php echo $email_data['points']; ?></TD>
							</TR>
							<?php endforeach; ?>
						</TBODY>
						
					</TABLE>
					</center>
					
					<br />
					
					
				</TD>
			</TR>
		</TABLE>
	
	</BODY>
</HTML>