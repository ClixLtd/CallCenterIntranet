<HTML>
	<HEAD>
	
	</HEAD>
	<BODY>
	
		<TABLE width="600" style="font-family: verdana; border-radius: 5px; background-color: #FFFFFF;">
			<TR>
				<TD>
					A new first payment has been received. The details are as follows.<br /><br />
					
					<center>
					<TABLE width="550" cellpadding="2" cellspacing="0">
						<THEAD>
							<TR style="background-color: #FFFFFF; border-bottom: #CCCCCC 1px solid; border-top: #CCCCCC 1px solid;">
								<TH>Client ID</TH>
								<TH>DI</TH>
								<TH>Office</TH>
							</TR>
						</THEAD>
						
						<TBODY>
							<TR style="background-color: #EEEEEE; border-bottom: #CCCCCC 1px solid;">
								<TD align="center"><?php echo $email_data['clientID']; ?></TD>
								<TD align="center"><?php echo $email_data['di']; ?></TD>
								<TD align="center"><?php echo $email_data['office']; ?></TD>
							</TR>
						</TBODY>
						
					</TABLE>
					</center>
					
					<br />
					
					For further details please search for the client ID above in Debtsolv.<br /><br />
					
					Regards<br />
					Expert Money Solutions
					
				</TD>
			</TR>
		</TABLE>
	
	</BODY>
</HTML>