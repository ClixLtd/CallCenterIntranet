<article class="full-block clearfix">

<section>
  <article class="full-block">
    <header>
      <h2>Search Staff</h2>
    </header>
    
    <form id="findClientForm" style="margin: 0px;">
      <section>
        <div class="row-fluid">
          <div class="span12">
            <p>
            To find a staff member, type in either their Staff ID, username or name
            </p>
            <input id="clientID" class="input-xxlarge" type="text" style="width: 95%;" placeholder="Enter ID, Username or Name" />
            <div class="form-actions" style="margin-top: 15px; width: 95%; text-align: right;">
              <button id="clientIDButton" class="btn btn-alt btn-large btn-primary" type="submit">Find Staff</button>
            </div>
          </div>
        </div>
      </section>
    </form>
  </article>
</section>
  
<section>
  <article class="full-block">
    <header>
      <h2>Staff List</h2>
    </header>
    
    <section style="height: 500px; overflow: auto;">
      <div class="row-fluid">
        <div class="span12">
          <table>
            <thead>
              <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Centre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(count($staffList) > 0)
              {
                foreach($staffList as $staff)
                {
                  ?>
                  <tr>
                    <td><?=$staff['id'];?></td>
                    <td><?=$staff['name'];?></td>
                    <td><?=$staff['center'];?></td>
                    <td><a href="/hr/profiles/view/<?=$staff['id'];?>/">View Profile</a></td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?>
                <tr>
                  <td colspan="5">No Records</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>    
      </div>
    </section>
    
  </article>
</section>
	
</article>