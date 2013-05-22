<HTML>
	<HEAD>
	
	</HEAD>
	<BODY>
	
		<TABLE width="600" style="font-family: verdana; border-radius: 5px; background-color: #FFFFFF;">
			<TR>
				<TD>
					The dialler has been updated with the following rankings for staff.<br /><br />
					
					<center>
					<h2>Top Staff</h2>
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Name</TH>
								<TH>Referrals</TH>
								<TH>Pack Outs</TH>
								<TH>Points</TH>
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
					<h2>Bottom Staff</h2>
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Name</TH>
								<TH>Referrals</TH>
								<TH>Pack Outs</TH>
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