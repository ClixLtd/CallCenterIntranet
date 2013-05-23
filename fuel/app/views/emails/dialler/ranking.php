<HTML>
	<HEAD>
	
	</HEAD>
	<BODY>
	
		<TABLE width="600" style="font-family: verdana; border-radius: 5px; background-color: #FFFFFF;">
			<TR>
				<TD>
					The dialler has been updated with the following rankings for staff.<br /><br />
					
					<center>
					<h2>Promotions and Demotions</h2>
					<TABLE width="550" cellpadding="2" cellspacing="0">
    					<THEAD>
        					<TR>
            					<TH width="275">Promotions</TH>
            					<TH width="275">Demotions</TH>
        					</TR>
    					</THEAD>
    					<TBODY>
        					<TR>
            					<TD><TABLE width="275" cellpadding="0" cellspacing="0">
                					<TBODY>
                    				    <?php foreach($promotions as $single): ?>
                    				    <TR>
                        					<TD><?php echo $single['name']; ?></TD>
                        				</TR>
                        				<?php endforeach; ?>
                					</TBODY>
            					</TABLE></TD>
            					<TD><TABLE width="275" cellpadding="0" cellspacing="0">
                					<TBODY>
                    				    <?php foreach($demotions as $single): ?>
                    				    <TR>
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
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Name</TH>
								<TH width="100">Referrals</TH>
								<TH width="100">Pack Outs</TH>
								<TH width="100">Points</TH>
							</TR>
						</THEAD>
						
						<TBODY>
						    <?php foreach($top as $email_data): ?>
							<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
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
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Name</TH>
								<TH width="100">Referrals</TH>
								<TH width="100">Pack Outs</TH>
								<TH width="100">Points</TH>
							</TR>
						</THEAD>
						
						<TBODY>
						    <?php foreach($bottom as $email_data): ?>
							<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
								<TD align="center"><?php echo $email_data['name']; ?></TD>
								<TD align="center"><?php echo $email_data['referrals']; ?></TD>
								<TD align="center"><?php echo $email_data['packouts']; ?></TD>
								<TD align="center"><?php echo $email_data['points']; ?></TD>
							</TR>
							<?php endforeach; ?>
						</TBODY>
						
					</TABLE>
					</center>
					
					
					Regards<br />
					Expert Money Solutions
					
				</TD>
			</TR>
		</TABLE>
	
	</BODY>
</HTML>