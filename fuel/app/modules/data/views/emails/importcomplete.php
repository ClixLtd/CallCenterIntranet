<HTML>
	<HEAD>
	</HEAD>
	<BODY>
	
		<p>Data From <?php echo $supplierName; ?> added on <?php echo $addedDate; ?> has now been added to the dialler. Details for the imported list are shown below.</p>
		
		
		
		<TABLE width="300" cellpadding="5" cellspacing="2">
				<TR>
					<TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">List ID</TH>
					<TD><?php echo $listID; ?></TD>
				</TR>
				<TR>
					<TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">Leads Purchased</TH>
					<TD><?php echo $leadsPurchased; ?></TD>
				</TR>
				<TR>
					<TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">Duplicates</TH>
					<TD><?php echo $duplicates; ?></TD>
				</TR>
				<TR>
					<TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">TPS</TH>
					<TD><?php echo $tps; ?></TD>
				</TR>
				<TR>
					<TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">Dialable Leads</TH>
					<TD><?php echo $dialableLeads; ?></TD>
				</TR>
		</TABLE>

		<p>For a full break down of TPS, Duplicates and other stats please click the link below which will take you to the correct page on the intranet.</p>
		
		<p><a href="http://intranet.gregsonandbrooke.co.uk/data/view/<?php echo $dataID; ?>/">List <?php echo $dataID; ?> Statistics</a></p>
		
	</BODY>
</HTML>