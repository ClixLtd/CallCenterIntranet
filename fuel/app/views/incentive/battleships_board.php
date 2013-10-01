<style>

    #fullBoard
    {
        display: none;

    }

    .square
    {
        float: left;
        height: 40px;
        width: 40px;
        border: 1px solid white;
        line-height: 40px;
        text-align: center;
        font-family: Arial;
        font-weight: bold;
        font-size: 16px;
        overflow: hidden;
        color: RGBA(255,255,255,0.8);

        text-shadow: 1px 1px 0.5px RGBA(0,0,0,0.5);
    }



    .water, .waters
    {
        cursor: pointer;
        background: lightblue;
        box-shadow: 0px 0px 4px RGBA(0,0,0,0.4);
    }

    .miss
    {
        cursor: pointer;
        background: lightblue;
        box-shadow: 0px 0px 4px RGBA(200,0,0,0.4);
        text-indent: -9999px;
        background-image: URL(/assets/img/incentives/bs-miss.png) !important;
        background-repeat: no-repeat !important;
        background-size: contain !important;
        background-size: contain !important;
        background-position: center !important;
    }

    .hit
    {
        cursor: pointer;
        background: lightblue;
        box-shadow: 0px 0px 4px RGBA(200,0,0,0.4);
        text-indent: -9999px;
        background-image: URL(/assets/img/incentives/bs-shiphit.png) !important;
        background-repeat: no-repeat !important;
        background-size: contain !important;
        background-size: contain !important;
        background-position: center !important;
    }

    .sunk
    {
        cursor: pointer;
        background: lightblue;
        box-shadow: 0px 0px 4px RGBA(200,0,0,0.4);
        text-indent: -9999px;
        background-image: URL(/assets/img/incentives/bs-shipsunk.png) !important;
        background-repeat: no-repeat !important;
        background-size: contain !important;
        background-size: contain !important;
        background-position: center !important;
    }


    .target
    {
        background: RGBA(200,0,0,0.7);
        color: RGBA(255,200,200,0.8);
        text-shadow: 0px 0px 0px RGBA(0,0,0,0.5) !important;
    }
    .targetCenter
    {
        background: black;
        color: white;
    }

</style>

<center>

    <form id="takeShot" method="POST" action="/incentive/takeShot/">

        <input type="hidden" name="square" id="squarePick">

        <div id="chooseArea">
            <div style="font-size: 20px; line-height: 40px; ">
                Pick Your Player:
            </div>

            <select name="agent" id="agentChoice">
                <option value="CHOOSE">Please Choose Your Player</option>
                <?php foreach($agents AS $agent): ?>
                <option value="<?php echo $agent['network_id']; ?>"><?php echo $agent['first_name']; ?> <?php echo $agent['last_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </form>


    <div id="fullBoard">
        <?php foreach ($board AS $row => $col): ?>

        <div class="row">
            <?php foreach ($col AS $title => $square): ?>
            <div id="<?php echo $row."-".$title; ?>" rel="tooltip" class="row-<?php echo $row; ?> col-<?php echo $title; ?> square <?php
                switch($square['type']){
                    case 'M':
                        echo 'miss" title="'.$square['agent'].' Missed Everything!';
                        break;
                    case 'H':
                        echo 'hit" title="'.$square['agent'].' Hit a Ship';
                        break;
                    case 'S':
                        echo 'sunk" title="'.$square['agent'].' Sunk a Ship!!';
                        break;
                    default:
                        echo 'water';
                        break;
                }
            ?>"><?php echo $title.$row; ?></div>
            <?php endforeach; ?>
        </div>

        <?php endforeach; ?>
    </div>

    <div id="viewBoard">
        <?php foreach ($board AS $row => $col): ?>

            <div class="row">
                <?php foreach ($col AS $title => $square): ?>
                    <div id="<?php echo $row."-".$title; ?>" rel="tooltip" class="row-<?php echo $row; ?> col-<?php echo $title; ?> square <?php
                    switch($square['type']){
                        case 'M':
                            echo 'miss" title="'.$square['agent'].' Missed Everything!';
                            break;
                        case 'H':
                            echo 'hit" title="'.$square['agent'].' Hit a Ship';
                            break;
                        case 'S':
                            echo 'sunk" title="'.$square['agent'].' Sunk a Ship!!';
                            break;
                        default:
                            echo 'waters';
                            break;
                    }
                    ?>"><?php echo $title.$row; ?></div>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </div>

</center>

<script>

    $('#agentChoice').change(function() {

        if ($(this).val() != 'CHOOSE')
        {
            $('#chooseArea').hide();
            $('#viewBoard').hide();
            $('#fullBoard').show();
        }

    });

    $(".water").click(function() {
        var selects = $(this).attr('id').split('-');
        $('#squarePick').val(selects[1]+selects[0]);
        $('#takeShot').submit();
    });

    $(".water").hover(function() {
        $(".square").removeClass('target');
        $(".square").removeClass('targetCenter');
        var selects = $(this).attr('id').split('-');

        $(".row-"+selects[0]).addClass('target');
        $(".col-"+selects[1]).addClass('target');

        $(this).removeClass('target');
        $(this).addClass('targetCenter');
    });


</script>