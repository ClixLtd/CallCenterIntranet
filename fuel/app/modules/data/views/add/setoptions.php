<div class="container">
       

<form class="form-horizontal" method="post" action="/data/startimport/">
    <input type="hidden" name="filename" value="<?php echo $dataFilename; ?>">
    
    <fieldset>
        <legend>Supplier Options</legend>
        
        <select name="supplier">
            <option value="1">Supplier 1</option>
            <option value="2">Supplier 2</option>
            <option value="3">Supplier 3</option>
        </select>
        
        <input type="text" name="cost" placeholder="Cost">
        
    </fieldset>
    
    
    <fieldset>
        <legend>Checking Options</legend>
        
        <input type="checkbox" name="options[DUPES]" checked> Check for Duplicates<br />
        
        <input type="checkbox" name="options[OPTIN]"> Data is Opt-in (no TPS check needed)<br />
        
    </fieldset>
    
    
    <fieldset>
        <legend>Data File Headings</legend>
        
        <?php foreach ($allHeadings as $heading=>$headingTitle): ?>
        <div class="control-group">
            <label class="control-label" for="title"><?php echo $headingTitle; ?></label>
            <div class="controls">
                <select name="headings[<?php echo $heading; ?>]">
                    <option value="null">-- Not Given</option>
                    <?php foreach ($fileHeadings as $fileHeading): ?>
                    <option value="<?php echo $fileHeading; ?>" <?php if (isset($headingsGuess[$heading]) && $headingsGuess[$heading]==$fileHeading) echo "SELECTED"; ?>><?php echo $fileHeading; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php endforeach; ?>
        
    </fieldset>
    
    <input type="submit" value="Start Importing">
    
    
</form>

</div>