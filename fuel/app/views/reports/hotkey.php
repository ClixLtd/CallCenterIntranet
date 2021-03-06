<div style="float: right;">
<form id="grepHotkey">
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!empty($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!empty($end_date)) ? $end_date : "" ; ?>">
<input type="submit" class="button" id="dateRangeHotkey" value="View Date Range" /><br />
<select name="agent" rel="tooltip" title="Call Agent" class="" id="agent" >
    <option value="-1">All Agents</option>
    <?php foreach($all_agents AS $item): ?>
        <option value="<?php echo $item['user_login']; ?>" <?php echo ($item['user_login'] == $agent) ? "SELECTED" : ""; ?>><?php echo $item['full_name']; ?></option>
    <?php endforeach; ?>
</select>
</form>
</div>

<article class="full-block clearfix">

    <div class="article-container">
        <header>
            <h2>Hotkey Report</h2>
            
            <nav>
                <ul class="tab-switch">
                    <li><a class="default-tab" href="#debtSolve">DebtSolve</a></li>
                    <li><a href="#Dialer">Dialer</a></li>
                </ul>
            </nav>
            
        </header>
    </div>
    
    <section>
        <div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Loading Report - Please Wait!</div>
    </section>

    <section>
        <div id="response"><!-- Content --></div>
    </section>

</article>

<script>
    var currentCenter = "<?php echo (is_null($agent)) ? "NON" : $agent; ?>";
    var reportURL = "<?php echo $url;?>";
</script>

<?php echo Asset::js('reports/hotkey.js'); ?>
<?php echo Asset::css('reports/hotkey.css'); ?>