<script type="text/javascript" src="js/infoBox.js"></script>
<script laguage="javascript">
$(document).ready(function(){
    $('.help').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help1').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help2').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help3').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('#help').click(function(){
        $('.helper').show();
    });
    $('#help').hover(function(){
        $('.helper').hide();
    });
});
</script>