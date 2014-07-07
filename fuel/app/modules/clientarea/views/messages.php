<h1>Client Messages</h1>

<div style="float: left; margin: 25px 0px 35px 0px;">
  <button type="button" type="submit" id="Create-Message-Button" class="btn btn-primary">Send a New Message</button>
  &nbsp;&nbsp;
  <button type="button" type="submit" id="Inbox-List-Button" class="btn btn-primary">Inbox</button>
  <button type="button" type="submit" id="Sent-List-Button" class="btn btn-primary">Sent</button>
  <button type="button" type="submit" id="Refresh-Message-Button" class="btn btn-primary">Refresh Messages</button>
</div>

<div style="clear: both;"><!-- --></div>

<div id="Message-List">
<table class="datatable">
    
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Client ID</th>
        <th>Client Name</th>
        <th>Subject</th>
        <th>From</th>
        <th>Date</th>
    </tr>
    </thead>
    
    <tbody>
      <?php foreach($messagesList as $message) : ?>
      <tr style="cursor: pointer;" class="Message-Row" rel="<?=$message['id'];?>">
        <td><img src="/assets/img/icons/mail/<?=$message['icon'];?>.png" /></td>
        <td><?=$message['client_id'];?></td>
        <td><?=$message['client_name'];?></td>
        <td><?=$message['subject'];?></td>
        <td><?=$message['message_from'];?></td>
        <td><?=date("d-m-Y H:i", strtotime($message['date']));?></td>
      </tr>
      <?php endforeach;?>
    </tbody>

</table>
</div>

<!-- Create a new message -->
<!-- -------------------- -->
<div id="Create-Message">
  <article class="full-block clearfix">
    <section>
      <article class="full-block">
		    <header>
					<h2>New Message</h2>
				</header>  
        <section>
          <form action="" method="post" id="New-Message-Form" enctype="multipart/form-data" encoding="multipart/form-data">
            <table>
              <tr>
                <th>To:</th>
                  <td><input type="text" name="Message-To" id="Message-To" placeholder="Enter the client's Debtsolv ID Number" style="width: 80%;" /></td>
                </tr>
                <tr>
                  <th>Subject:</th>
                  <td><input type="text" name="Message-Subject" class="Input-Required" id="Message-Subject" placeholder="Enter a Subject" style="width: 80%;" /></td>
                </tr>
                <tr>
                  <th>Message:</th>
                  <td><textarea name="Message-Body" class="Input-Required" id="Message-Body" rows="8" style="width: 80%;"></textarea></td>
                </tr>
                <tr>
                  <th>Attachment</th>
                  <td><input type="file" id="Message-Attachment" name="attachment" style="width: 80%;"/></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                    <input type="submit" id="Send-New-Message" class="btn btn-alt btn-large btn-primary" value="Send Message">
                    <input type="button" id="Cancel-New-Message" class="btn btn-alt btn-large btn-primary" value="Cancel Message">
                  </td>
                </tr>
              </table>
            </form>
            <!--//-->
            <progress id="form-response" style="display:none"></progress>
          </section>
        </article>
      </section>
   </article>
</div>
<!-- END -->
<!-- --- -->

<!-- Read a Message -->
<!-- -------------- -->
<div id="Read-Message">
  <div id="Message-Posts-List"></div>
  
  <div id="Last-Message">
    <article class="full-block clearfix">
      <section>
        <article class="full-block">
			
  				<header>
  					<h2>Message</h2><a name="last"></a>
  				</header>
          
          <section>
            <form id="form-reply" action="/clientarea/send_reply" method="post" enctype="multipart/form-data">
              <table>
                <tr>
                  <th>From:</th>
                  <td id="Latest-Post-From" style="text-align: left;"></td>
                </tr>
                <tr>
                  <th>Date:</th>
                  <td id="Latest-Post-Date" style="text-align: left;"></td>
                </tr>
                <tr>
                  <th>Message:</th>
                  <td id="Latest-Post-Body" style="text-align: left;"></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: center;">
                    <button type="button" type="submit" id="Send-Reply-Button" class="btn btn-primary">Reply</button>
                    <button type="button" type="submit" id="Close-Message-Button" class="btn btn-primary">Close</button>
                  </td>
                </tr>
              </table>
              
              <input type="hidden" name="lastThread" id="Last-Post-ID" />
              
              <table id="Reply-Form">
                <tr>
                  <th colspan="2">Send a Reply<a name="reply"></a></th>
                </tr>
                <tr>
                  <th>Message:</th>
                  <td>
                    <textarea name="Reply-Message-Body" id="Reply-Message-Body" rows="8" style="width: 80%;"></textarea>
                  </td>
                </tr>
                <tr>
                    <th>Attachment:</th>
                    <td>
                      <input type="file" name="replay-file" />
                    </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: center;">
                    <input type="hidden" name="MessageID" id="MessageID" />
                    <input type="submit" id="Send-Reply" class="btn btn-primary" value="Send">
                  </td>
                </tr>
              </table>
            </form>           
          </section>
        
        </article>
      </section>
    </article>
  </div>
  
</div>
<!-- END -->
<!-- --- -->

<?=Asset::js('messages.js');?>