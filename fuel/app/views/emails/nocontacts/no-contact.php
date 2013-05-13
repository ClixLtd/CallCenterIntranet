<HTML>
	<HEAD>
	
	</HEAD>
	<BODY>
	
		<TABLE width="600" style="font-family: verdana; border-radius: 5px; background-color: #FFFFFF;">
			<TR>
				<TD>
					In the last five minutes we have received the following transfers. These transfers are currently being shown as No Contacts due to various different statuses.<br /><br />
					
					We have included a list of these transfers for you to verify below.<br /><br />
					
					<center>
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Leadpool ID</TH>
								<TH>Status</TH>
								<TH>Name</TH>
								<TH>Office</TH>
								<TH>Time</TH>
							</TR>
						</THEAD>
						
						<TBODY>
							<?php $background = 0; ?>
							<?php foreach ($email_data AS $result): ?>
							<TR style="background-color: <?php echo ($background==0) ? "#DDDDDD" : "#EEEEEE"; ?>; border-bottom: #CCCCCC 1px solid;">
								<TD align="center"><?php echo $result['ClientID']; ?></TD>
								<TD align="center"><?php echo $result['Description']; ?></TD>
								<TD align="center"><?php echo $result['Name']; ?></TD>
								<TD align="center"><?php echo $result['Office']; ?></TD>
								<TD align="center"><?php echo date("H:i", strtotime($result['Referred Date'])); ?></TD>
							</TR>
							<?php $background = ($background==0) ? 1 : 0; ?>
							<?php endforeach; ?>
						</TBODY>
						
					</TABLE>
					</center>
					
					<br />
					
					For further details on these transfers please view the <a href="https://intranet.gregsonandbrooke.co.uk/reports/disposition">Disposition Report</a>.<br /><br />
					
					Regards<br />
					Expert Money Solutions
					
				</TD>
			</TR>
		</TABLE>
	
	</BODY>
</HTML>