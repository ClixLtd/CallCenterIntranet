<div style="float: right;">
<form id="grepDialer">
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!empty($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!empty($end_date)) ? $end_date : "" ; ?>">
<input type="submit" class="button" id="dateRangeHotkey" value="View Date Range" /><br />
</form>
</div>

<article class="full-block clearfix">

    <div class="article-container">
        <header>
            <h2>Dialler Report</h2>
            
            <!-- <nav>
                <ul class="tab-switch">
                    <li><a class="default-tab" href="#debtSolve">DebtSolve</a></li>
                    <li><a href="#Dialer">Dialer</a></li>
                </ul>
            </nav> -->
            
        </header>
    </div>
    
    <section>
        <div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Loading Report - Please Wait!</div>
    </section>

    <section>
        <div id="response"><!-- Content --></div>
    </section>

</article>


<?php echo Asset::js('reports/dialler.js'); ?>
<?php echo Asset::css('reports/hotkey.css'); ?>